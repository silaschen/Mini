<?php
/**
##小程序接口
**/
define('APPID', 'wx8482a902f90eb22d');
define('SECRET', '4871b23f7bd986b9692462bd2c6e33d2');
class MiniAction extends CommonAction{
	public $openid;
	#登录#
	public function OnLogin(){
		$code = I('get.code');
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.APPID.'&secret='.SECRET.'&js_code='.$code.'&grant_type=authorization_code';
		$r = json_decode(file_get_contents($url),true);
		if(!$r['session_key']) json('登录失败,请重新进入!');
		$session = substr(md5(NOW_TIME.$r['openid']),8,16);
		//$r['session_key'].$r['openid']
		S($session,$r,9000,'memcache');
		//保存用户·信息
		$data = json_decode(file_get_contents("php://input"),true);
		$user['headimgurl'] = $data['userdata']['avatarUrl'];
		$user['nickname'] = $this->WxDelName($data['userdata']['nickName']);
		$user['sex'] = $data['userdata']['gender'];
		$user['city'] = $data['userdata']['city'];
		$user['province'] = $data['userdata']['province'];
		$user['country'] = $data['userdata']['country'];
		if(!(M('user_list')->where(array('openid'=>$r['openid']))->find())){
			$user['openid'] = $r['openid'];
			$user['addtime'] = NOW_TIME;
			M('user_list')->add($user);
		}else{
			//update
			M('user_list')->where(array('openid'=>$r['openid']))->save($user);
		}

		json(array('sessionkey'=>$session),1);
	}

	#过滤字符#
	public function WxDelName($str) {
	    if($str){
	        $tmpStr = json_encode($str);
	        $tmpStr2 = preg_replace("#(\\\ud[0-9a-f]{3})#ie","",$tmpStr);
	        $return = json_decode($tmpStr2);
	        if(!$return){
	            return jsonName($return);
	        }
	    }else{
	        $return = '微信用户-'.time();
	    }    
	    return $return;
	}


	#获取轮播图#
	public function SlidePhoto(){
		$imgs = M('sys_advs')->where(array('type'=>1,'status'=>1))->order('addtime desc')->select();
		exit(json_encode(array('imgs'=>$imgs)));
	}


	#状态检查#
	protected function IsCached($sk = false){
		if(!$sk) $sk = I('get.sessionkey');
		$info = S($sk);
		if(!$info) json('LoginError!');
		$this->openid = $info['openid'];
		if(!$info['openid']) json('缺少openid');
		S($sk,$info,9000,'memcache');
		return $info;
	}

	#上传图片#
	public function UploadFile(){
		$r = $this->upload('images/'.date('Y-m-d'),array('ext'=>'png,jpg,gif,jpeg,mp4,avi'));
		if($r['file']){
			exit(json_encode(array('code'=>1,'file'=>$r['file'])));
		}else{
			exit(json_encode(array('code'=>0,'err'=>$r)));
		}
	}

	#返回用户信息#
	public function UserInfo(){
		$this->IsCached();
		$type = I('type');
		$user = M('user_list')->where(array('openid'=>$this->openid))->find();
		if(!$user) exit(json_encode(array('code'=>0)));
		if($type == 2){
			$car = M('car_drivelist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('DRIVE_CARD');
		}else if($type == 1 ){
			$car = M('car_xszlist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('TRAVEL_CARD');
		}else if($type == 3){
			$car = M('car_wtslist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('INSPECT_CARD');
		}else if($type == 4){
			$car = M('car_cpzlist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('REPLATE_CARD');
		}else if($type == 5){
			$car = M('car_mjblist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('EXEMPT_CARD');
		}else if($type == 6){
			$car = M('car_greenlist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('GREEN_CARD');
		}else if($type == 7){
			$car = M('car_checklist')->where(array('openid'=>$this->openid))->order('id desc')->find();
			$data['price'] = C('CHECK_CARD');
		}
		$data['car'] = $car; 
		$imgs = M('sys_advs')->where(array('type'=>1,'status'=>1))->select();
		exit(json_encode(array('code'=>1,'info'=>$data,'user'=>$user,'imgs'=>$imgs)));
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
        	if($attch == 'Drive/OrderDone'){
        		M('car_drivelist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']); //用于发送模版消息提醒
        	}else if($attch == 'Check/OrderDone'){
        		M('car_checklist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}else if($attch == 'Travel/OrderDone'){
        		M('car_xszlist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}else if($attch == 'Green/OrderDone'){
        		M('car_greenlist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}else if($attch == 'RePlate/OrderDone'){
        		M('car_cpzlist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}else if($attch == 'Inspect/OrderDone'){
        		M('car_wtslist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}else if($attch == 'Exempt/OrderDone'){
        		M('car_mjblist')->where(array('orderid'=>$orderid))->setField('prepay_id',$payinfo['prepay_id']);
        	}
        }else{
        	return false;
        }
		// file_put_contents('pay.txt',$r."\r\n".json_encode($payinfo)."\r\n".json_encode($info));
		return $r;
	}

	#资料设置#
	public function SetProfile(){
		$this->IsCached();
		$user = M('user_list')->where(array('openid'=>$this->openid))->find();
		if(!$user) exit(json_encode(array('code'=>0,'msg'=>'用户信息错误')));
		$data = json_decode(file_get_contents("php://input"),true);
		$data['cphm'] = ($this->FindCph($data['cpm'])).$data['cphm'];
		$flag = M('user_list')->where(array('openid'=>$this->openid))->save($data);
		if(!$flag) exit(json_encode(array('code'=>0,'msg'=>'您没做什么更改...')));
		exit(json_encode(array('code'=>1)));
	}

	#订单统计#
  	public function CountOrder(){
  		$this->IsCached();
  		$arr = array(
  			'c1'=>M('car_xszlist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c2'=>M('car_drivelist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c3'=>M('car_wtslist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c4'=>M('car_cpzlist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c5'=>M('car_mjblist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c6'=>M('car_greenlist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			'c7'=>M('car_checklist')->where(array('openid'=>$this->openid,'status'=>array('in',array(1,2,3))))->count(),
  			);
  		exit(json_encode($arr));
  	}

  	#我的订单#
  	public function GetOrder($table){
  		$p = I('p',1);
		$status = I('status');
		$map = array();
		$map['openid'] = $this->openid;
		if($status){
			$map['status'] = $status;
		}else{
			$map['status'] = array('egt',0);
		}
		$list = M($table)->where($map)->page($p.',6')->order('id desc')->select();
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['addtime'] = date('Y-m-d H:i:s',$list[$i]['addtime']);
		}
		return $list;
  	}


    #取消订单通知#
     public function NotifyCancelOrder($info){
      $this->openid = $info['openid'];
      $data['touser'] = $this->openid;
      $data['template_id'] = '9lK2K0oWoZ0FaH_8mqFLrmWQvBIccJNPoVuk5AjAwzs';
      $data['page'] = '';
      $data['form_id'] = $info['formId'];
      $data['data']['keyword1']['value'] = $info['title'];
      $data['data']['keyword1']['color'] = '#173177';
      $data['data']['keyword2']['value'] = $info['time'];
      $data['data']['keyword2']['color'] = '#173177';
      $data['data']['keyword3']['value'] = $info['reason'];
      $data['data']['keyword3']['color'] = '#173177';
      $data['data']['keyword4']['value'] =  $info['fee'];
      $data['data']['keyword4']['color'] = '#173177';
      return $this->LittleTplMsg($data);
    }



     #发货订单通知#
     public function NotifyPostOrder($info){
      $this->openid = $info['openid'];
      $data['touser'] = $this->openid;
      $data['template_id'] = 'IopaGuwPHEm-2P0FFNLeZHKTVGlY4nLN4B-nXQtYk70';
      $data['page'] = '';
      $data['form_id'] = $info['formId'];
      $data['data']['keyword1']['value'] = $info['title'];
      $data['data']['keyword1']['color'] = '#173177';
      $data['data']['keyword2']['value'] = $info['addtime'];
      $data['data']['keyword2']['color'] = '#173177';
      $data['data']['keyword3']['value'] = $info['kd'];
      $data['data']['keyword3']['color'] = '#173177';
      $data['data']['keyword4']['value'] =  $info['posttime'];
      $data['data']['keyword4']['color'] = '#173177';
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
        // file_put_contents("check11.txt", $r);
        if ($r['errmsg'] == 'ok') {
            return $r;
        }
      	return false;
	}


}