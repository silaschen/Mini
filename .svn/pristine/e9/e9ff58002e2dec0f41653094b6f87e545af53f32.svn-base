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
      <li class='active'><a href="<?php echo U('Cmd/event');?>">事件规则</a></li>
      <li><a href="<?php echo U('Cmd/location');?>">地理位置</a></li>
      <li><a href="<?php echo U('Cmd/text');?>">文本规则</a></li>
     
      <li class="pull-left header" style="font-size: 15px;"><i class="fa fa-th"></i> <?php echo ($title); ?></li>
    </ul>
    <div class="tab-content">
		<div class="tab-pane active">
			 <table class="table table-bordered">
					<thead><th>事件类型</th><th>传入值</th><th>回复内容</th><th>预览/追加</th><th>状态</th><th>管理</th></thead>
					<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["event"]); ?></td><td><?php echo ($vo["value"]); ?></td><td><?php echo ($vo["type"]); ?></td><td>
						  	<?php if($vo["mod"] != ''): ?><span title='进入模块操作 <?php echo ($vo["mod"]); ?>' class='glyphicon glyphicon-phone'></span><?php else: ?>
						  	<a href="<?php echo U('Mate/setcmd',array('id'=>$vo['rid'],'type'=>$vo['view']));?>" target='_blank'>预览</a><?php endif; ?></td>
						  	<td><?php if($vo["status"] == '1'): ?><span class='glyphicon glyphicon-play text-green'></span> 正常<?php else: ?><span class='glyphicon glyphicon-pause'></span> 暂停<?php endif; ?></td>
						  	<td>
					  		<?php if($vo["not"] == '1'): ?><a class="label label-danger fr ml cr"  onclick='delnot();'>删除</a>
					  		<?php else: ?>
						  	<a class="label label-danger" href="javascript:delforcmd(<?php echo ($vo["id"]); ?>,3);">删除</a>
						  	<?php if($vo["status"] == '1'): ?><a class="label label-warning" href="javascript:cmdstatus(<?php echo ($vo["id"]); ?>,3,0);">禁用</a>
						  	<?php else: ?>
						  	<a class="label label-success" href="javascript:cmdstatus(<?php echo ($vo["id"]); ?>,3,1);">启用</a><?php endif; ?>
						  	<a class="label label-info" href="javascript:eventmodify(<?php echo ($vo["id"]); ?>);">修改</a><?php endif; ?>
						  </td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
		</div><!-- /.tab-pane -->
		<div class="clearfix">
			<ul class="pagination pagination-sm no-margin pull-right"><?php echo ($page); ?></ul>
		</div>
    </div><!-- /.tab-content -->
</div>
<!-- eventmodify -->
<div class="modal fade" id="eventmodify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <b>修改事件规则</b>
      </div>
      <div class="modal-body mtext">

        <div class='tip_b'></div>
        <div class="col-xs-4">
<select class='form-control' name='event'>
  <option value='1'>当用户关注时回复</option>
  <option value='2'>当用户点击菜单时回复</option>
  <option value='0'>当无法匹配命令时</option>
</select>
</div>
<div class="col-xs-3">
  <select class='form-control' style='display:none;' name='click' onchange="putkey();">
    <option value=''>--自定义</option>
    <?php echo W('ShowMenu');?>
  </select>
</div>
<div class="col-xs-3">
<input class='form-control' name='eventkey' id="eventkey" style='display:none;' placeholder="输入对应的菜单按钮值..." />
</div>
      </div>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick='saveeventcmd();'>确定</button>
      </div>
    </div>
  </div>
</div><!-- /.eventmodify -->
<script type="text/javascript">
var editid = '';
function eventmodify(id){
  callme(url[28],1,"id="+id+"&type=3",function(data){
    if(data){
      editid = id;
      if(data.event == 'subscribe'){
        $("select[name='event']").val(1);
         $("input[name='eventkey']").val('').hide();
        $("select[name='click']").hide(); //显示
      }else if(data.event == 'CLICK'){
        $("select[name='event']").val(2);
        $("input[name='eventkey']").val(data.value).show();
        $("select[name='click']").show(); //显示
      }

      $("#eventmodify").modal('show');
    }
  })
}
$("select[name='event']").change(function(){
    var i = $(this).val();
    if(i == 1){
      $("#eventkey").val('').hide();
      $("select[name='click']").hide();
    }else if(i == 2){
      $("#eventkey").show();
      $("select[name='click']").val('');
      $("select[name='click']").show();
    }
})
function putkey(){
  var i = sr('click');
  $("input[name='eventkey']").val(i);
}
function saveeventcmd(){
  if(editid != ''){
    var e = sr('event');
    var v = vr('eventkey');
    if((e == 2) && (v == '')){
      alert("请填写菜单按钮的值!");
    }else{
      if(e == 1){
        var et = 'subscribe'; //订阅
      }else if(e == 2){
        var et = 'CLICK'; //点击
      }
      callme(url[29],2,"id="+editid+"&type=3&cmd="+et+"|||||"+v,function(data){
        if(data.ret == 1){
          location.reload();
        }else{
          alert(lang[data.msg]);
        }
      })
    }
  }
}
</script>
<script type="text/javascript">
function delnot(){
	$.get("<?php echo U('Cmd/delnot');?>",function(data){
		if(data.ret == 1){
			window.location.reload();
		}else{
			alert(data.msg);
		}
	},'json')
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