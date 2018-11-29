<?php
/**
##代办审车 2017.5.4 By.杨林
**/
class DbscAction extends CommonAction{
	
	#服务主页#
	public function index(){
		$this->WxAuth(true);
		if(IS_GET){
			$this->title = '代办审车';
			$this->display();
		}else{
			$data = I('post.');
			if(!$data['name'] || !$data['tel'] || !$data['adr']) json('请填写姓名电话及收件地址!');
			$data['cphm'] = $data['cpzm'].strtoupper($data['cphm']);
			// 检查有没有违章
			//if(!$this->GetCarInfo($data['cphm'],'02',$data['name'])) json('车主姓名验证失败!');
			//if($this->GetCarIll($data['cphm'])) json('该车辆有未处理违章，请处理完毕再进行操作!');
			// 删除该用户所有待支付的订单
			M('dbsc_order')->where(array('openid'=>$_SESSION['openid'],'status'=>1))->delete();
			// 保存数据
			$data['openid'] = $_SESSION['openid'];
			$data['total'] = 98; //订单总金额
			$data['orderid'] = strtoupper(md5($data['openid'].$data['total'].NOW_TIME));
			$data['addtime'] = NOW_TIME;
			$data['status'] = 1;
			$id = M('dbsc_order')->add($data);
			if(!$id) json('订单创建失败!');
			// 生成支付参数
			$res = $this->SetWxPay($data['orderid'],$data['total'],U('Wx/PayCallBack','','','',true),'年检代办服务','Dbsc/PayCallBack');
			if(!$res) json('获取支付参数失败，请联系管理员!');
			json(array('total'=>$data['total'],'js'=>json_decode($res,true)),1);
		}
	}


	#完成订单支付#
	protected function OrderPaied($id,$log=false){
		$info = M('dbsc_order')->where(array('id'=>$id))->find();
		if(!$info || $info['status'] != 1) return false;
		$data = array();
		if($log['transaction_id']) $data['wxpayid'] = $log['transaction_id'];
		if($log['time_end']) $data['paytime'] = strtotime($log['time_end']);
		if(!$data['paytime']) $data['paytime'] = NOW_TIME;
		$data['status'] = 2;
		$r = M('dbsc_order')->where(array('id'=>$info['id']))->save($data);
		if(!$r) return false;
		return true;
	}

	#支付完成通知#
	public function PayCallBack($log){
		import("@.ORG.WeiXin");
		$WX = new WeiXin();
        if(!$WX->CheckSign($log)) return false;
		$info = M('dbsc_order')->where(array('orderid'=>$log['out_trade_no']))->find();
		if(!$info || $info['status'] != 1) return false;
		if($this->OrderPaied($info['id'],$log)){
			// 提醒
			// 发送模版消息提醒
			$msg = array() ;
			$msg['template_id'] = "EOjwPm-E_Jqtt9hdVBvh-njm9imLR2lciSQwG2xboN4";
			$msg['url'] = U('Sys/login','','','',true);
			$msg['data'] = array(
				'first'=>array(
					'value'=>'收到新的年审代办订单！',
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



	/**
		## 后台管理
	**/

	#订单列表#
	public function orderlist(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '申请列表';
			$this->eq = '代办审车';
			$word = I('word');
			$id = I('id');
			$p = I('p',1);
			$map = array();
			if($id) $map['id'] = $id;
			if($word) $map['name|tel|adr'] = array('like','%'.$word.'%');
			$map['status'] = array('gt',1);
			$model = M('dbsc_order');
			import('@.ORG.Util.Page');// 导入分页类   
			$list = $model->where($map)->page($p.',15')->order('addtime desc')->select();
			$this->assign('list',$list);// 赋值数据集
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
			$page 	= new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
			$page->setConfig('theme','%upPage%  %linkPage%  %downPage%');
			$page->rollPage = 5 ;
			$show	= $page->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出
			//分页跳转的时候保证查询条件
			foreach($map as $key=>$val) {
				$page->parameter   .=   "$key=".urlencode($val).'&';
			}
			$this->display();
		}else{
			// 订单取消
			$id = I('id');
			$info = M('dbsc_order')->where(array('id'=>$id))->find();
			if(!$info) json('订单不存在!');
			if($info['wxpayid']){
				// 执行退款操作
				if(!$this->WxRefund($info['wxpayid'],$info['orderid'],$info['total'])) json('退款操作失败!');
			}
			$r = M('dbsc_order')->where(array('id'=>$id))->save(array('status'=>0,'donetime'=>NOW_TIME));
			if($r){
              	R('Little/Notify2',array($info));
				json('订单已成功取消!',1);
			}else{
				json('操作失败!');
			}
		}
	}

	#订单详情#
	public function OrderInfo(){
		$this->IsAdm(true);
		$id = I('id');
		$info = M('dbsc_order')->where(array('id'=>$id))->find();
		$this->assign('info',$info);
		$this->display();
	}

	#订单基寄出#
	public function DoneOrder(){
		$this->IsAdm(true);
		$data = I('post.');
		$info = M('dbsc_order')->where(array('id'=>$data['id']))->find();
		if($info['status'] != 2) json('状态错误!');
		unset($data['id']);
		$data['donetime'] = NOW_TIME;
		$data['status'] = 5;
		$r = M('dbsc_order')->where(array('id'=>$info['id']))->save($data);
		if($r){
			// 发送模版消息提醒
            if($info['formid']){
              R('Little/Notify1',array($info)); //小程序提醒
            }else{
              $msg = array() ;
              $msg['template_id'] = "HhLaENNS9QWwKsSZNEiTE769Zug9LkRgk3QayLbAsMk";
              $msg['data'] = array(
                  'first'=>array(
                      'value'=>'您的免检车标及环保标已寄出！',
                      'color'=>'#44B549',
                      ),
                  "keyword1"=>array(
                      'value'=>"免检车标及环保标",
                      'color'=>'#666666',
                      ),
                  "keyword2"=>array(
                      'value'=>1,
                      'color'=>'#666666',
                      ),
                  "keyword3"=>array(
                      'value'=>date('Y-m-d H:i:s'),
                      'color'=>'#666666',
                      ),
                  "keyword4"=>array(
                      'value'=>$data['kdname'],
                      'color'=>'#666666',
                      ),
                  "keyword5"=>array(
                      'value'=>$data['kdno'],
                      'color'=>'#666666',
                      ),
                  "remark"=>array(
                      'value'=>'感谢您选择我们的服务!',
                      'color'=>'#999999',
                      ),
                  );
              $this->TplMsg($msg,$info['openid']);
            }
			json('订单处理完成!',1);
		}else{
			json('操作失败!');
		}
	}

}