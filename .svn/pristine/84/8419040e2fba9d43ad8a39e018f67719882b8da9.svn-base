<?php
class MateAction extends CommonAction{
	//正则替换表情
	protected function mpreg($str,$mod = 1){
		if($mod == 1){
			$mo = array(0=>"/\/::\)/",1=>"/\/::~/",2=>"/\/::B/",3=>"/\/::\|/",4=>"/\/:8-\)/",5=>"/\/::</",6=>'/\/::\$/',7=>"/\/::X/",8=>"/\/::Z/",9=>"/\/::\'\(/",10=>"/\/::-\|/",11=>"/\/::\@/",12=>"/\/::P/",13=>"/\/::D/",14=>"/\/::O/",15=>"/\/::\(/",16=>"/\/::\+/",17=>"/\/:--b/",18=>"/\/::Q/",19=>"/\/::T/",20=>"/\/:,@P/",21=>"/\/:\,@-D/",22=>"/\/::d/",23=>"/\/:,@o/",24=>"/\/::g/",25=>"/\/:\|-\)/",26=>"/\/::!/",27=>"/\/::L/",28=>"/\/::>/",29=>"/\/::\,@/",30=>"/\/:\,@f/",31=>"/\/::-S/",32=>"/\/:\?/",33=>"/\/:\,@x/",34=>"/\/:\,@@/",35=>"/\/::8/",36=>"/\/:\,@!/",37=>"/\/:!!!/",38=>"/\/:xx/",39=>"/\/:bye/",40=>"/\/:wipe/",41=>"/\/:dig/",42=>"/\/:handclap/",43=>"/\/:&-\(/",44=>"/\/:B-\)/",45=>"/\/:<@/",46=>"/\/:@>/",47=>"/\/::-O/",48=>"/\/:>-\|/",49=>"/\/:P-\(/",50=>"/\/::\'\|/",51=>"/\/:X-\)/",52=>"/\/::\*/",53=>"/\/:@x/",54=>"/\/:8\*/",55=>"/\/\:pd/",56=>"/\/:<W>/",57=>"/\/:beer/",58=>"/\/:basketb/",59=>"/\/:oo/",60=>"/\/:coffee/",61=>"/\/:eat/",62=>"/\/:pig/",63=>"/\/:rose/",64=>"/\/:fade/",65=>"/\/:showlove/",66=>"/\/:heart/",67=>"/\/:break/",68=>"/\/:cake/",69=>"/\/:li/",70=>"/\/:bome/",71=>"/\/:kn/",72=>"/\/:footb/",73=>"/\/:ladybug/",74=>"/\/:shit/",75=>"/\/:moon/",76=>"/\/:sun/",77=>"/\/:gift/",78=>"/\/:hug/",79=>"/\/:strong/",80=>"/\/:weak/",81=>"/\/:share/",82=>"/\/:v/",83=>"/\/:@\)/",84=>"/\/:jj/",85=>"/\/:@@/",86=>"/\/:bad/",87=>"/\/:lvu/",88=>"/\/:no/",89=>"/\/:ok/",90=>"/\/:love/",91=>"/\/:<L>/",92=>"/\/:jump/",93=>"/\/:shake/",94=>"/\/:<O>/",95=>"/\/:circle/",96=>"/\/:kotow/",97=>"/\/:turn/",98=>"/\/:skip/",99=>"/\[挥手\]/",99=>"/\/:oY/",100=>"/\/:#-0/",101=>"/\[街舞\]/",101=>"/\/:hiphot/",102=>"/\/:kiss/",103=>"/\/:<&/",104=>"/\/:&>/");
			$re = array();
			for($i=0;$i<105;$i++){
				//$re[$i] = "<img src='http://wx.qq.com/zh_CN/htmledition/images/qqface/".$i.".png'/>";
				$re[$i] = "<img src='http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/".$i.".gif'/>";
			}
			$str = preg_replace($mo,$re,$str); //替换表情
			$str = str_replace('\n',"<br/>",$str); //替换回车
			return $str; //替换超链接
		}else{
			$mo = array(0=>"/\/微笑/",1=>"/\/撇嘴/",2=>"/\/色/",3=>"/\/发呆/",4=>"/\/得意/",5=>"/\/流泪/",6=>"/\/害羞/",7=>"/\/闭嘴/",8=>"/\/睡/",9=>"/\/大哭/",10=>"/\/尴尬/",11=>"/\/发怒/",12=>"/\/调皮/",13=>"/\/呲牙/",14=>"/\/惊讶/",15=>"/\/难过/",16=>"/\/酷/",17=>"/\/冷汗/",18=>"/\/抓狂/",19=>"/\/吐/",20=>"/\/偷笑/",21=>"/\/可爱/",22=>"/\/白眼/",23=>"/\/傲慢/",24=>"/\/饥饿/",25=>"/\/困/",26=>"/\/惊恐/",27=>"/\/流汗/",28=>"/\/憨笑/",29=>"/\/大兵/",30=>"/\/奋斗/",31=>"/\/咒骂/",32=>"/\/疑问/",33=>"/\/嘘/",34=>"/\/晕/",35=>"/\/折磨/",36=>"/\/衰/",37=>"/\/骷髅/",38=>"/\/敲打/",39=>"/\/再见/",40=>"/\/擦汗/",41=>"/\/抠鼻/",42=>"/\/鼓掌/",43=>"/\/糗大了/",44=>"/\/坏笑/",45=>"/\/左哼哼/",46=>"/\/右哼哼/",47=>"/\/哈欠/",48=>"/\/鄙视/",49=>"/\/委屈/",50=>"/\/快哭了/",51=>"/\/阴险/",52=>"/\/亲亲/",53=>"/\/吓/",54=>"/\/可怜/",55=>"/\/菜刀/",56=>"/\/西瓜/",57=>"/\/啤酒/",58=>"/\/篮球/",59=>"/\/乒乓/",60=>"/\/咖啡/",61=>"/\/饭/",62=>"/\/猪头/",63=>"/\/玫瑰/",64=>"/\/凋谢/",65=>"/\/示爱/",66=>"/\/爱心/",67=>"/\/心碎/",68=>"/\/蛋糕/",69=>"/\/闪电/",70=>"/\/炸弹/",71=>"/\/刀/",72=>"/\/足球/",73=>"/\/瓢虫/",74=>"/\/便便/",75=>"/\/月亮/",76=>"/\/太阳/",77=>"/\/礼物/",78=>"/\/拥抱/",79=>"/\/强/",80=>"/\/弱/",81=>"/\/握手/",82=>"/\/胜利/",83=>"/\/抱拳/",84=>"/\/勾引/",85=>"/\/拳头/",86=>"/\/差劲/",87=>"/\/爱你/",88=>"/\/NO/",89=>"/\/OK/",90=>"/\/爱情/",91=>"/\/飞吻/",92=>"/\/跳跳/",93=>"/\/发抖/",94=>"/\/怄火/",95=>"/\/转圈/",96=>"/\/磕头/",97=>"/\/回头/",98=>"/\/跳绳/",99=>"/\/挥手/",100=>"/\/激动/",101=>"/\/街舞/",102=>"/\/献吻/",103=>"/\/左太极/",104=>"/\/右太极/");
			$re = array();
			for($i=0;$i<105;$i++){
				$re[$i] = "<img src='http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/".$i.".gif'/>";
			}
			$str = preg_replace($mo,$re,$str); //替换表情
			$str = str_replace('\n',"<br/>",$str); //替换回车
			return htmlspecialchars_decode($str); //替换超链接
		}
	}

	#文本素材管理#
	public function text(){
		$this->IsAdm(true);
		$this->title = '文本消息素材';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['status'] = 1; //可显示的
		$model = M('mate_text');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('editime desc')->page($page.',15')->select();
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['text'] = $this->mpreg(htmlspecialchars_decode($list[$i]['text']),2);
		}
		$this->assign('list',$list);// 赋值数据集
		$count	= $model->where($map)->count();// 查询满足要求的总记录数
		$page 	= new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$page->setConfig('theme','%upPage% %prePage% %linkPage% %nextPage% %downPage%');
		$show	= $page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		//分页跳转的时候保证查询条件
		foreach($map as $key=>$val) {
			$page->parameter   .=   "$key=".urlencode($val).'&';
		}
		$this->display();
	}

	#文本素材编辑#
	public function texted(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '编辑';
			$this->eq = -4;
			$id = I('id');
			$info = M('mate_text')->where(array('id'=>$id))->find();
			$info['o'] = htmlspecialchars_decode($info['text']); //解析编辑
			$info['v'] = $this->mpreg(htmlspecialchars_decode($info['text']),2);//解析预览
			$this->assign('info',$info);
			$this->display();
		}else{
			//提交保存修改
			$text = I('text');
			$id = I('id'); //id save
			if($text == '') exit();
			if($id){
				$r = M('mate_text')->where(array('id'=>$id))->save(array('text'=>$text,'editime'=>NOW_TIME));
			}else{
				$r = M('mate_text')->add(array('text'=>$text,'addtime'=>NOW_TIME,'editime'=>NOW_TIME));
			}
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}


	#音频素材#
	public function audio(){
		$this->IsAdm(true);
		$this->title = '音频消息素材';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['status'] = 1; //可显示的
		$model = M('mate_audio');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('editime desc')->page($page.',15')->select();
		$this->assign('list',$list);// 赋值数据集
		$count	= $model->where($map)->count();// 查询满足要求的总记录数
		$page 	= new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$page->setConfig('theme','%upPage% %prePage% %linkPage% %nextPage% %downPage%');
		$show	= $page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		//分页跳转的时候保证查询条件
		foreach($map as $key=>$val) {
			$page->parameter   .=   "$key=".urlencode($val).'&';
		}

		$this->display();
	}

	#编辑上传音频素材#
	public function addaudio(){
		$this->IsAdm(true);
		if(IS_GET){
			$id = I('id');
			$info = M('mate_audio')->where(array('id'=>$id))->find();
			echo json_encode($info); //输出JSON
		}else{
			$id = I('id');
			$title = I('title');
			$intro = I('intro');
			$wlink = I('wlink');
			$nlink = I('nlink');
			if(($wlink == '') && ($nlink == '')) exit();
			if($wlink == '') $wlink = $nlink;
			if($nlink == '') $nlink = $wlink;
			$data['title'] = $title;
			$data['intro'] = $intro;
			$data['wlink'] = $wlink;
			$data['nlink'] = $nlink;
			$data['editime'] = NOW_TIME;
			if($id){
				$r = M('mate_audio')->where(array('id'=>$id))->save($data);
			}else{
				$data['addtime'] = NOW_TIME;
				$r =  M('mate_audio')->add($data);
			}
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}

	#远程图文素材#
	public function remot(){
		$this->IsAdm(true);
		$this->title = '图文素材';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['status'] = 1; //可显示的
		$model = M('mate_remot');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('editime desc')->page($page.',15')->select();
		$this->assign('list',$list);// 赋值数据集
		$count	= $model->where($map)->count();// 查询满足要求的总记录数
		$page 	= new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$page->setConfig('theme','%upPage% %prePage% %linkPage% %nextPage% %downPage%');
		$show	= $page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		//分页跳转的时候保证查询条件
		foreach($map as $key=>$val) {
			$page->parameter   .=   "$key=".urlencode($val).'&';
		}

		$this->display();
	}

	#添加修改远程图文#
	public function addremot(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '添加图文素材';
			$this->eq = -4;
			$id = I('id');
			if($id){
				$this->title = '修改图文素材';
				$info = M('mate_remot')->where(array('id'=>$id))->getField('content');
				$info = json_decode($info,true);
				$info = array_filter($info);
				$this->assign('info',$info);
				$this->id = $id;
			}
			$this->display();
		}else{
			//保存内容
			$id = I('id');
			$js = $_POST['json'];
			if($js == '') exit();
			$json = "[".mb_substr($js,0,-1,'utf-8')."]";
			$arr = json_decode($json,true);
			$title = '';
			foreach ($arr as $k) {
				$title .= $k['title'].','; //便于搜索
			}
			$data['title'] = $title;
			$data['content'] = $json;
			if($id){
				$data['editime'] = NOW_TIME;
				$r = M('mate_remot')->where(array('id'=>$id))->save($data);
			}else{
				$data['editime'] = NOW_TIME;
				$data['addtime'] = NOW_TIME;
				$r = M('mate_remot')->add($data);
			}
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}

	#删除素材对应规则#
	protected function delmatecmd($cmd){
		$cmd = explode('#',$cmd);
		$cmd = array_filter($cmd);
		foreach($cmd as $k){
			$k = explode(',',$k); $k = array_filter($k);
			M($k[0])->where(array('id'=>$k[1]))->delete();
		}
	}

	#根据素材类型ID返回对应的表名称#
	protected function mb($type = ''){
		if($type == 1) return 'mate_text';
		if($type == 2) return 'mate_onenews';
		if($type == 3) return 'mate_morenews';
		if($type == 4) return 'mate_audio';
		if($type == 5) return 'mate_remot';
	}

	#根据素材表名称返回类型ID#
	protected function nb($type){
		if($type == 'mate_text') return 1;
		if($type == 'mate_onenews') return 2;
		if($type == 'mate_morenews') return 3;
		if($type == 'mate_audio') return 4;
		if($type == 'mate_remot') return 5;
	}

	#根据素材表名称返回中文名称#
	protected function tbn($table){
		if($table == 'mate_text') return '文本素材';
		if($table == 'mate_onenews') return '单条图文素材';
		if($table == 'mate_morenews') return '多条图文素材';
		if($table == 'mate_audio') return '音频素材';
		if($table == 'mate_remot') return '远程图文素材';
	}

	#返回命令表名称#
	protected function cmb($type){
		if($type == 1) return 'cmd_text';
		if($type == 2) return 'cmd_location';
		if($type == 3) return 'cmd_event';
	}


	#删除素材#
	public function delmate(){
		$this->IsAdm(true);
		$type = I('type');
		$id = I('id');
		$table = $this->mb($type); //获取素材表名称
		$ck = M($table)->where(array('id'=>$id))->find();
		if($ck){
			if($ck['cmd'] != '') $this->delmatecmd($ck['cmd']);//清除命令
			$r = M($table)->where(array('id'=>$ck['id']))->delete(); //删除文本素材
			if($table == 'mate_morenews'){  //如果是多条图文素材 采用特殊的处理 删除封面图片
				if($ck['cover']){
					$arr = explode('|||||',$ck['cover']); $arr = array_filter($arr);
					for ($i=0; $i < count($arr); $i++) { 
						@unlink($arr[$i]); //删除封面
					}
				}
			}else{ //普通封面
				if($ck['cover']) @unlink($ck['cover']); //删除封面
			}
			if($r){json(8,1);}else{json(-22);}
		}
	}

	#为素材设置回复规则#
	public function setcmd(){
		$this->IsAdm(true);
		$type = I('type');
		$id = I('id');
		$table = $this->mb($type);
		$info = M($table)->where(array('id'=>$id))->find();
		if($info){
			if($type == 1){
				$this->back = 'text'; //返回管理
				$info['v'] = $this->mpreg(htmlspecialchars_decode($info['text']),2);
			}elseif($type == 4){
				$this->back = 'audio';//返回管理
				$info['v'] = '<object type="application/x-shockwave-flash" data="'.get_page_url(true).'Public/com/player/dewplayer.swf?mp3='.$info['wlink'].'" width="200" height="20" id="dewplayer"><param name="wmode" value="transparent" /><param name="movie" value="'.get_page_url(true).'Public/com/player/dewplayer.swf?mp3='.$info['wlink'].'" /></object>';
			}elseif($type == 5){
				$this->back = 'remot'; //返回管理
				$arr = json_decode($info['content'],true);
				for ($n=0; $n < count($arr); $n++) { 
					if($arr[$n]['cover'] == '') $arr[$n]['cover'] = "Public/img/defaultthumb.jpg"; //默认图像
					$info['v'] .= "<p class='fl col-sm-6 col-md-3'><a title='".$arr[$n]['title']."' href='".$arr[$n]['url']."' target='_blank' class='thumbnail fl mt'><img src='".$arr[$n]['cover']."'> </a><span class='st'>".$arr[$n]['title']."</span></p>";
				}
				$info['v'] = "<div class=\"cl ov\">".$info['v']."</div>";
			}
			$this->type = $type; //赋值素材类型
			$this->title = '设置回复规则';
			$this->eq = -1;
			$this->assign('info',$info);
			$this->display();
		}
	}



	#读取素材内容#
	public function read(){
		$this->IsAdm(true);
		$id = I('id');
		$type = I('type');
		if($type == 1){ //文本素材
			$r = M('mate_text')->where(array('id'=>$id))->getField('text');
			$arr['o'] = htmlspecialchars_decode($r);
			$arr['v'] = $this->mpreg(htmlspecialchars_decode($r),2);
			echo json_encode($arr);
		}
	}


}