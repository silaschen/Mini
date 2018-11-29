<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo ($title); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="Public/com/AdminLTE/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="Public/com/AdminLTE/css/AdminLTE.css">
<link rel="stylesheet" href="Public/com/AdminLTE/css/skins/skin-red.css">
<!-- jQuery 2.1.4 -->
<script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="Public/com/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<script src="Public/com/common.js"></script>
<style type="text/css">
/*loading*/
#mask{position: fixed;z-index: 999999;top: 0;bottom: 0;left: 0;right: 0;display: none;}
#mask .loading{padding: 10px 15px;background: #333;opacity: 0.75;text-align: center;color: #FFF;line-height: 23px;position: fixed;left:0;right: 0;bottom: 0;top: 0;width: 120px;height: 65px;z-index: 999999;margin: auto;border-radius: 4px;}
</style>
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">
  
<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="#" target='_blank' class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><i class='fa fa-television'></i></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><i class='fa fa-television'></i> <?php echo APP_NAME;?></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="Public/res/admin.png" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo $_SESSION['sys_user'];?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="Public/res/admin.png" class="img-circle" alt="User Image">
              <p>
                <?php echo $_SESSION['sys_user'];?>
                <small>上次登录：<?php echo cookie('lastlogin');?></small>
              </p>
            </li>
      
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo U('Sys/profile');?>" class="btn btn-default btn-flat">修改密码</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo U('Sys/logout');?>" onclick="return confirm('确定退出登录？');" class="btn btn-default btn-flat">退出系统</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

  <!-- Left side column. contains the logo and sidebar -->
  
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li><a href="<?php echo U('Sys/index');?>"><i class="fa fa-bar-chart"></i> <span>管理概况</span></a></li>


    <li class="treeview">
      <a href="#"><i class="fa fa-clone"></i> <span>会员管理</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
          <li><a href="<?php echo U('User/userlist');?>">会员列表</a></li>

        </ul>
      </li>

 <!--      <li><a href="<?php echo U('Pro/orderlist');?>"><i class="fa fa-bar-chart"></i> <span>代办订单</span></a></li>
 -->


      <li class="treeview">
      <a href="#"><i class="fa fa-clone"></i> <span>订单管理</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
          <li><a href="<?php echo U('Drive/orderlist');?>">驾驶证代办列表</a></li>
          <li><a href="<?php echo U('');?>">行驶证代办列表</a></li>
        </ul>
      </li>



<!--       <li class="treeview hide">
      <a href="#"><i class="fa fa-clone"></i> <span>文章管理</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
          <li><a href="<?php echo U('Sys/artlist');?>">文章列表</a></li>
          <li><a href="<?php echo U('Sys/artcategory');?>">分类管理</a></li>
        </ul>
      </li> -->


      <li class="treeview">
        <a href="#"><i class="fa fa-cog"></i> <span>系统设置</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo U('Mate/text');?>">微信素材</a></li>
          <li><a href="<?php echo U('Cmd/text');?>">回复规则</a></li>
          <li><a href="<?php echo U('ModMenu/edit');?>">微信菜单</a></li>
          <li><a href="<?php echo U('Sys/site');?>">站点设置</a></li>
          <li><a href="<?php echo U('Sys/advs');?>">轮播广告</a></li>
          <li><a href="<?php echo U('Sys/vendor');?>">微信配置</a></li>
          <li><a href="<?php echo U('Sys/group');?>">权限控制</a></li>
          <li><a href="<?php echo U('Sys/admin');?>">系统管理员</a></li>
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
<?php if($eq >= '0' OR $eq != ''): ?><script type="text/javascript">
if(!isNaN('<?php echo ($eq); ?>')){
  $(".sidebar-menu > li").eq(<?php echo ($eq); ?>).addClass('active');
}else{
  $(".sidebar-menu > li").each(function(){
    var txt = $.trim($(this).children('a').text());
    if(txt == '<?php echo ($eq); ?>'){
      $(this).addClass('active');
      return;
    }
  });
}
</script><?php endif; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- Main content -->
    <section class="content">
    
<script type="text/javascript">
var maprange = ''; //地图范围标记
var url = {
	'15':"<?php echo U('Mate/text');?>", //管理文本素材
	'16':"<?php echo U('Mate/read');?>", //读取素材内容
	'17':"<?php echo U('Mate/delmate');?>", //删除素材内容
	'18':"<?php echo U('Cmd/delfrommate');?>", //根据素材内容删除规则
	'19':"<?php echo U('Cmd/cmdsetbox');?>", //规则设置盒子
	'20':"<?php echo U('Cmd/setcmd');?>", //为素材生成规则
	'21':"<?php echo U('Mate/addonenews');?>", //添加修改单条图文素材
	'22':"<?php echo U('Mate/delcover');?>", //清除图文素材封面
	'23':"<?php echo U('Mate/texted');?>", //添加修改文本素材
	'24':"<?php echo U('Mate/addmorenews');?>", //添加修改多条图文素材
	'25':"<?php echo U('Mate/addaudio');?>", //添加修改音频素材
	'26':"<?php echo U('Mate/addremot');?>", //添加修改远程图文素材
	'27':"<?php echo U('Cmd/delforcmd');?>", //删除规则
	'28':"<?php echo U('Cmd/readcmd');?>", //读取规则
	'29':"<?php echo U('Cmd/savecmd');?>", //保存规则
	'30':"<?php echo U('Cmd/cmdstatus');?>", //设置规则状态
}

var lang = {
	'11':"恭喜你，接口已成功配置生效!",
	'10':"日志清除成功!",
	'9':"规则新增成功!",
	'8':"操作成功!",
	'7':"短消息发送成功!",
	'6':"内容发布成功!",
	'5':"恭喜你注册并绑定成功!",
	'4':"删除完毕!",
	'3':"信息添加成功!",
	'2':"信息修改成功!",
	'1':"登陆成功!",
	'-1':"验证码错误!",
	'-2':"用户不存在或已被禁用!",
	'-3':"密码错误!",
	'-4':"对不起，您输入的不是管理者帐号!",
	'-5':"所属学校不存在或被禁用!",
	'-6':"信息无变更!",
	'-7':"请填写名称!",
	'-8':"信息添加失败!",
	'-9':"内容获取失败!",
	'-10':"相同口令已被使用，请更换其他",
	'-11':"你开启了学号验证，请填写接口地址。",
	'-12':"为了安全考虑，请设置至少6位字符的密码!",
	'-13':"旧密码错误!",
	'-14':"请填写您要设置的密码",
	'-15':"请设置您的昵称!",
	'-16':"该昵称已被占用，请设置其他昵称!",
	'-17':"请输入您的学号!",
	'-18':"似乎您已经注册过了，请勿重复注册!",
	'-19':"内容发布失败~!",
	'-20':"你不能向自己发送消息!",
	'-21':"短消息发送失败!",
	'-22':"操作失败!",
	'-23':"配置文件不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请将此文件设为everyone可写！",
	'-24':"不存在的素材资源!",
	'-25':"错误的命令类型!",
	'-26':"请填写文本内容!",
	'-27':"请选择地理位置范围!",
	'-28':"参数错误!",
	'-29':"请填写点击按钮对应的值!",
	'-30':"未知的错误事件类型!",
	'-31':"您设置的命令与某个指向模块操作的命令相同，请设置其他值!",
	'-32':"请填写标题!",
	'-33':"请填写内容!",
	'-34':"没有可以清除的日志!",
	'-35':"请先配置微信公众平台登陆帐号及密码!",
	'-36':"请填写微信公众平台开发者凭据 AppId AppSecret。",
	'-37':"该命令已被使用，请更换其他!",
}
function callme(u,t,d,r){
	if(t == 1){
		t = 'GET';
	}else{
		t = 'POST';
	}
	$.ajax({
	   type: t,
	   url: u,
	   data: d,
	   dataType: 'JSON',
	   async: false,
	   success: r
	});
}
//添加文本素材
function addtext(){
	var text = tr('textbox');
	if(text == ''){
		alert('请填写内容!');
	}else{
		callme(url[23],2,"text="+text,function(data){
			if(data.ret == 1){
				location.reload();
			}else{
				alert(lang[data.msg]);
			}
		})
	}
}

//保存文本素材
function savetext(id){
	var text = tr('textbox');
	if(id == undefined) return false;
	if(text == ''){
		alert('请填写内容!');
	}else{
		callme(url[23],2,"text="+text+"&id="+id,function(data){
			alert(lang[data.msg]);
			if(data.ret == 1){
				location.href = url[15];
			}
		})
	}
}

//删除素材 
function delmate(type,id){
	var r = confirm("确定删除此素材？如该素材设置有对应的回复规则将一并删除。");
	if(r == false) return false;
	callme(url[17],1,"id="+id+"&type="+type,function(data){
		alert(lang[data.msg]);
		if(data.ret == 1){
			location.reload();
		}
	})
}

//删除对应回复规则
function delcmd(type,id){
	var r = confirm("确定删除对应的回复规则？如该素材被多个规则使用，将全部被清除。");
	if(r == false) return false;
	callme(url[18],2,"id="+id+"&type="+type,function(data){
		alert(lang[data.msg]);
		if(data.ret == 1){
			location.reload();
		}
	})
}
var cmdtype = ''; //命令类型容器
var cmdcontent = ''; //命令内容容器
//改变规则设定类型
function changecmdset(type,w){
	cmdcontent = ''; //清空容器
	cmdtype = type; //赋值命令类型
	if(w == undefined) var w = '#cmdbox';//默认容器
	$(w).load(url[19]+'?type='+type);
}

//为素材设置回复规则
function setcmd(id,type,mod){
	if(cmdtype == ''){
		alert('规则类型错误!');
	}else if(id == ''){
		alert('素材资源错误!');
	}else{
		if(mod == undefined) var mod = '';
		callme(url[20],2,"id="+id+"&type="+type+"&cmdtype="+cmdtype+"&cmdcontent="+cmdcontent+"&mod="+mod,function(data){
			alert(lang[data.msg]);
			if(data.ret == 1){
				cmdcontent = '';
				cmdtype = '';  //防止快速点击生成多个
				location.href = mateurl[type];
			}
		})
	}
}

//跳转素材管理页面
var mateurl = {
	'1':"<?php echo U('Mate/text');?>", //文本
	'2':"<?php echo U('Mate/onenews');?>", //单图文
	'3':"<?php echo U('Mate/morenews');?>", //多图文
	'4':"<?php echo U('Mate/audio');?>", //音频素材
	'5':"<?php echo U('Mate/remot');?>", //远程素材
}

//删除命令
function delforcmd(id,type){
	var r = confirm('确定删除此规则?对应的素材将不受影响。');
	if(r == true){
		callme(url[27],2,"id="+id+"&type="+type,function(data){
			alert(lang[data.msg]);
			if(data.ret == 1){
				location.reload();
			}
		})
	}
}

//设置规则状态
function cmdstatus(id,type,status){
	if(status == undefined) status = 1;
	callme(url[30],2,"id="+id+"&type="+type+"&status="+status,function(data){
		alert(lang[data.msg]);
		if(data.ret == 1){
			location.reload();
		}
	})
}
</script>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs pull-right">
      <li><a href="<?php echo U('Cmd/event');?>">事件规则</a></li>
      <li class='active'><a href="<?php echo U('Cmd/location');?>">地理位置</a></li>
      <li><a href="<?php echo U('Cmd/text');?>">文本规则</a></li>
     
      <li class="pull-left header" style="font-size: 15px;"><i class="fa fa-th"></i> <?php echo ($title); ?></li>
    </ul>
    <div class="tab-content">
		<div class="tab-pane active">
			 <table class="table table-bordered">
					<thead><th>位置范围</th><th>回复内容</th><th>预览/追加规则</th><th>状态</th><th>管理</th></thead>
					<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["ltx"]); ?>,<?php echo ($vo["lty"]); ?></td><td><?php echo ($vo["type"]); ?></td><td>
						  	<?php if($vo["mod"] != ''): ?><span title='进入模块操作 <?php echo ($vo["mod"]); ?>' class='glyphicon glyphicon-phone'></span><?php else: ?>
						  	<a href="<?php echo U('Mate/setcmd',array('id'=>$vo['rid'],'type'=>$vo['view']));?>" target='_blank'>预览</a><?php endif; ?></td>
						  	<td><?php if($vo["status"] == '1'): ?><span class='glyphicon glyphicon-play text-green'></span> 正常<?php else: ?><span class='glyphicon glyphicon-pause'></span> 暂停<?php endif; ?></td>
						  	<td>
						  	<a class="label label-danger" href="javascript:delforcmd(<?php echo ($vo["id"]); ?>,2);">删除</a>
						  	<?php if($vo["status"] == '1'): ?><a class="label label-warning" href="javascript:cmdstatus(<?php echo ($vo["id"]); ?>,2,0);">禁用</a>
						  	<?php else: ?>
						  	<a class="label label-success" href="javascript:cmdstatus(<?php echo ($vo["id"]); ?>,2,1);">启用</a><?php endif; ?>
						  	<a class="label label-info" href="javascript:locationmodify(<?php echo ($vo["id"]); ?>);">修改</a>
						  </td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
		</div><!-- /.tab-pane -->
		<div class="clearfix">
			<ul class="pagination pagination-sm no-margin pull-right"><?php echo ($page); ?></ul>
		</div>
    </div><!-- /.tab-content -->
</div>
<style type="text/css">
#allmap {height: 390px;width:100%;overflow: hidden;}
.location{width: 100%;clear: both; overflow: hidden;}
.location .anchorTR .BMapLib_Drawing_panel{}
.location .anchorTR .BMapLib_marker{display: none;}
.location .anchorTR .BMapLib_circle{display: none;}
.location .anchorTR .BMapLib_polygon{display: none;}
.location .anchorTR .BMapLib_polyline{display: none;}
.location .BMap_cpyCtrl,.location .anchorBL{display: none;}
</style>
<!--百度地图api-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=023ea5aa58d31c2d2dc6a650bad7795b"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.4/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.css" />
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.4/src/SearchInfoWindow_min.css" />
<!-- locationmodify -->
<div class="modal fade" id="locationmodify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <b>修改地理位置规则</b>
      </div>
      <div class="modal-body mtext">

        <div class='tip_b'></div>
        <div id="allmap" style="overflow:hidden;zoom:1;position:relative;"> 
            <div id="map" style="height:100%;-webkit-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;"></div>
            <div id="showPanelBtn" style="position:absolute;-webkit-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;display:none"></div>
            <div id="panelWrap" style="width:0px;position:absolute;overflow:auto;-webkit-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;display:none">
                <div style="position:absolute;opacity:0.5;" id="showOverlayInfo"></div>
                <div id="panel" style="position:absolute;display:none"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick='savelocationcmd();'>确定</button>
      </div>
    </div>
  </div>
</div><!-- /.locationmodify -->
<script type="text/javascript">
var editid = '';
function savelocationcmd(){
  if(editid != ''){
    if(maprange == ''){
      alert("请在地图上选择要修改的位置范围!");
    }else{
      callme(url[29],2,"id="+editid+"&type=2&cmd="+maprange,function(data){
        if(data.ret == 1){
          location.reload();
        }else{
          alert(lang[data.msg]);
        }
      })
    }
  }
}
  var logdeviation = 0.99983155841607307536303544841636;//偏差
    var latdeviation = 0.999942885671998668452407896263;//偏差
    var map = new BMap.Map('map');
    var poi = new BMap.Point(116.307852,40.057031);
    map.enableScrollWheelZoom();
    map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //仅包含平移和缩放按钮

    function myFun(result){
        var cityName = result.name;
        map.setCenter(cityName);
    }
    var polygon = new BMap.Polygon([
    new BMap.Point(113.797203/latdeviation,34.807934/logdeviation),
    new BMap.Point(113.808411/latdeviation,34.807934/logdeviation),
    new BMap.Point(113.808411/latdeviation,34.799129/logdeviation),
    new BMap.Point(113.797203/latdeviation,34.799129/logdeviation)
  ], {strokeColor:"blue", strokeWeight:2, strokeOpacity:0.7});
  map.addOverlay(polygon);
  map.centerAndZoom(new BMap.Point(113.797203/latdeviation,34.807934/logdeviation),15);

    var overlays = [];
    //回调获得覆盖物信息
    var overlaycomplete = function(e){
        overlays.push(e.overlay);
        if(overlays.length > 1){
            var i = overlays.length - 2;
            map.removeOverlay(overlays[i]);
        }
        if (e.drawingMode == BMAP_DRAWING_RECTANGLE) {
            //e.overlay.getPath().length 
            
            var ltx = e.overlay.getPath()[0]['lat']*logdeviation
            var lty = e.overlay.getPath()[0]['lng']*latdeviation
            var rbx = e.overlay.getPath()[2]['lat']*logdeviation
            var rby = e.overlay.getPath()[2]['lng']*latdeviation
            
            if((ltx == rbx) && (rby == lty)){
                clearAll() //删除所有
                maprange = ''; //清空容器
            }else if(Math.abs((ltx - rbx)) < 0.000060 && Math.abs((rby - lty)) < 0.000060){
                clearAll() //删除所有
                maprange = ''; //清空容器
                alert('选择的范围太小了!')
            }else{
                //赋值容器
                maprange = ltx+','+lty+','+rbx+','+rby;
            }
        }


    };

    var styleOptions = {
        strokeColor:"red",    //边线颜色。
        fillColor:"red",      //填充颜色。当参数为空时，圆形将没有填充效果。
        strokeWeight: 2,       //边线的宽度，以像素为单位。
        strokeOpacity: 0.7,    //边线透明度，取值范围0 - 1。
        fillOpacity: 0.5,      //填充的透明度，取值范围0 - 1。
        strokeStyle: 'dashed' //边线的样式，solid或dashed。
    }
    //实例化鼠标绘制工具
    var drawingManager = new BMapLib.DrawingManager(map, {
        isOpen: false, //是否开启绘制模式
        enableDrawingTool: true, //是否显示工具栏
        drawingToolOptions: {
            anchor: BMAP_ANCHOR_TOP_RIGHT, //位置
            offset: new BMap.Size(5, 5), //偏离值
            scale: 0.8 //工具栏缩放比例
        },
        rectangleOptions: styleOptions //矩形的样式
    });
    //添加鼠标绘制工具监听事件，用于获取绘制结果
    drawingManager.addEventListener('overlaycomplete', overlaycomplete);

    function clearAll() {
        for(var i = 0; i < overlays.length; i++){
            map.removeOverlay(overlays[i]);
        }
        overlays.length = 0
    }
function locationmodify(id){
  callme(url[28],1,"id="+id+"&type=2",function(data){
    if(data){
      map.clearOverlays();
      editid = id;
      var polygon = new BMap.Polygon([
        new BMap.Point(data.lty/latdeviation,data.ltx/logdeviation),
        new BMap.Point(data.rby/latdeviation,data.ltx/logdeviation),
        new BMap.Point(data.rby/latdeviation,data.rbx/logdeviation),
        new BMap.Point(data.lty/latdeviation,data.rbx/logdeviation)
      ], {strokeColor:"blue", strokeWeight:2, strokeOpacity:0.7});
      map.addOverlay(polygon);
      map.centerAndZoom(new BMap.Point(data.lty/latdeviation,data.ltx/logdeviation),15);
      $("#locationmodify").modal('show');
    }
  })
}
</script>

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">值得信赖的移动互联网开发服务商!</div>
    <!-- Default to the left -->
    <a href="http://binguo.me/wx/" target='_blank'>&copy; 宾果智造</a>
  </footer>
</div><!-- ./wrapper -->
<!-- AdminLTE App -->
<script src="Public/com/AdminLTE/js/app.min.js"></script>
<div id="mask"><div class='loading'></div></div>
</body>
</html>