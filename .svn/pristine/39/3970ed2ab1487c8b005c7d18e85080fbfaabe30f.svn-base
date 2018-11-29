<?php
class TplAction extends CommonAction{
	public $fu = '';	public $tu = '';	public $postStr = '';
	function txt_tpl($content,$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$tpl	=	"<xml> 
				<ToUserName><![CDATA[".$fu."]]></ToUserName> 
				<FromUserName><![CDATA[".$tu."]]></FromUserName> 
				<CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
				<MsgType><![CDATA[text]]></MsgType> 
				<Content><![CDATA[".$content."]]></Content> 
				<FuncFlag>".$flag."</FuncFlag>
				</xml>";
		echo $tpl;
	}

	function news_tpl($data,$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$num	=	count($data);
		if($num > 1){
			$add = $this->news_add($data);
			$tpl = " <xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
					 <MsgType><![CDATA[news]]></MsgType> 
					 <Content><![CDATA[%s]]></Content> 
					 <ArticleCount>".$num."</ArticleCount> 
					 <Articles> 
					 ".$add."
					 </Articles> 
					 <FuncFlag>".$flag."</FuncFlag> 
					 </xml> ";
			exit($tpl);
		}else{
			$tpl = " <xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime> 
					 <MsgType><![CDATA[news]]></MsgType> 
					 <Content><![CDATA[%s]]></Content> 
					 <ArticleCount>1</ArticleCount> 
					 <Articles> 
					 <item> 
					 <Title><![CDATA[".$data[0]['title']."]]></Title> 
					 <Description><![CDATA[".$data[0]['intro']."]]></Description> 
					 <PicUrl><![CDATA[".$data[0]['pic']."]]></PicUrl> 
					 <Url><![CDATA[".$data[0]['url']."]]></Url> 
					 </item>
					 </Articles> 
					 <FuncFlag>".$flag."</FuncFlag> 
					 </xml> ";
			echo $tpl;
		}
	}
	
	function news_add($data){
		$add	=	"";
			foreach ($data as $k){
			$add	.= "<item> 
				 <Title><![CDATA[".$k['title']."]]></Title> 
				 <Description><![CDATA[".$k['intro']."]]></Description> 
				 <PicUrl><![CDATA[".$k['pic']."]]></PicUrl> 
				 <Url><![CDATA[".$k['url']."]]></Url> 
				 </item>  ";
			}
			return $add;
	}
	
	function audio_tpl($data,$flag = 0){
		$fu = $this->fu;$tu = $this->tu;
		$tpl	=	"<xml>
					 <ToUserName><![CDATA[".$fu."]]></ToUserName>
					 <FromUserName><![CDATA[".$tu."]]></FromUserName>
					 <CreateTime>".$_SERVER['REQUEST_TIME']."</CreateTime>
					 <MsgType><![CDATA[music]]></MsgType>
					 <Music>
					 <Title><![CDATA[".$data['title']."]]></Title>
					 <Description><![CDATA[".$data['intro']."]]></Description>
					 <MusicUrl><![CDATA[".$data['nlink']."]]></MusicUrl>
					 <HQMusicUrl><![CDATA[".$data['wlink']."]]></HQMusicUrl>
					 </Music>
					 <FuncFlag>".$flag."</FuncFlag>
					 </xml>";
		echo $tpl;
	}

	#回复图片#
	public function img_tpl($file){
		$fu = $this->fu;$tu = $this->tu;
		if(file_exists($file)){
			// 传入的是文件路径
			$media_id = $this->WxScUpload($file);
		}
		$tpl = "<xml>
		<ToUserName><![CDATA[".$fu."]]></ToUserName>
		<FromUserName><![CDATA[".$tu."]]></FromUserName>
		<CreateTime>".NOW_TIME."</CreateTime>
		<MsgType><![CDATA[image]]></MsgType>
		<Image><MediaId><![CDATA[".$media_id."]]></MediaId></Image>
		</xml>";
		echo $tpl;
	}

	protected function find($type,$data){
		$plus = 0; //是否添加openid参数
		switch ($type) {
			case 'text':
				$map = array();
				if(is_array($data)){
					if($data['ret'] == 1){
						$map['keyword'] = array('like','%'.$data['msg'].'%');
					}else{
						$map['keyword'] = $data['msg'];
					}
				}else{
					$map['keyword'] = $data;
				}
				$info = M('cmd_text')->where($map)->find();
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'location':
				$map = array();
				$map['ltx']  = array('egt',$data['px']);
				$map['rbx']  = array('elt',$data['px']);
				$map['rby']  = array('egt',$data['py']);
				$map['lty']  = array('elt',$data['py']);
				$info = M('cmd_location')->where($map)->order('addtime desc')->select();
				$this->resouce($info[0]['table'],$info[0]['rid'],$plus);
				break;
			case 'event':
				$map = array();
				$map['event'] = array('like','%'.$data['event'].'%');
				if($data['value'] != '') $map['value'] = $data['value'];
				$info = M('cmd_event')->where($map)->find();
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'image':
				$info = M('cmd_pic')->where(array('rid'=>array('NEQ','NULL')))->find();
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			case 'voice':
				$info = M('cmd_audio')->where(array('rid'=>array('NEQ','NULL')))->find();
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
			default:
				$info = M('cmd_notfound')->where(array('rid'=>array('NEQ','NULL')))->find();
				$this->resouce($info['table'],$info['rid'],$plus);
				break;
		}
	}

	protected function resouce($table,$rid,$plus = 0){
		if($table == 'mate_text'){
			$text = M($table)->where(array('id'=>$rid))->getField('text');
			//处理转义
			$text = htmlspecialchars_decode($text);
			$text = str_replace('\n',"\n",$text);
			$text = str_replace('<br/>',"\n",$text);
			$text = str_replace('<br>',"\n",$text);
			$text = str_replace('{openid}',$this->fu,$text); //替换标签为openid
			$this->txt_tpl($text);
		}elseif($table == 'mate_onenews'){
			$data = array();
			$info = M($table)->where(array('id'=>$rid))->find();
			$data[0]['title'] = $info['title'];
			$data[0]['intro'] = $info['intro'];
			$data[0]['pic'] = $this->pathurl.$info['cover'];
			if($plus == 1){
				//$data[0]['url'] = get_page_url(true).'Index'.C('URL_PATHINFO_DEPR').'mateview'.C('URL_PATHINFO_DEPR').'id'.C('URL_PATHINFO_DEPR').$info['id'].C('URL_PATHINFO_DEPR').'openid'.C('URL_PATHINFO_DEPR').$this->fu;
			}else{
				//$data[0]['url'] = get_page_url(true).'Index'.C('URL_PATHINFO_DEPR').'mateview'.C('URL_PATHINFO_DEPR').'id'.C('URL_PATHINFO_DEPR').$info['id'];
			}
			$this->news_tpl($data);
		}elseif($table == 'mate_audio'){
			$info = M($table)->where(array('id'=>$rid))->find();
			$this->audio_tpl($info);
		}elseif($table == 'mate_morenews'){
			$info = M($table)->where(array('id'=>$rid))->find();
			$data = array();
			$title = explode('|||||',$info['title']);$title = array_filter($title);
			$cover = explode('|||||',$info['cover']);
			$intro = explode('|||||',$info['intro']);
			$tpl = explode('|||||',$info['tpl']);
			for ($i=0; $i < count($title); $i++) { 
				$data[$i]['title'] = $title[$i];
				$data[$i]['intro'] = $intro[$i];
				if($cover[$i]) $data[$i]['pic'] = $this->pathurl.$cover[$i];
				if($plus == 1){
					
				}else{
					//$data[$i]['url'] = get_page_url(true).'Index'.C('URL_PATHINFO_DEPR').'matenews'.C('URL_PATHINFO_DEPR').'id'.C('URL_PATHINFO_DEPR').$info['id'].'.'.$i;
				}
			}
			$this->news_tpl($data);
		}elseif($table == 'mate_remot'){
			$info = M($table)->where(array('id'=>$rid))->find();
			$js = json_decode($info['content'],true);
			$data = array();
			for ($i=0; $i < count($js); $i++) { 
				$data[$i]['title'] = $js[$i]['title']; 
				$data[$i]['intro'] = $js[$i]['intro'];
				$data[$i]['pic'] = $js[$i]['cover'];
				if(mb_substr($data[$i]['pic'],0,7,'utf-8') != 'http://') $data[$i]['pic'] = get_page_url(true).$data[$i]['pic']; //如果不是远程图片则补全地址
			
				$data[$i]['url'] = str_replace('{#}',get_page_url(true),$js[$i]['url']); //替换网址通配符
				$data[$i]['url'] = str_replace('{*}',C('URL_PATHINFO_DEPR'),$data[$i]['url']); //分隔符
				$data[$i]['url'] = str_replace('{@}',$this->fu,$data[$i]['url']); //openid
			}

			$this->news_tpl($data);
		}else{
			if($rid == '') $this->notfound();
		}
	}

	protected function notfound(){
		$info = M('cmd_notfound')->where(array('table'=>array('neq','NULL')))->find();
		if($info){
			$this->resouce($info['table'],$info['rid']);
			exit('SUCCESS');
		}else{
			if(C('BAKAPI') != ''){
				//转交备用接口处理
				$signature = $_GET["signature"];
				$timestamp = $_GET["timestamp"];
				$nonce = $_GET["nonce"];
				$echostr = $_GET['echostr'];
				$url = C('BAKAPI');
				if(strpos($url,'?')){
					$url .= '&signature='.$signature.'&timestamp='.$timestamp.'&nonce='.$nonce.'&echostr='.$echostr;
				}else{
					$url .= '?signature='.$signature.'&timestamp='.$timestamp.'&nonce='.$nonce.'&echostr='.$echostr;
				}
				$data = $this->postStr; //字符串
				$header[]="Content-Type: text/xml; charset=utf-8";  
				$ch = curl_init();  
				curl_setopt($ch, CURLOPT_URL, $url);  
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
				curl_setopt($ch, CURLOPT_POST, 1);  
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postStr);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
				curl_setopt($ch, CURLOPT_HEADER, 0);
				//取到的$info 即为拿到的script 信息 
				$info =	 curl_exec($ch) ;
				curl_close($ch);    //close the handle
				echo $info; //输出
			}else{
				exit('SUCCESS');
			}
		}
	}

	

	
}