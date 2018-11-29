<?php
/**
##车辆违章 数据接口
	2017-05-04
**/
class Illegal{
	#查询车辆违章#
	//$hphm车牌号码、$fdjh发动机号、$classno车辆识别号、$registno车辆证书号、$car_type车辆类型
	public function CarIll($hphm,$hpzm,$clsbdh,$type){
		$map = array();
		$map['hphm'] = $hpzm.$hphm;
		// $map[addtime] = array('gt',NOW_TIME-86400*3);//3天以内的信息有效
		// $list = M('illegal_search')->where($map)->find();
		// if($list != '') return json_decode($list['info'],true);
		$ch = curl_init();
		$url = "http://app2.henanga.gov.cn/jmth5/traffic/getJDCWZXX";
		$arr = array();
		$arr['auth'] = '{"app_key":"123456","app_version":23,"crc":"e00e6eb42b9c199cd345d9c883071bfb","imei":"863473025141032","os":"android","os_version":"4.4.2","time_stamp":"20090310113016","uid":"800","ver":"0.9"}';
		$arr['info'] = '{"HPZL":"'.$type.'","HPHM":"'.$hphm.'","FZJG":"'.$hpzm.'","CLSBDH":"'.$clsbdh.'","FDJH":"","pageNo":"1"}';
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
		$res = curl_exec($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$res = json_decode($res,true);
		if($res['resultData'] != ''){
			$result = array();
			$result['openid'] =$_SESSION['openid'];
			$result['info'] = json_encode($res);
			$result['hphm'] = $hpzm.$hphm;
			$result['addtime'] = NOW_TIME;
			//如果有大于3天以上的信息就更新数据库
			// $map['addtime'] = array('elt',NOW_TIME-86400*3);
			$r = M('illegal_search')->where($map)->find();
			if($r){
				M('illegal_search')->where(array('id'=>$r['id']))->save($result);
			}else{
				M('illegal_search')->add($result);
			}
		}
		return $res;
	}
}
