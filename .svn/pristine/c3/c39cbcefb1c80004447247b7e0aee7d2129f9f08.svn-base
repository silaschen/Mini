<?php
class CmdAction extends CommonAction{
	#文本规则管理#
	public function text(){
		$this->IsAdm(true);
		$this->title = '文本规则管理';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['hide'] = 0; //可显示的
		$model = M('cmd_text');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('addtime desc')->page($page.',15')->select();
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['type'] = $this->tbn($list[$i]['table']); //素材类型中文
			$list[$i]['view'] = $this->nb($list[$i]['table']); //素材类型ID
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

	#位置范围规则管理#
	public function location(){
		$this->IsAdm(true);
		$this->title = '地理位置规则管理';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['hide'] = 0; //可显示的
		$model = M('cmd_location');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('addtime desc')->page($page.',15')->select();
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['type'] = $this->tbn($list[$i]['table']); //素材类型中文
			$list[$i]['view'] = $this->nb($list[$i]['table']); //素材类型ID
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

	#事件规则管理#
	public function event(){
		$this->IsAdm(true);
		$this->title = '事件规则管理';
		$this->eq = -1;
		$page = I('p');
		if($page == '') $page = 1;
		$map = array();
		$map['hide'] = 0; //可显示的
		$model = M('cmd_event');
		import('@.ORG.Util.Page');// 导入分页类
		$list = $model->where($map)->order('addtime desc')->page($page.',15')->select();
		$not = M('cmd_notfound')->where(array())->find(); //无法匹配时
		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['type'] = $this->tbn($list[$i]['table']); //素材类型中文
			$list[$i]['view'] = $this->nb($list[$i]['table']); //素材类型ID
			if($list[$i]['event'] == 'subscribe') $list[$i]['event'] = '用户关注时';
			if($list[$i]['event'] == 'CLICK') $list[$i]['event'] = '点击菜单';
		}
		if($not){
			$n = count($list)+1;
			$list[$n] = $not;
			$list[$n]['type'] = $this->tbn($not['table']); //素材类型中文
			$list[$n]['view'] = $this->nb($not['table']); //素材类型中文
			$list[$n]['event'] = '无法匹配时';
			$list[$n]['not'] = 1;//标识
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

	public function delnot(){
		$this->IsAdm(true);
		$i = M('cmd_notfound')->where(array())->find();
		if(!$i) exit(json('操作失败!'));
		$this->xdel($i['table'],$i['rid'],'cmd_notfound',$i['id']);
		$r = M('cmd_notfound')->where(array())->delete();
		if($r){
			json('删除成功!',1);
		}else{
			json('删除失败!');
		}
	}

	#为素材设置规则#
	public function setcmd(){
		$this->IsAdm(true);
		$type = I('type');
		$id = I('id');
		$cmdtype = I('cmdtype');
		$cmdcontent = I('cmdcontent');
		$mod = I('mod'); //模块操作
		$cmdcontent = trim($cmdcontent); //去除空格
		$cmdcontent = stripslashes($cmdcontent);
		$this->checkcmd($cmdtype,$cmdcontent); //检查命令格式
		$table = $this->mb($type); //获取素材表名称
		$mck = M($table)->where(array('id'=>$id))->find(); //检查素材资源是否存在
		if($mck){
			//记录规则到对应表
			$cmd = $this->makecmd($table,$mck['id'],$cmdtype,$cmdcontent,$mod); //获取规则表名称  ID
			//更新该素材资源的规则信息
			$mck['cmd'] .= $cmd['table'].','.$cmd['id'].'#';
			$r = M($table)->where(array('id'=>$id))->setField('cmd',$mck['cmd']);
			if($r){
				json(9,1);
			}else{
				json(-22);
			}
		}else{
			//不存在的素材
			exit(json(-24));
		}
	}

	#添加或更新规则#
	protected function makecmd($table,$id,$cmdtype,$cmdcontent,$mod = ''){
		switch ($cmdtype) {
				case 1:
					$data['mod']	=	$mod;
					$data['table'] = $table;
					$data['keyword'] = strtolower($cmdcontent); //转为小写
					$data['rid']    =   $id;
					$data['addtime']    =   NOW_TIME;
					$xt = 'cmd_text';
					//需要检查 是否存在相同规则记录
					$ck = M($xt)->where(array('keyword'=>$cmdcontent))->find();
					break;
				case 2:
					$d = explode(',',$cmdcontent);
					$data['mod']	=	$mod;
					$data['table'] = $table;
					$data['ltx']    =   $d[0];
					$data['lty']    =   $d[1];
					$data['rbx']    =   $d[2];
					$data['rby']    =   $d[3];
					$data['rid']    =   $id;
					$data['addtime']    =   NOW_TIME;
					$xt = 'cmd_location';
					break;
				case 3:
					$cmdcontent = htmlspecialchars_decode($cmdcontent);
					$js = json_decode($cmdcontent,true);
					$data['mod']	=	$mod;
					$data['table'] = $table;
					$data['event'] = $js['event'];
					$data['value'] = trim($js['eventkey']);
					$data['rid']    =   $id;
					$data['addtime']    =   NOW_TIME;
					if($js['event'] == 'notfound'){
						$xt = 'cmd_notfound';
						$i = M('cmd_notfound')->where(array())->find();
						$this->xdel($i['table'],$i['rid'],'cmd_notfound',$i['id']);
						 M('cmd_notfound')->where(array())->delete();
						$ck = false;
					}else{
						$xt = 'cmd_event';
						//需要检查 是否存在
						$ck = M($xt)->where(array('event'=>$js['event'],'value'=>trim($js['eventkey'])))->find();
					}
					break;
		}

		//判断是否需要更新原有规则记录
		if($ck){
			if($ck['mod'] == ''){
				$this->xdel($ck['table'],$ck['rid'],$xt,$ck['id']); //清除资源与旧规则的对应关系  一个规则只对应一个素材
				M($xt)->where(array('id'=>$ck['id']))->save($data); //更新为新规则 指向新素材!
				$xid = $ck['id'];
			}else{
				exit(json(-31)); //指向mod操作的规则，请设置为其他值 退出操作
			}
		}else{
			$xid = M($xt)->add($data); //添加到规则表中
		}
		return array('id'=>$xid,'table'=>$xt); //返回该规则的表名称及ID
	}

	#删除回复规则#
	public function delforcmd(){
		$this->IsAdm(true);
		$id = I('id');
		$type = I('type');
		$table = $this->cmb($type);
		if($table){
			$i = M($table)->where(array('id'=>$id))->find();
			if($i){
				$r = M($table)->where(array('id'=>$id))->delete();//删除记录
				//抹掉对应素材中的自己
				$this->xdel($i['table'],$i['rid'],$table,$i['id']);
				if($r){
					json(8,1);
				}else{
					json(-22);
				}
			}
		}
	}

	#清除资源的CMD字段中 传入的规则表与ID#
	public function xdel($rt,$rid,$xt,$xid){
		$this->IsAdm(true);
		$org = M($rt)->where(array("id"=>$rid))->getField('cmd'); //获取资源的相关规则信息
		if($org){ //如果有命令
			M($rt)->where(array("id"=>$rid))->setField('cmd','');
			$now = str_replace($xt.','.$xid.'#','',$org);//清除资源中的命令id  一个素材可能被多个规则使用
			M($rt)->where(array("id"=>$rid))->setField('cmd',$now);
		}
	}

	#检查规则#
	protected function checkcmd($cmdtype,$cmdcontent){
		if($cmdtype == 1){
			//文本规则
			if($cmdcontent == '') exit(json(-26)); //请填写文本内容!
		}elseif($cmdtype == 2){
			//地理位置范围
			if($cmdcontent == '') exit(json(-27)); //请选择地理位置范围!
			$cmdcontent = explode(',',$cmdcontent);
			if(count($cmdcontent) != 4) exit(json(-28));
		}elseif($cmdtype == 3){
			//事件
			$cmdcontent = htmlspecialchars_decode($cmdcontent);
			$js = json_decode($cmdcontent,true);
			if($js['event'] == 'CLICK'){
				if($js['eventkey'] == '') exit(json(-29)); //请填写点击按钮对应的值!
			}elseif(($js['event'] != 'subscribe') && ($js['event'] != 'unsubscribe') && ($js['event'] != 'notfound')){
				exit(json(-30)); //未知的错误事件类型!
			}
		}else{
			exit(json(-25));
		}
	}

	#根据素材内容删除规则#
	public function delfrommate(){
		$this->IsAdm(true);
		$type = I('post.type');
		$id = I('post.id');
		$type = $this->mb($type); //转为素材类型ID为表名
		$i = M($type)->where(array('id'=>$id))->find();
		if($i['cmd']){
			$this->delmatecmd($i['cmd']);
			$r = M($type)->where(array('id'=>$i['id']))->setField('cmd',''); //清空素材的CMD字段
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}

	#规则设置显示#
	public function cmdsetbox(){
		$this->IsAdm(true);
		$type = I('type');
		if($type == 1){
			$this->display('textset');
		}elseif($type == 2){
			$this->display('localset');
		}elseif($type == 3){
			$this->display('eventset');
		}
	}

	#读取规则信息#
	public function readcmd(){
		$this->IsAdm(true);
		$id = I('id');
		$type = I('type');
		$table = $this->cmb($type);
		if($table){
			$info = M($table)->where(array('id'=>$id))->find();
			echo json_encode($info);
		}
	}

	#保存规则信息#
	public function savecmd(){
		$this->IsAdm(true);
		$id = I('id');
		$type = I('type');
		$cmd = I('cmd');
		$table = $this->cmb($type);
		if($table){
			if($type == 1){
				//文本
				$data['keyword'] = $cmd;
			}elseif($type == 2){
				$lbs = explode(',',$cmd);
				if(count($lbs) < 4) exit(json(-22)); //参数错误
				$data['ltx']    =   $lbs[0];
				$data['lty']    =   $lbs[1];
				$data['rbx']    =   $lbs[2];
				$data['rby']    =   $lbs[3];
			}elseif($type == 3){
				$e = explode('|||||',$cmd);
				$data['event'] = $e[0];
				$data['value'] = $e[1];
			}
			$data['addtime'] = NOW_TIME;
			$r = M($table)->where(array('id'=>$id))->save($data);
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}

	#设置命令状态#
	public function cmdstatus(){
		$this->IsAdm(true);
		$type = I('type');
		$id = I('id');
		$status = I('status');
		$table = $this->cmb($type);
		if($table){
			$r = M($table)->where(array('id'=>$id))->setField('status',$status);
			if($r){
				json(8,1);
			}else{
				json(-22);
			}
		}
	}

	#添加新规则#
	public function addcmd(){
		$this->IsAdm(true);
		$this->title = '新规则添加 - 规则管理';
		$this->eq = -1;
		$this->display();
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
	#删除素材对应规则#
	protected function delmatecmd($cmd){
		$cmd = explode('#',$cmd);
		$cmd = array_filter($cmd);
		foreach($cmd as $k){
			$k = explode(',',$k); $k = array_filter($k);
			M($k[0])->where(array('id'=>$k[1]))->delete();
		}
	}

}