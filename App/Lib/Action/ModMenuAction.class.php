<?php
class ModMenuAction extends CommonAction{
	public $appid = ''; public $appsecret = ''; public $token = '';
	public function man(){
		$this->IsAdm(true);
		$this->title = '菜单管理';
		$this->eq = -1;
		$list = M('mod_menu')->where(array('pid'=>0))->order('id desc')->limit(3)->select();
		$this->assign('list',$list);
		$this->display();
	}

	public function add(){
		$this->IsAdm(true);
		$n = I('n');
		$t = I('t');
		$v = I('v');
		$pid = I('pid');
		$id = M('mod_menu')->add(array('pid'=>$pid,'name'=>$n,'type'=>$t,'value'=>$v));
		echo $id;
	}

	public function getson(){
		$this->IsAdm(true);
		$id = I('id');
		$list = M('mod_menu')->where(array('pid'=>$id))->limit(5)->order('id')->select();
		echo json_encode($list);
	}

	public function dellall(){
		$this->IsAdm(true);
		$r = M('mod_menu')->where(array('id'=>array('egt',1)))->delete();
		if($r){
			json(8,1);
		}else{
			json(-22);
		}
	}

	public function readone(){
		$this->IsAdm(true);
		if(IS_GET){
			$id = I('id');
			$info = M('mod_menu')->where(array('id'=>$id))->find();
			if($info){
				echo json_encode($info);
			}else{
				echo '';
			}
		}else{
			// 保存
			$id = I('id');
			$data['name'] = I('name');
			$t = I('type');
			if($t == 1){
				$data['type'] = 'VIEW';
			}else{
				$data['type'] = 'CLICK';
			}
			$data['value'] = I('value');
			$r = M('mod_menu')->where(array('id'=>$id))->save($data);
			if($r){
				json('修改成功!',1);
			}else{
				json('修改失败!');
			}
		}
	}

	public function syncmenu(){
		$this->IsAdm(true);
		if((C('AppId') == '') || (C('AppSecret') == '')) exit(json('请设置 公众平台 AppId AppSecret 开发者凭证!'));
		$this->appid = C('AppId'); $this->appsecret = C('AppSecret');
		$this->delmenu(); //删除
		$r = $this->makemenu();//提交创建
		echo $r;

	}

	protected function makemenu(){
		if($this->token == '') $this->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->token;
		$button = $this->makejson(); //获取按钮提交json格式
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //get the response as a string from curl_exec(), rather than echoing it 
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_POST, 1 );

		curl_setopt($ch, CURLOPT_POSTFIELDS,$button) ;
		//取到的$info 即为拿到的script 信息 
		$info =  curl_exec($ch) ;
		curl_close($ch);    //close the handle
		return $info;
	}
	//删除菜单
	protected function delmenu(){
		$this->gettoken();
		$url = "http://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->token;
		$r = file_get_contents($url);
		return $r;
	}
	protected function gettoken(){
		$AppId = $this->appid;
		$AppSecret = $this->appsecret;
		$gettoken = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret;
		$curl = curl_init(); // 启动一个CURL会话
	    curl_setopt($curl, CURLOPT_URL, $gettoken); // 要访问的地址
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	    $tmpInfo = curl_exec($curl); // 执行操作
	    if (curl_errno($curl)) {
	      // echo 'Errno'.curl_error($curl);//捕抓异常
	    	return false;
	    }
	    curl_close($curl); // 关闭CURL会话
	    $js = json_decode($tmpInfo,true);
	    $this->token = $js['access_token'];
	    //return $js['access_token'];
	}

	protected function makejson(){
		$data = array();
		$data['button'] = array();
		$list = M('mod_menu')->where(array('pid'=>0))->order('id ASC')->select();
		for($i=0;$i<count($list);$i++){
			if($list[$i]['type'] == 'SON'){
				$son = M('mod_menu')->where(array('pid'=>$list[$i]['id']))->order('id ASC')->select();
			}else{
				$son = false;
			}
			if($son){
				$data['button'][$i]['name'] = urlencode($list[$i]['name']);
				$data['button'][$i]['sub_button'] = array();
				for($n=0;$n<count($son);$n++){
					$data['button'][$i]['sub_button'][$n]['type'] = strtolower($son[$n]['type']);
					$data['button'][$i]['sub_button'][$n]['name'] = urlencode($son[$n]['name']);
					if(strtolower($son[$n]['type']) == "click"){
						$data['button'][$i]['sub_button'][$n]['key'] = urlencode($son[$n]['value']);
					}else{
						$data['button'][$i]['sub_button'][$n]['url'] = urlencode($son[$n]['value']);
					}	
				}
			}else{
				$data['button'][$i]['type'] = strtolower($list[$i]['type']);
				$data['button'][$i]['name'] = urlencode($list[$i]['name']);
				if(strtolower($list[$i]['type']) == "click"){
					$data['button'][$i]['key'] = urlencode($list[$i]['value']);
				}else{
					$data['button'][$i]['url'] = urlencode($list[$i]['value']);
				}	
			}
		}
		return urldecode(json_encode($data));
	}

	#修改已有#
	public function edit(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '修改菜单';
			$this->eq = -1;
			$list = M('mod_menu')->where(array('pid'=>0))->order('id ASC')->limit(3)->select();
			$this->assign('par',$list);
			for ($i=0; $i < count($list); $i++) { 
				if($list[$i]['type'] == 'SON'){
					$list[$i]['son'] = M('mod_menu')->where(array('pid'=>$list[$i]['id']))->order('id desc')->select();
				}
			}
			$this->assign('list',$list);
			$this->display();
		}else{

		}
	}

	#新增或保存某个按钮#
	public function save(){
		$this->IsAdm(true);
		$id = I('id');
		$data['pid'] = I('pid');
		if(I('type') == 1){
			$data['type'] = 'VIEW';
		}elseif(I('type') == 2){
			$data['type'] = 'CLICK';
		}else{
			$data['type'] = 'SON';
		}
		$data['name'] = I('name');
		$data['value'] = I('val');
		if($data['pid'] == 0){
			// 添加或修改一级菜单 规则验证
			$num = M('mod_menu')->where(array('pid'=>0))->count();
			if(!$id && $num > 2) json('最多允许创建三个一级按钮!');
		}else{
			// 添加或修改二级菜单 规则验证
			if(I('type') == 0) json('请先设为一级菜单按钮!');
			if(!$id){
				$num = M('mod_menu')->where(array('pid'=>$data['pid']))->count();
				if($num > 4) json('最多创建五个二级菜单按钮!');
			}
		}
		if($id){
			$r = M('mod_menu')->where(array('id'=>$id))->save($data);
		}else{
			$r = M('mod_menu')->add($data);
		}
		if($r && $id){
			json('修改成功!',1);
		}elseif($r && !$id){
			json('新增按钮成功!',1);
		}else{
			json('保存失败!');
		}
	}

	#删除#
	public function remove(){
		$this->IsAdm(true);
		$id = I('id');
		$info = M('mod_menu')->where(array('id'=>$id))->find();
		if($info){
			if($info['pid'] == 0){
				// 一级菜单 删除二级
				M('mod_menu')->where(array('pid'=>$info['id']))->delete();
			}
			$r = M('mod_menu')->where(array('id'=>$info['id']))->delete();
			if($r){
				json('删除成功,同步后生效!',1);
			}else{
				json('删除失败~!');
			}
		}else{
			json('不存在此菜单按钮!');
		}
	}

}