<?php 
/**
* 会员系统
*/
class UserAction extends CommonAction
{
	#会员列表#
	public function userlist(){
		$this->IsAdm(true);
		if (IS_GET) {
			$this->eq = "会员管理";
			$this->title = "会员列表";
			$word = I('word');
			$openid = I('openid');
			$p = I('p',1);
			$map = array();
			$map['status'] = array('EGT',0);
			if($openid) $map['openid'] = $openid;
			if($word) $map['nickname|tel|id|name|cphm'] = array('like',"%".$word."%");
			import('@.ORG.Util.Page');
			$model = M('user_list');
			$list = $model->where($map)->order('addtime desc')->page($p.',15')->select();
			$this->assign('list',$list);
			$count	= $model->where($map)->count();// 查询满足要求的总记录数
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
			$uid = I('id');
			$type = I('t');
			if($type == 1){
				$r = M('user_list')->where(array('id'=>$uid))->setField('type',1);
			}else{
				//撤销其他
				M('user_list')->where(array('type'=>3))->setField('type',1);
				$r = M('user_list')->where(array('id'=>$uid))->setField('type',3);
			}
			if($r){
				json('操作成功',1);
			}else{
				json('操作失败');
			}

		}

	}

	
}


 ?>