<?php
/**
	##违章查询 车辆管理 违章处理 违章提醒
	##
**/
class IllegalAction extends CommonAction{
	#违章查询#
	public function index(){
		$this->IsUser();
		$this->title = '违章查询';
		// 检查是否VIP
		$this->isvip = M('user_list')->where(array('openid'=>$_SESSION['openid'],'type'=>2,'expire'=>array('egt',NOW_TIME)))->getField('viptype');
		$this->display();
	}

	#我的车辆#
	public function carlist(){
		$this->IsUser();
		if(IS_GET){
			$this->title = '我的车辆';
			$p = I('p',1);
			$map = array();
			$map['openid'] = $_SESSION['openid'];
			if($id) $map['id'] = $id;
			$map['status'] = array('egt',0);
			$model = M('illegal_carlist');
			import('@.ORG.Util.Page');// 导入分页类   
			$list = $model->where($map)->page($p.',5')->select();
			if(!$list) exit(U('Illegal/index','','',true));
			$this->assign('list',$list);// 赋值数据集
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
			$page 	= new Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数
			$page->setConfig('theme','%upPage%  %linkPage%  %downPage%');
			$page->rollPage = 3 ;
			$show	= $page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			//查询是否是vip
			$this->isvip = M('user_list')->where(array('openid'=>$_SESSION['openid'],'type'=>2,'expire'=>array('egt',NOW_TIME)))->getField('viptype');
			//分页跳转的时候保证查询条件
			foreach($map as $key=>$val) {
				$page->parameter   .=   "$key=".urlencode($val).'&';
			}
			$this->display();
		}else{
			// 删除车辆
			$file  = 'log.txt';
			$id = I('id');
			$t = I('t'); //操作
			//file_put_contents($file, "id：".$id.","."t:".$t.",",FILE_APPEND);
			if($t == 2){
				// 开启提醒
				$r = M('illegal_carlist')->where(array('id'=>$id,'openid'=>$_SESSION['openid']))->setField('remind',1);
			}else if($t == 1){
				// 关闭提醒
				$r = M('illegal_carlist')->where(array('id'=>$id,'openid'=>$_SESSION['openid']))->setField('remind',0);
			}else{
				//if($id || $t) $content = "id和$t成功传入";
				// 删除车辆
				$r = M('illegal_carlist')->where(array('id'=>$id,'openid'=>$_SESSION['openid']))->delete();
				//$content = '删除编号为'.$id."的车辆";
				//if($r) file_put_contents($file, $content,FILE_APPEND);
			}
			if($r){

				json('操作成功!',1);
			}else{
				json('操作失败!');
			}
		}
	}

	#违章结果#
	public function reslist(){
		$this->IsUser();
		$this->title = '违章记录';
		$id = I('id'); //绑定车辆ID
		if($id){
			$car = M('illegal_carlist')->where(array('id'=>$id,'openid'=>$_SESSION['openid']))->find();
		}
		if(IS_AJAX){
			//用户选择保存信息
			if(I('save') == 1){
				$data = array();
				$data['openid'] = $_SESSION['openid'];
				$data['hphm'] = strtoupper(I('cphm'));//车牌号码
				$data['hpzm'] = strtoupper(I('province').I('cpzm'));//车牌地区
				$data['clsbdh'] = strtoupper(I('clsbdh'));
				$data['addtime'] = NOW_TIME;
				$data['remind'] = I('remind');
				$data['checktime'] = strtotime(I('appDate'));
				$data['type'] = I('type');
				$num = M('illegal_carlist')->where(array('openid'=>$_SESSION['openid']))->count();
				//插入数据库
				if($num < 5) $r = M('illegal_carlist')->add($data);
				if($r){
					json(U('Illegal/reslist',array('id'=>$r)),1);
				}else{
					json("查询失败,最多保存5个车辆信息",0);
				}
			}
		}
		//用户不保存信息
		if(I("save") == "0"){
			$car['hphm']= strtoupper(I('cphm'));//车牌号码
			$car['hpzm']= strtoupper(I('province').I('cpzm'));//车牌地区
			$car['clsbdh'] = strtoupper(I('clsbdh'));
			$car['type'] = I('type');
		}
		import('@.ORG.Illegal');
		$Illegal = new Illegal;
		$list = $Illegal->CarIll($car['hphm'],$car['hpzm'],$car['clsbdh'],'0'.$car['type']);
		if($list['errCode'] == 1 && strpos($list['msg'],'查询到') === false){
			// 如果是新保存的车辆
			if($r) M('illegal_carlist')->where(array('id'=>$r,'openid'=>$_SESSION['openid']))->delete();
			alert('车辆信息有误！');
		}
		$this->cphm = $car['hpzm'].$car['hphm'];
		$this->type = $car['type'];
		$isvip = M('user_list')->where(array('openid'=>$_SESSION['openid']))->getField('type');
		// 判断可处理的违章
		
		for ($i=0; $i < count($list['resultData']); $i++) { 
			 //不支持在线缴费处理的
			if($car['hpzm'] != '豫A'){
				$list['resultData'][$i]['disable'] = 1;	
				$this->acount = 0;
			} else{
				$n = 0;
				foreach($list['resultData'] as $key=>$value){
				$xh=md5($value['wfxwdm'].$value['hphm'].$value['wfdz'].$value['wfsj']);
				$map = array();
				$map['xh'] = $xh;
				$map['status'] = array('gt',1);
				$paycount = M('illegal_orderson')->where($map)->count();
					if($paycount > 0){
						$list['resultData'][$key]['disable'] = 2;
						$n ++;
					}
				}
				$this->acount =count($list['resultData'])-$n;
			}
		}
		//查找已支付/处理订单
		$n = 0;
		
		$this->isvip = $isvip;
		$this->assign('info',$list['resultData']);
		//未处理违章条数
		$this->count = count($list['resultData']);
		$total = 0;//罚款金额
		$wjf = 0; //初始化未缴费违章条数
		$score = 0;//总计扣分
		foreach($list['resultData'] as $k=>$v){
			if($list[$k]['disable'] == ''){
				$total += $v[fkje];
				$wjf ++;
				$score += $v[wfjfs];
			}
		}
		$this->wjf = $wjf;
		$this->total = $total;
		$this->score = $score;
		//扣分和罚款信息插入数据库
		$arr = array('fk'=>$total,'kf'=>$score,'wz'=>count($list['resultData']));
		M('illegal_carlist')->where(array('id'=>$id,'openid'=>$_SESSION['openid']))->save($arr);
		$this->display();
	}

	#删除未缴费订单和子订单#
	public function DelOrder($hphm){
		$this->IsUser();
		$map=array();
		$map['hphm'] = $hphm;
		$map['openid'] = $_SESSION['openid'];
		$map['status'] = 1;
		$list = M('illegal_order')->where($map)->select();
		if($list != ''){
			foreach($list as $key=>$value ){
				M('illegal_orderson')->where(array('pid'=>$value['id']))->delete();
			}
			M('illegal_order')->where($map)->delete();
		}
		
		
	}

	/**
		###########################后台######################################
	**/
	#车辆违章列表#
	public function illegallist(){
		$this->IsAdm(true);
		if (IS_GET) {
			if (IS_AJAX) {
				$id = I("id");
				$r = I("r");
				$t = M("illegal_carlist")->where(array('id'=>$id))->setField(array('remind'=>$r));
				if ($t) {
					json("设置成功",1);
				}else{
					json('设置失败!');
				}
			}
			$this->title = "车辆列表";
			$this->eq = "违章服务";
			$p = I("p",1);
			$id = I("id");
			$word = I("word");
			$openid = I("car");
			$map = array();
			if ($word)$map['syr|clpp1|hphm'] = array("like","%".$word."%");
			if ($openid) $map['openid'] = $openid; 
			$map['status'] = array('egt',0);
			if ($stat) $map['status'] = $stat;
			$model = M("illegal_carlist");
			import('@.ORG.Util.Page');// 导入分页类
			$list = $model->where($map)->page($p.',10')->order("addtime desc")->select();
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
			$page 	= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
			$page->setConfig('theme','%upPage%  %linkPage%  %downPage%');
			$page->rollPage = 5 ;
			$show	= $page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			//分页跳转的时候保证查询条件
			foreach($map as $key=>$val) {
				$page->parameter   .=   "$key=".urlencode($val).'&';
			}
			$this->assign('list',$list);
			$this->display();

		}else{
			$id = I("id");
			$r = M("illegal_carlist")->where(array('id'=>$id))->delete();
			if ($r) {
				json("删除成功",1);
			}else{
				json("删除失败");
			}
		}
	}
	#车辆详情#
	public function IlleInfo(){
		$this->IsAdm(true);
		$info = M("illegal_carlist")
		->where(array('id'=>$_GET['id']))
		->find();
		$this->assign("info",$info);
		$this->display();
	}

	#后台违章列表#
	public function illegalorder(){
		$this->IsAdm(true);
		$this->title = "违章代缴列表";
		$this->eq = "违章服务";
		if(IS_GET){
			if(IS_AJAX){
				$id = I('id');
				$t = I('t');
				$info = M('illegal_order')->where(array('id'=>$id))->find();
				if($t == -1) $r = M('illegal_order')->where(array('id'=>$id))->setField('status',$t);
				if($t == 0 ){
					//取消并退款
					if($info['wxpayid'] != ''){
						$res = $this->WxRefund($info['wxpayid'],$info['orderid'],$info['total']);
						if(!$res) json('退款失败');
						$r = M('illegal_order')->where(array('id'=>$id))->setField(array('status'=>$t,'donetime'=>NOW_TIME));
					}else{
						$r = M('illegal_order')->where(array('id'=>$id))->setField(array('status'=>$t,'donetime'=>NOW_TIME));
					}
				}
				if($r){
					$this->SendTpl("quxiao",$info['openid']);
					json('操作成功！',1);
				}else{
					json('状态未改变');
				}
			}
			$p = I("p",1);
			$id = I("id");
			$word = I("word");
			$map = array();
			if ($word)$map['name|hphm'] = array("like","%".$word."%");
			if ($openid) $map['openid'] = $openid; 
			$map['status'] = array('egt',0);
			if ($stat) $map['status'] = $stat;
			$model = M("illegal_order");
			import('@.ORG.Util.Page');// 导入分页类
			$list = $model->where($map)->page($p.',10')->order("addtime desc")->select();
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
			$page 	= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
			$page->setConfig('theme','%upPage%  %linkPage%  %downPage%');
			$page->rollPage = 5 ;
			$show	= $page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			//分页跳转的时候保证查询条件
			foreach($map as $key=>$val) {
				$page->parameter   .=   "$key=".urlencode($val).'&';
			}
			$this->assign('list',$list);
			$this->display();
		}else{
			$data = array();
			$data['id'] = I('id');
			$data['ticket'] = I('ticket');
			$data['donetime'] = NOW_TIME;
			$data['status'] = 3;
			$r = M('illegal_order')->where(array('id'=>I('id')))->save($data);
			$info = M('illegal_order')->where(array('id'=>I('id')))->find();
			if($r){
				$list = M('illegal_orderson')->where(array('pid'=>$info['id']))->select();
				foreach($list as $k=>$v){
					M('illegal_orderson')->where(array('id'=>$v['id']))->setField('status',3);
				}
				$this->SendTpl("tongguo",$info['openid'],$info['hphm'],$info['addtime']);
				json('操作成功',1);
			}else{
				json('操作失败');
			}

		}
	}

	#代缴订单详情#
	public function IllegalOrderInfo(){
		$this->IsAdm(true);
		$id = I('id');
		$ticket = M('illegal_order')->where(array('id'=>$id))->getField('ticket');
		$list = M('illegal_orderson')->where(array('pid'=>$id))->select();
		$this->assign('list',$list);
		$this->ticket=$ticket;
		$this->display();
	}

	#生成代缴订单#
	public function makeorder(){
		$this->IsUser(true);
		$data = array();
		$js = $_POST['json'];
		$json = json_decode($js,true);
		$data['hphm'] = I('cphm');
		$data['hpzl'] = "0".I('type');
		$data['total'] = I('total');
		$data['sfz'] = I('sfz');
		$data['xsz'] = I('xsz');
		$data['name'] = I('name');
		$data['tel'] = I('tel');
		$data['openid'] = $_SESSION['openid'];
		$data['addtime'] = NOW_TIME;
		$data['status'] = 1;
		$data['orderid'] = strtoupper(md5($data['openid'].$data['total'].$data['addtime']));
		//删除未付款订单
		$this->DelOrder($data['hphm']);
		$r = M('illegal_order')->add($data);
		if($r){
			$this->SaveData($json,$r,I('cphm'));
			json(U("Illegal/illegaluserorder",array('id'=>$r),'','',true),1);
		}else{
			json('提交失败');
		}
		
		
	}

	#违章订单具体信息存入数据库#
	protected function SaveData($data,$pid,$hphm){
		foreach($data as $k=>$v){
			$info = array();
			$info['pid'] = $pid ;
			$info['wfnr'] = $v['info'] ;
			$info['hphm'] = $hphm ;
			$info['xh'] = md5($v['id'].$hphm.$v['occur_area'].$v['occur_date']) ;
			$info['fkje'] = $v['fkje'] ;
			$info['wfxw'] = $v['id'] ;
			$info['wfjfs'] = $v['fen'] ;
			$info['wfdz'] = $v['occur_area'] ;
			$info['wfsj'] = $v['occur_date'] ;
			$info['status'] = 1 ;
			M('illegal_orderson')->add($info);

		}
	}

	#用户违章待支付订单页面#
	public function illegaluserorder(){
		$this->IsUser(true);
		$this->title = "违章缴费";
		$this->eq = "车友服务";
		$id = I('id');
		$info = M('illegal_order')->where(array('id'=>$id))->find();
		$this->assign('info',$info);
		$this->display();
	}
	
	#用户违章订单列表页面#
	public function illegaluserorderlist(){
		$this->IsUser(true);
		$this->title = "违章订单";
		$this->eq = "会员中心";
		$id = I('id');
		$openid = I('openid');
		$list = M('illegal_order')->where(array('openid'=>$_SESSION['openid'],'status'=>array('gt',1)))->order('addtime desc')->select();
		$this->assign('list',$list);
		$this->display();
	}

	#用户取消订单#
	public function DelMark(){
		$this->IsUser(true);
		$id = I('id');
		$info = M('illegal_order')->where(array('id'=>$id))->find();
		if($info['wxpayid'] != ''){
			$res = $this->WxRefund($info['wxpayid'],$info['orderid'],$info['total']);
			if(!$res) json('退款失败');
			$r = M('illegal_order')->where(array('id'=>$id))->setField('status',0);
		}else{
			$r = M('illegal_order')->where(array('id'=>$id))->setField('status',0);
		}
		if($r){
			json("操作成功",1);
		}else{
			json("操作失败");
		}
	}

	#支付订单#
	public function PayIllegal(){
		$this->IsUser(true);
		$id = I('id');
		//支付订单信息
		$info = M('illegal_order')->where(array('id'=>$id,status=>array('gt',0)))->find();
		if(!$info) alert('该订单不存在或状态异常!',U('Index/index'));
		//查询相同车牌号码违章缴费记录
		$paied = M('illegal_order')->where(array('hphm'=>$info['hphm'],'status'=>array('egt',2)))->select();
		if($paied != ''){
			foreach($paied as $paykey=>$payval){
				$payid = $payval['id'];
				//查找已支付的违章
				$paiedIll = M('illegal_orderson')->where(array('pid'=>$payid))->select();
				//查找待支付订单中的违章
				$count = M('illegal_orderson')->where(array('pid'=>$info['id']))->select();
				foreach($paiedIll  as $kIll=>$vIll){
					foreach($count as $kcount=>$vcount){
						if($vcount['xh'] == $vIll['xh']) json('订单中有已支付违章！',1);
					}
					
				}
			}
		}else{
			// 获取微信支付参数
			$js = $this->SetWxPay($info['orderid'],$info['total'],U('Wx/PayCallBack','','','',true),'违章缴费','Illegal/PayIllegalNotify');
			exit($js);
		}
	}

	#支付通知#
	public function PayIllegalNotify($log){
		import("@.ORG.WeiXin");
		$WX = new WeiXin();
        if(!$WX->CheckSign($log)) return false;
		$info = M('illegal_order')->where(array('orderid'=>$log['out_trade_no']))->find();
		if(!$info || $info['status'] != 1) return false;
		if($this->PayIllegalPaied($info['id'],$log)){
			// 发送模版消息提醒
			$msg = array() ;
			$msg['template_id'] = "EOjwPm-E_Jqtt9hdVBvh-njm9imLR2lciSQwG2xboN4";
			$msg['url'] = U('Sys/login','','','',true);
			$msg['data'] = array(
				'first'=>array(
					'value'=>'收到新的违章缴费代办订单！',
					'color'=>'#44B549',
					),
				"productType"=>array(
					'value'=>"服务",
					'color'=>'#666666',
					),
				"name"=>array(
					'value'=>'name',
					'color'=>'#666666',
					),
				"time"=>array(
					'value'=>date('Y-m-d H:i:s'),
					'color'=>'#666666',
					),
				"result"=>array(
					'value'=>'等待处理',
					'color'=>'#666666',
					),
				"remark"=>array(
					'value'=>'点击进入后台管理。',
					'color'=>'#999999',
					),
				);
			$this->TplMsg($msg,'oGsX1t5xPYsfLYxBy6QrgSUIaaW4');
			exit("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
		}
	}

	#违章缴费支付完成#
	protected function PayIllegalPaied($id,$log = false){
		$info = M('illegal_order')->where(array('id'=>$id))->find();
		if(!$info || $info['status'] != 1) return false;
		$data = array();
		if($log['transaction_id']) $data['wxpayid'] = $log['transaction_id'];
		if($log['time_end']) $data['paytime'] = strtotime($log['time_end']);
		if(!$data['paytime']) $data['paytime'] = NOW_TIME;
		$data['status'] = 2;
		$r = M('illegal_order')->where(array('id'=>$info['id']))->save($data);
		if(!$r) return false;
		$list = M('illegal_orderson')->where(array('pid'=>$info['id']))->select();
		foreach($list as $k=>$v){
			M('illegal_orderson')->where(array('id'=>$v['id']))->setField('status',2);
		}
	}

	#违章详情#
	public function illegaluserorderinfo(){
		$this->IsUser(true);
		$this->title = "违章详情";
		$id = I('id');
		$list = M('illegal_orderson')->where(array('pid'=>$id))->select();
		$this->assign('list',$list);
		$this->display();
	}

	#发送模板消息#
	protected function SendTpl($info,$touser,$hphm,$time,$wzdz='',$wznr=''){
		return false;
		$data = array();
		$data['url'] = U('User/index','','','',true);
		$data['topcolor'] = "#FF0000";
		switch($info){
			case "tongguo";
				$data['template_id'] = "HF8-xo5jKLkdz5Nnl0E3suFn2YWR8RbrV_BdIkgMf5k";
				$data['data'] = array(
					"first"=>array(
						'value'=>"尊敬的客户，您的违章代办已经完成",
						'color'=>'#000000',
						),
					"keyword1"=>array(
						'value'=>$hphm,
						'color'=>'#000000',
						),
					"keyword2"=>array(
						'value'=>date('Y年m月d日 H:i',$time),
						'color'=>'#000000',
						),
					"remark"=>array(
						'value'=>"请您知悉，谢谢！",
						'color'=>'#000000',
						),
					);
				$this->TplMsg($data,$touser);
			break;
			case "quxiao";
				$data['template_id'] = "S7DeUuDQLx-_xDk2hESOEvqFPWA-p1yaf5dBtjacqII";
				$data['data'] = array(
					"first"=>array(
						'value'=>"您的违章代缴申请被取消",
						'color'=>'#000000',
						),
					"keyword1"=>array(
						'value'=>管理员取消,
						'color'=>'#000000',
						),
					"keyword2"=>array(
						'value'=>date('Y年m月d日 H:i'),
						'color'=>'#000000',
						),
					"remark"=>array(
						'value'=>"请您知悉，谢谢！",
						'color'=>'#000000',
						),
					);
				$this->TplMsg($data,$touser);
			break;
			case "new";
				$data['template_id'] = "rrc3ICTDjNWhb3dXzhSSccgS-x25LmtQ9xPoqfgBtAk";
				$data['data'] = array(
					"first"=>array(
						'value'=>"您好，您有一条新的违章",
						'color'=>'#000000',
						),
					"keyword1"=>array(
						'value'=>$hphm,
						'color'=>'#000000',
						),
					"keyword2"=>array(
						'value'=>date('Y年m月d日 H:i',$time),
						'color'=>'#000000',
						),
					"keyword3"=>array(
						'value'=>$wzdz,
						'color'=>'#000000',
						),
					"keyword4"=>array(
						'value'=>$wznr,
						'color'=>'#000000',
						),
					"remark"=>array(
						'value'=>"请及时处理，以免产生滞纳金或被扣车等情况。",
						'color'=>'#000000',
						),
					);
				$this->TplMsg($data,$touser);
			break;
		}
	}
}