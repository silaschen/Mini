<?php
/*
#   版权所有 郑州彬果（宾果）计算机科技有限公司  [Binguo.me] Copyright ©2013 ~ 2099
#   宾果 是全国最专业的微信公众平台领域开发服务商!
#   Authors : YangLin
*/
function __hack_module(){
    exit('<center><br><br><h1>Oops!</h1></center>');
}
function __hack_action(){
    exit('<center><br><br><h1>Oops!</h1></center>');
}
// 双通道后退
function back($url = ''){
    if($_SERVER['HTTP_REFERER']){
        return "javascript:history.go(-1);";
    }else{
        if($url) return $url;
        return "javascript:history.go(-1);";
    }
}
//对数组进行url编码
function arrtourl($array){
    $aPOST = array();
    foreach($array as $key=>$val){
        $aPOST[] = $key."=".urlencode($val);
    }
    $strPOST =  join("&", $aPOST);
    return $strPOST;
}

//过滤字符串空格换行
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);   
}
// 显示金额优化
function fixnumber($num){
    return rtrim(rtrim($num,'0'),'.');
}

// 读取字段
function zd($table='',$map=array(),$field = 'name',$default=''){
     $res= M($table)->where($map)->getField($field);
     if(empty($res) && isset($default)){
        $res =$default;
     }
     return $res;
}

// 统计
function mkcount($table,$map = array(),$more = false,$field = 'id'){
    if($more){
        return M($table)->where($map)->$more($field);
    }else{
        return M($table)->where($map)->count();
    }
}


#显示地区下拉菜单(读取数据库方式)#
function showarea($pid = 0){
    $list = M('sys_location')->where(array('pid'=>$pid))->field('id,name,pid')->select();
    $opt = '';
    for ($i=0; $i < count($list); $i++) { 
        $opt .= "<option value='".$list[$i]['id']."'>".$list[$i]['name']."</option>";
    }
    return $opt;
}

#记录系统日志#
function syslogs($event,$uid=0,$type=1){
    $log = array('event'=>$event,'uid'=>$uid,'type'=>$type,'addtime'=>NOW_TIME,'addip'=>get_client_ip());
    return M('sys_logs')->add($log);
}

function filter_vars(&$value){
     $value = htmlspecialchars($value);
     return $value;
}

#json输出#
function json($data,$code = 0){
    if(is_array($data)){
        $data['ret'] = $code;
        exit(json_encode($data));
    }else{
        $a['msg'] = $data;
        $a['ret'] = $code;
        exit(json_encode($a));
    }
}

#直接请求型操作提示#
function alert($msg,$url = ''){
    header("Content-type: text/html; charset=utf-8");
    if($url == ''){
        exit("<script>alert('".$msg."');history.go(-1);</script>");
    }else{
        if($url == 'close'){
            exit("<script>alert('".$msg."');window.opener=null;window.close();</script>");
        }else if($url == 'stop'){
            exit("<script>alert('".$msg."');</script>");
        }else{
            exit("<script>alert('".$msg."');location.href='".$url."';</script>");
        }
    }
}

//返回访问目录
function seldir(){
    $baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
    //保证为空时能返回可以使用的正常值
    $baseUrl = empty($baseUrl) ? '/' : '/'.trim($baseUrl,'/');
    return 'http://'.$_SERVER['HTTP_HOST'].$baseUrl;
}
#返回表单数组#
function postdata($f = false){
    if($_POST){
        $data = array();
        foreach ($_POST as $k => $v) {
            if($k == 'id' || $k == '__hash__'){
                if($f) $data[$k] = $v;
            }else{
                $data[$k] = $v;
            }
        }
        return $data;
    }
}
// 获取地区名称
function area($id){
    if($id > 0) return M('sys_location')->where(array('id'=>$id))->getField('name');
}

#获取当前访问完整URL#
function get_page_url($site=false){
    $url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    if($site) return seldir().'/'; //访问域名网址
    $url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);
    return $url;
}




/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
    if (!$sTime) return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime      =   NOW_TIME;
    $dTime      =   $cTime - $sTime;
    $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            if($dTime < 10){
                return '刚刚';    //by yangjs
            }else{
                return intval(floor($dTime / 10) * 10)."秒前";
            }
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d , H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}


// 数组保存到文件
function arr2file($filename, $arr=''){
    if(is_array($arr)){
        $con = var_export($arr,true);
    } else{
        $con = $arr;
    }
    $con = "<?php\nreturn $con;\n?>"; //生成配置文件内容

    $dir = dirname($filename);
    if(!is_dir($dir)){
        mkdir($dir);
    }
    return @file_put_contents($filename,$con); //写入./config.php中
}

//正则判断是否是手机号
function ismobile($tel){
    if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/",$tel)){
        return true;
    }else{
        return false;
    }
}



/**
* 导出数据为excel表格
*@param $data    一个二维数组,结构如同从数据库查出来的数组
*@param $title   excel的第一行标题,一个数组,如果为空则没有标题
*@param $filename 下载的文件名
*@examlpe
*$stu = M ('User');
*$arr = $stu -> select();
*exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
*/
 function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:applicationnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            //$title[$k]=iconv("UTF-8", "GB2312",$v);
            $title[$k] = $v ;
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                //$data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                if($ck == 'sfid'){
                    $data[$key][$ck]= (string)$cv.'#';
                }else{
                    $data[$key][$ck]= (string)$cv;
                }
            }
            $data[$key] = implode("\t", $data[$key]);
        }
        echo implode("\n",$data);
    }
}

//判断是否是移动设备
function isMobi(){
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}
