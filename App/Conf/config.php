<?php
return array(
	//'配置项'=>'配置值'
	'DB_DSN' => 'mysql://root:chen1210@localhost:3306/blog',
	'DB_PREFIX' => 'bingo_', // 数据库表前缀 
	'URL_MODEL'          => 2, //URL模式 请勿修改此项
	'URL_PATHINFO_DEPR'     =>  '-', //分隔符 请勿修改此项
	'URL_HTML_SUFFIX'           =>  '.html',
	'FILE_DIR' => 'Public/uploads/',
	'FILE_SIZE' => '3000000',
	'FILE_EXT' => 'jpg,png,gif,jpeg,bmp,txt,doc,xls,rar,zip,mp4',
	'LOAD_EXT_CONFIG' => 'site,mp,price', // 加载扩展配置文件
);
?>