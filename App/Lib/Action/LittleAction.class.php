<?php
/**
##小程序接口
**/
define('APPID', 'wx5d5d263b46bad2db');
define('SECRET', '7f68ed3f123c67c26e4ea92c815d6c6e');
class LittleAction extends CommonAction{
	public $openid;
	// public function showcache(){
	// 	$info = S(I('name'));
	// 	var_dump($info);
	// }
	#登录#
	public function OnLogin(){
		$code = I('code');
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.APPID.'&secret='.SECRET.'&js_code='.$code.'&grant_type=authorization_code';
		$r = json_decode(file_get_contents($url),true);
		if(!$r['session_key']) json('登录失败,请重新进入!');
		$session = substr(md5(NOW_TIME.$r['openid']),8,16);
		//$r['session_key'].$r['openid']
		S($session,$r,9000,'memcache');
		// 获取单价

		json(array('sessionkey'=>$session),1);
	}

	#登陆状态检查#
	protected function IsCached($sk = false){
		if(!$sk) $sk = I('get.sessionkey');
		$info = S($sk);
		if(!$info) json('LoginError!');
		$this->openid = $info['openid'];
		if(!$info['openid']) json('缺少openid');
		return $info;
	}

	#保存代办订单#
	public function SaveDbscOrder(){
		$this->IsCached();
		$data = json_decode(file_get_contents("php://input"),true);
		if(!$data['name'] || !$data['tel'] || !$data['adr']) json('请填写姓名电话及收件地址!');
		$data['cphm'] = $data['cpzm'].strtoupper($data['cphm']);
		// 检查有没有违章
		//if(!$this->GetCarInfo($data['cphm'],'02',$data['name'])) json('车主姓名验证失败!');
		//if($this->GetCarIll($data['cphm'])) json('该车辆有未处理违章，请处理完毕再进行操作!');
		// 删除该用户所有待支付的订单
		M('dbsc_order')->where(array('openid'=>$this->openid,'status'=>1))->delete();
		// 保存数据
		$data['openid'] = $this->openid;
		$data['total'] = 98; //订单总金额
		$data['orderid'] = strtoupper(md5($data['openid'].$data['total'].NOW_TIME));
		$data['addtime'] = NOW_TIME;
		$data['status'] = 1;
		$id = M('dbsc_order')->add($data);
		if(!$id) json('订单创建失败!');
		json($id,1);
	}

	#获取订单信息#
	public function GetDbscOrder(){
		$this->IsCached();
		$id = I('id');
		$info = M('dbsc_order')->where(array('openid'=>$this->openid,'id'=>$id))->find();
		if($info['status'] == 1){
			// 生成支付参数
			$res = $this->PayConf($info['orderid'],$info['total'],'年检代办服务','Dbsc/PayCallBack',U('Wx/PayCallBack','','','',true));
			if(!$res) json('获取支付参数失败，请联系管理员!');
			$res = json_decode($res,true);
		}else{
			$res = array();
		}
		json(array('info'=>$info,'pay'=>$res),1);
	}

	public function dbsclist(){
		$this->IsCached();
		$p = I('p',1);
		$size = I('size',6);
		$list = M('dbsc_order')->where(array('openid'=>$this->openid,'status'=>array('neq',1)))->page($p.','.$size)->select();
		if(!$list) exit(json_encode(array()));
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['addtime'] = date('Y-m-d H:i',$list[$i]['addtime']);
		}
		exit(json_encode($list));
	}

	

	#获取支付参数#
	protected function PayConf($orderid,$total,$body,$attch,$url){
		import("@.ORG.WeiXin");
        $WX = new WeiXin();
        $WX->appId = APPID;
        $WX->openid = $this->openid;
       	$payinfo = $WX->payconfig($orderid,$total*100,$body,$attch,$url);
        $r = $WX->payjsapi($payinfo['prepay_id']);
        if($payinfo['prepay_id']){
        	if($attch = 'Dbsc/PayCallBack'){
        		M('dbsc_order')->where(array('orderid'=>$orderid))->setField('prepayid',$payinfo['prepay_id']); //用于发送模版消息提醒
        	}
        }else{
        	return false;
        }
		//file_put_contents('pay.txt',$r."\r\n".json_encode($payinfo)."\r\n".json_encode($info));
		return $r;
	}
  
  	#成功寄出通知#
  	public function Notify1($info){
      $this->openid = $info['openid'];
      $data['touser'] = $this->openid;
      $data['template_id'] = '2yTYvVxAvoud-iEDZPufnJF2fVg9FyaQbkmm-eNRDGQ';
      $data['page'] = 'dbsc/list';
      $data['form_id'] = $info['formid'];
      $data['data']['keyword1']['value'] = '已寄出';
      $data['data']['keyword1']['color'] = '#173177';
      $data['data']['keyword2']['value'] = date('Y-m-d H:i');
      $data['data']['keyword2']['color'] = '#173177';
      $data['data']['keyword3']['value'] = '代办审车';
      $data['data']['keyword3']['color'] = '#173177';
      $data['data']['keyword4']['value'] = $info['cphm'];
      $data['data']['keyword4']['color'] = '#173177';
      $data['data']['keyword5']['value'] = $info['kdname'].$info['kdno'];
      $data['data']['keyword5']['color'] = '#999999';
      return $this->LittleTplMsg($data);
    }
  
  	#订单取消通知#
  	public function Notify2($info){
      $this->openid = $info['openid'];
      $data['touser'] = $this->openid;
      $data['template_id'] = '2yTYvVxAvoud-iEDZPufnJF2fVg9FyaQbkmm-eNRDGQ';
      $data['page'] = 'dbsc/list';
      $data['form_id'] = $info['formid'];
      $data['data']['keyword1']['value'] = '取消订单';
      $data['data']['keyword1']['color'] = '#173177';
      $data['data']['keyword2']['value'] = date('Y-m-d H:i');
      $data['data']['keyword2']['color'] = '#173177';
      $data['data']['keyword3']['value'] = '代办审车';
      $data['data']['keyword3']['color'] = '#173177';
      $data['data']['keyword4']['value'] = $info['cphm'];
      $data['data']['keyword4']['color'] = '#173177';
      $data['data']['keyword5']['value'] = '您的代办审车订单已被取消并退款';
      $data['data']['keyword5']['color'] = '#999999';
      return $this->LittleTplMsg($data);
    }

	
	#小程序模版消息#
	protected function LittleTplMsg($data){
		import('@.ORG.WeiXin');
		$weixin = new WeiXin(APPID,SECRET); //使用小程序的APPI 获取参数
		$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$weixin->accesstoken;
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
            return false;
        }
        curl_close($curl);
        $r = json_decode($tmpInfo, true);
        if ($r['errmsg'] == 'ok') {
            return $r;
        }
      	return false;
	}

}