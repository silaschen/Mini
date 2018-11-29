<?php
class ShowMenuWidget extends Widget{
	public function render($data){
		$model = M('mod_menu');
		$map = array();
		$map['type'] = 'CLICK';
		$list = $model->where($map)->select();
		if($list){
			$str = '';
			for ($i=0; $i < count($list); $i++) { 
				$str .= "<option value='".$list[$i]['value']."'>".$list[$i]['name']."</option>";
			}
			return $str;
		}
	}
	
}