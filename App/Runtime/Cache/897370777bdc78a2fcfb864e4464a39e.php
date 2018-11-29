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
      <!--     <li><a href="<?php echo U('Mate/text');?>">微信素材</a></li>
          <li><a href="<?php echo U('Cmd/text');?>">回复规则</a></li>
          <li><a href="<?php echo U('ModMenu/edit');?>">微信菜单</a></li> -->
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
    
  <link rel="stylesheet" href="Public/com/jQuery-File-Upload-9.9.3/css/jquery.fileupload.css">
  <div class="box box-danger">
    <form role="form" id='form' action="<?php echo U('Sys/vendor');?>" method="POST">
    <div class="box-header with-border">
      <h3 class="box-title">微信平台参数配置</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      
        <div class='form-group'>
          <label>AppId：</label>
          <input type='text' class='form-control' name='AppId' value='<?php echo C('AppId');?>'>
        </div>
        <div class='form-group'>
          <label>AppSecret：</label>
          <input type='text' class='form-control' name='AppSecret' value='<?php echo C('AppSecret');?>'>
        </div>
        <div class='form-group'>
          <label>微信支付商户号：</label>
          <input type='text' class='form-control' name='MCHID' value='<?php echo C('MCHID');?>'>
        </div>
        <div class='form-group'>
          <label>微信支付密钥：</label>
          <input type='text' class='form-control' name='SIGNKEY' value='<?php echo C('SIGNKEY');?>'>
        </div>
         <div class="form-group">
          <label>微信支付证书：</label>
          <br/>
          <button style="margin-bottom:8px;" type='button' class='btn btn-default fileinput-button'><i class="glyphicon glyphicon-file"></i> <small>cert证书上传</small><input data-id="cert" class="upload" type="file" name="files" accept="*" ></button>
            <div class='cert'><?php echo ($cert); ?></div>
            <div class="progress">
                <div class="progress-bar progress-bar-success progresscert"></div>
            </div>
            <button style="margin-bottom:8px;" type='button' class='btn btn-default fileinput-button'><i class="glyphicon glyphicon-file"></i> <small>key证书上传</small><input data-id="key" class="upload" type="file" name="files" accept="*" ></button>
            <div class='key'><?php echo ($key); ?></div>
            <div class="progress">
                <div class="progress-bar progress-bar-success progresskey"></div>
            </div>
        </div>
         <div class='form-group'>
          <label>TOKEN：</label>
          <input type='text' class='form-control' name='WXTOKEN' value='<?php echo C('WXTOKEN');?>'>
        </div>
   
        <div class='form-group'>
          <label>是否启用授权模式：</label>
        </div>
        <div class='form-group'>
          <label class="radio-inline ">
            <input type="radio"  name="WX_MODEL" id="inlineRadio1" <?php if(C('WX_MODEL') == 1): ?>checked<?php endif; ?> value="1"> 是
          </label>
          <label class="radio-inline ">
            <input type="radio" <?php if(C('WX_MODEL') == 0): ?>checked<?php endif; ?>  name="WX_MODEL" id="inlineRadio2" value="0"> 否
          </label>
        </div>
         <div class='form-group'>
          <label>服务方URL：</label><small>授权模式下填写</small>
          <input type='text' class='form-control' name='WXOPEN_URL' value='<?php echo C('WXOPEN_URL');?>'>
        </div>
        <div class='form-group'>
          <label>备用处理接口地址：</label><small>需与上方TOKEN设置一致</small>
          <input type='text' class='form-control' name='BAKAPI' value='<?php echo C('BAKAPI');?>'>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
	    <button type="submit" class="btn btn-success pull-right">确定修改</button>
	  </div>
    </form>
  </div>
  </script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/vendor/jquery.ui.widget.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/load-image.all.min.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/canvas-to-blob.min.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/jquery.iframe-transport.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload-process.js"></script>
<script src="Public/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload-image.js"></script>
<script type="text/javascript">
 $('.upload').click(function(){
  var w = $(this).attr('data-id');
  // 上传图片
    $(this).fileupload({
        url: "<?php echo U('Sys/upwxpem');?>",
        dataType: 'JSON',
        acceptFileTypes: 'jpg,png,gif,jpeg,bmp,pem',
        maxFileSize: 8000000, // 800kb
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
        imageMaxWidth: 800,
        // imageMaxHeight: 800,
        // imageCrop: true,
        done: function (e, data) {
          console.log($(this).attr('name'));
          if(data.result.ret == 1){
            console.log(data.result);
              $("."+w).text(data.result[0].name);
            }else{
              alert(data.result.msg);
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress'+w).css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
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