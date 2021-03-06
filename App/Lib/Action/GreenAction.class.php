<?php 
/**
* 环保标办理
*/
class GreenAction extends MiniAction
{
	#下单#
	public function MakeOrder(){
		$this->IsCached();
		$data = json_decode(file_get_contents("php://input"),true);
		//do something...
		$data['status'] = 1;
		$data['addtime'] = NOW_TIME;
		$data['orderid'] = md5(NOW_TIME.$data['cphm'].$this->openid);
		$cpm = $this->FindCph($data['cp']);
		$data['cphm'] = $cpm.$data['cphm'];
		$data['cpm'] = $data['cp'];
		$data['form_id'] = $data['formid'];
		$data['openid'] = $this->openid;
		$data['fee'] = C('GREEN_CARD');
		$r = M('car_greenlist')->add($data);
		if($r){
			exit(json_encode(array('code'=>1,'id'=>$r)));
		}else{
			exit(json_encode(array('code'=>0)));
		}
	}


		#邮寄信息#
	public function GetPost(){

		$id = I('id');
		$info = M('car_greenlist')->where(array('id'=>$id))->find();
			$info['a1'] = M('sys_location')->where(array('id'=>$info['a1']))->getField('name');
		$info['a2'] = M('sys_location')->where(array('id'=>$info['a2']))->getField('name');
		$info['a3'] = M('sys_location')->where(array('id'=>$info['a3']))->getField('name');

		exit(json_encode($info));
	}

	#我的订单.#
	public function myorder(){
		$this->IsCached();
		$list = $this->GetOrder('car_greenlist',$map);
		if(!$list) exit(json_encode(array('code'=>0)));
		exit(json_encode(array('code'=>1,'list'=>$list)));
	}

	#订单详情#
	public function orderinfo(){
		$this->IsCached();
		$id = I('get.id');
		$info = M('car_greenlist')->where(array('id'=>$id))->find();
		if(!$info) exit(json_encode(array('code'=>0,'msg'=>'订单不存在')));
		$info['a1'] = M('sys_location')->where(array('id'=>$info['a1']))->getField('name');
		$info['a2'] = M('sys_location')->where(array('id'=>$info['a2']))->getField('name');
		$info['a3'] = M('sys_location')->where(array('id'=>$info['a3']))->getField('name');
		exit(json_encode(array('code'=>1,'info'=>$info)));
	}

	#支付参数#
	public function GetPay(){
		$this->IsCached();
		$id  = I('get.id');
		$order = M('car_greenlist')->where(array('id'=>$id,'status'=>1,'openid'=>$this->openid))->find();
		if(!$order) exit(json_encode(array('code'=>0,'msg'=>'订单信息不存在')));
			$pay = $this->PayConf($order['orderid'],$order['fee'],'环保标办理','Green/OrderDone',U('Wx/PayCallBack','','','',true));
		exit($pay);
	}


	#支付完成#
	public function OrderDone($log){
		import("@.ORG.WeiXin");
		$WX = new WeiXin();
        if(!$WX->CheckSign($log)) return false;
		$info = M('car_greenlist')->where(array('orderid'=>$log['out_trade_no']))->find();
		if(!$info || $info['status'] != 1) return false;
		if($this->OrderPaied($info['id'],$log)){
			exit("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
		}
	}


	#订单支付完成#
	public function OrderPaied($id,$log = false){
		$data = array();
		if($log['transaction_id']) $data['wxpayid'] = $log['transaction_id'];
		if($log['time_end']) $data['paytime'] = strtotime($log['time_end']);
		if(!$data['paytime']) $data['paytime'] = NOW_TIME;
		$data['status'] = 2;
		$r = M('car_greenlist')->where(array('id'=>$id))->save($data);
		$info = M('car_greenlist')->where(array('id'=>$id))->find();
		$this->NotifyGreenCar('环保标','新订单提醒!',$info['name'].$info['cphm']);
		if($r) return true;
	}





	public function orderlist(){
		$this->IsAdm(true);
		if (IS_GET) {
			$this->title = "环保表办理订单";
			$this->eq = "订单管理";
			$p = I('p',1);
			$id = I('id');
			$word = I('word');
			$type = I('type');
			$status = I('status');
			$map = array();
			if($word) $map['b.nickname|a.name|a.cphm'] = array('like',"%".$word."%");
			if($status != ''){
				$map['a.status'] = $status;
			}else{
				$map['a.status'] = array('EGT',0);
			}
			import('@.ORG.Util.Page');
			$model = M('car_greenlist');
			$list = $model->where($map)->alias("a")->join('bingo_user_list b ON a.openid=b.openid')
			->order('a.addtime desc')->where($map)->page($p.',15')->field("a.id,b.nickname,a.name,a.tel,a.adr,a.cphm,a.status,a.addtime,a.paytime,b.headimgurl,a.fee,a.registerimg,a.xcz1,a.xcz2,a.openid")->select();
			$this->assign('list',$list);
			$count	=  $model->alias("a")->join('bingo_user_list b ON a.openid=b.openid')
			->where($map)->count();// 查询满足要求的总记录数
			$this->total = $count;
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
			$id = I('id');
			$info = M('car_greenlist')->where(array('id'=>$id))->find();
			if(!$info) exit(json_encode(array('ret'=>0,'msg'=>'订单不存在')));
			$r = $this->OrderCancel($info['id']);
			if($r) exit(json_encode(array('ret'=>1,'msg'=>'订单已取消')));
			exit(json_encode(array('ret'=>0,'msg'=>'订单取消失败')));
		}
	}

	#取消订单#
	protected function OrderCancel($id,$type){
		$info = M('car_greenlist')->where(array('id'=>$id))->find();
		if($info['status'] > 1 && $info['wxpayid'] && $info['paytime'] >0){
			//执行退款
			$res = $this->WxRefund($info['wxpayid'],$info['orderid'],$info['fee']);
			if(!$res) return false;
		}
		//更改状态
		$r = M('car_greenlist')->where(array('id'=>$id))->save(array('status'=>0,'donetime'=>NOW_TIME));
		//发送模版消息
		if($type != 1) $this->CanTplMsg('car_greenlist',$id,'环保标');	
		return $r;
	}

	#客户端取消订单api#
	public function UserCancel(){
		$this->IsCached();
		$id = I('get.id');
		$info = M('car_greenlist')->where(array('id'=>$id,'openid'=>$this->openid))->find();
		if(!$info) exit(json_encode(array('code'=>0,'msg'=>'订单信息不存在')));
		$r = $this->OrderCancel($info['id'],1);
		if($r) exit(json_encode(array('code'=>1)));
		exit(json_encode(array('code'=>0,'msg'=>'取消失败')));
	}

	#确认收货#
	public function ConfirmOrder(){
		$this->IsCached();
		$id = I('get.id');
		$info = M('car_greenlist')->where(array('id'=>$id,'openid'=>$this->openid,'status'=>3))->find();
		if(!$info) exit(json_encode(array('code'=>0,'mag'=>'订单信息错误')));
		$r = M('car_greenlist')->where(array('id'=>$id,'openid'=>$this->openid))->setField('status',4);
		if($r) exit(json_encode(array('code'=>1)));
		exit(json_encode(array('code'=>0,'msg'=>'出错了...'))); 
	}

	#发货#
	public function Post(){
		$this->IsAdm(true);
		$id = I('id');
		$info = M('car_greenlist')->where(array('id'=>$id,'status'=>2))->find();
		if(!$info) json('订单信息错误');
		$r = M('car_greenlist')->where(array('id'=>$id,'status'=>2))->save(array('express'=>I('express'),'expressnum'=>I('expressnum'),'status'=>3));
		//发送模版消息
		$post = array(
				'title'=>'环保表',
				'addtime' =>date('Y-m-d H:i:s',$info['addtime']),
				'kd'=>I('express'),
				'posttime'=>date('Y-m-d H:i:s',NOW_TIME),
				'openid'=>$info['openid'],
				'formId'=>$info['prepay_id'],
		);
		$this->NotifyPostOrder($post);
		if($r) json('订单发货完成',1);
		json('发货失败');
	}


	#后台订单确认完成#
	public function MakeOrderDone(){
		$this->IsAdm(true);
		$id = I('post.id');
		$info = M('car_greenlist')->where(array('id'=>$id,'status'=>3))->find();
		if(!$info) json('订单不存在');
		$r = M('car_greenlist')->where(array('id'=>$id,'status'=>3))->save(array('status'=>4,'donetime'=>NOW_TIME));
		if($r){
			json('操作成功',1);
		}else{
			json('操作失败');
		}
	}
}
 ?>