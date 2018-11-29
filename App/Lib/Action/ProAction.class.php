<?php 
/**
* 车管家
*/
class ProAction extends CommonAction
{
	#代办订单列表.后台#
	public function drivelist(){
		$this->IsAdm(true);
		if (IS_GET) {
			$this->title = "车险代办列表列表";
			$this->eq = "订单管理";
			$p = I('p',1);
			$id = I('id');
			$word = I('word');
			$type = I('type');
			$status = I('status');
			$map = array();
			if($word) $map['b.nickname|a.name'] = array('like',"%".$word."%");
			if($status != ''){
				$map['a.status'] = $status;
			}else{
				$map['a.status'] = array('EGT',0);
			}
			import('@.ORG.Util.Page');
			$model = M('car_dblist');
			$list = $model->where($map)->alias("a")->join('bingo_user_list b ON a.openid=b.openid')
			->order('a.addtime desc')->where($map)->page($p.',15')->field("a.id,b.nickname,a.name,a.tel,a.adr,a.cphm,a.status,a.addtime,a.paytime,b.headimgurl")->select();
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
			$t = I('t');
			$info = M('item_list')->where(array('id'=>$id))->find();
			if(!$info) json('项目不存在');
			$res = M('item_list')->where(array('id'=>$id))->setField('status',$t);
			if($res){
				json('操作成功',1);
			}else{
				json('操作失败，请稍后再试');
			}
		}
	}

	#添加、修改项目信息#
	public function additem(){
		$this->IsAdm(true);
		if (IS_GET) {
			$this->eq = '服务项目';
			$this->title = "编辑项目信息";
			$id = I('id');
			if ($id) {
				$info = M('item_list')->where(array('id'=>$id))->find();
				$this->assign('info',$info);
			}
			$this->display();
		}else{
			$data = $_POST;
			if ($data['id'] > 0) {
				$r = M("item_list")->where(array('id'=>$data['id']))->save($data);
			}else{
				$data['addtime'] = NOW_TIME;
				$data['status'] = 1;
				$r = M('item_list')->add($data);
			}
			if ($r) {
				json('数据保存成功',1);
			}else{
				json('数据保存错误');
			}
		}
	}

	


}
 ?>