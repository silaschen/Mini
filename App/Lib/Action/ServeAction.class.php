<?php 
class ServeAction extends CommonAction{
	#客服主页#
	public function index(){
		$this->IsUser(true);
		$this->title = '在线客服';
		$this->eq = '业务指引';
		$list = M("service_user")->where(array('status'=>array('gt',0)))->select();
		$this->assign('list',$list);
		$this->display();
	}

	#添加车务助理#
	public function addserveuser(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '添加车务助理';
			$this->eq = '车务助理';
			$id = I('id');
			if($id > 0){
				$info = M('service_user')->where(array('id'=>$id))->find();
				$this->assign('info',$info);
			}
			$this->display();
		}else{
			$data = I('post.');
			if($data['id'] > 0){
				$r = M('service_user')->where(array('id'=>$data['id']))->save($data);
			}else{
				// 新增
				$data['addtime'] = NOW_TIME;
				$data['status'] = 1;
				$r = M('service_user')->add($data);
			}
			if($r){
				json("保存成功",1);
			}else{
				json("保存失败");
			}
		}
	}

	#检测站管理#
	public function userlist(){
		$this->IsAdm(true);
		if(IS_GET){
			$this->title = '车务助理列表';
			$this->eq = '车务助理';
			$p = I('p',1);
			$id = I("id");
			$word = I('word');
			$map = array();
			if ($id) $map['id'] = $id;
			if($word) $map['name|wechat'] = array('like','%'.$word.'%');
			$map['status'] = array('egt',0);
			$model = M('service_user');
			import('@.ORG.Util.Page');// 导入分页类
			$list = $model->where($map)->order('id desc')->page($p.',10')->select();
			$this->assign('list',$list);// 赋值数据集
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
			$this->total = $count;
			$page 	= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
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
			$t = I('t');
			$r = M('service_user')->where(array('id'=>$id))->setField('status',$t);
			json('操作成功!',1);
		}
	}

}