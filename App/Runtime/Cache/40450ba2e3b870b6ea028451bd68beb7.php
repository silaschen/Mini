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
          <li><a href="<?php echo U('Drive/orderlist');?>">驾驶证代办</a></li>
          <li><a href="<?php echo U('Travel/orderlist');?>">行驶证代办</a></li>
          <li><a href="<?php echo U('Inspect/orderlist');?>">委托书订单</a></li>
          <li><a href="<?php echo U('RePlate/orderlist');?>">补办车牌照</a></li>
          <li><a href="<?php echo U('Exempt/orderlist');?>">免检标领取</a></li>
          <li><a href="<?php echo U('Green/orderlist');?>">环保标办理</a></li>
          <li><a href="<?php echo U('Check/orderlist');?>">代驾申车办理</a></li>
        </ul>
      </li>



<!-- <li class="treeview hide">
      <a href="#"><i class="fa fa-clone"></i> <span>文章管理</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
          <li><a href="<?php echo U('Sys/artlist');?>">文章列表</a></li>
          <li><a href="<?php echo U('Sys/artcategory');?>">分类管理</a></li>
        </ul>
  </li> -->


      <li class="treeview">
        <a href="#"><i class="fa fa-cog"></i> <span>系统设置</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
        <li><a href="<?php echo U('Sys/EditPrice');?>">价格设置</a></li>
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
    
  <div class="box box-solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo ($title); ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form method="GET" action="<?php echo U('Check/orderlist');?>" id='search' style="margin-bottom:15px;">
      <div class="row">

        <div class="col-xs-3 col-md-2">
          <select name='status' class='form-control'>
            <option value=''>全部</option>
            <option value='1'>待支付</option>
            <option value='2'>已支付</option>
            <option value="3">已发货</option>
            <option value="4">已成功</option>
            <option value="0">已取消</option>
          </select>
        </div>

        <div class="col-xs-6 col-md-6">
          <div class="input-group">
            <input name="word" type='text' class='form-control' value="<?php echo I('word');?>" placeholder='姓名/昵称/车牌号 关键词搜索..'>
            <span class="input-group-addon" onclick="$('#search').submit();"><i class="fa fa-search"></i></span>
            <?php if($_GET['type'] != '' OR $_GET['word'] != '' OR $_GET['status'] != ''): ?><a title='清除条件' class="input-group-addon" href="<?php echo U('Check/orderlist');?>"><i class="fa fa-remove"></i></a><?php endif; ?>
          </div>
        </div>
      </div>
      </form>
      <table class="table table-bordered">
        <thead>
          <th>ID</th>
          <th>用户</th>
          <th>车牌</th>
          <th>车主</th>
          <th>电话</th>
          <th>金额</th>
          <th>登记证</th>
          <th>行车证1</th>
          <th>行车证2</th>
          <th>付款时间</th>
          <th>添加时间</th>
          <th>状态</th>
          <th>操作</th>
        </thead>
        <tbody>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td><?php echo ($vo["id"]); ?></td>
          <td><?php if($vo["headimgurl"] != ''): ?><a href="<?php echo U('User/userlist');?>?openid=<?php echo ($vo['openid']); ?>"><img src='<?php echo ($vo["headimgurl"]); ?>' class='img-rounded' width='40'></a><?php endif; ?></td>
          <td><?php echo ($vo["cphm"]); ?></td>
          <td><?php echo ($vo["name"]); ?></td><td><?php echo ($vo["tel"]); ?></td>
          <td><span class="badge bg-blue">￥<?php echo ($vo["fee"]); ?></span></td>
      
          <td><?php if($vo["insuimg"] != ''): ?><img src="<?php echo ($vo['insuimg']); ?>" width="35" onclick="ShowImg('<?php echo ($vo['insuimg']); ?>')"><?php endif; ?></td>

          <td><?php if($vo["xcz1"] != ''): ?><img src="<?php echo ($vo['xcz1']); ?>" width="35" onclick="ShowImg('<?php echo ($vo['xcz1']); ?>')"><?php endif; ?></td>
           <td><?php if($vo["xcz2"] != ''): ?><img src="<?php echo ($vo['xcz2']); ?>" width="35" onclick="ShowImg('<?php echo ($vo['xcz2']); ?>')"><?php endif; ?></td>
          <td><?php echo ($vo["wtadr"]); ?></td>
          <td><?php if($vo['paytime'] != ''): echo (date('Y-m-d H:i:s',$vo["paytime"])); endif; ?></td>
          <td><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
          <td><?php if($vo["status"] == 1): ?><span class="label label-warning">代付款</span><?php elseif($vo["status"] == 2): ?><span class="label label-success">已支付</span><?php elseif($vo["status"] == 3): ?><span class="label label-info">已发货</span><?php elseif($vo["status"] == 4): ?><span class="label label-success">已成功</span><?php elseif($vo["status"] == 0): ?><span class="label label-default">已取消</span><?php endif; ?></td>
          <td>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                管理
                <span class="caret"></span>
                <span class="sr-only">+</span>
              </button>
              <ul class="dropdown-menu" role="menu">
               <?php if($vo["status"] == 2): ?><li><a href="javascript:Express(<?php echo ($vo['id']); ?>)">发货</a></li><?php endif; ?>
              <?php if($vo["status"] == 3): ?><li><a href="javascript:OrderDone(<?php echo ($vo['id']); ?>)">完成订单</a></li><?php endif; ?>
                <li><a href="javascript:CancelOrder(<?php echo ($vo['id']); ?>)">取消</a></li>
                <li><a href="javascript:setstat(<?php echo ($vo["id"]); ?>,-1);">删除</a></li>
              </ul>
            </div>
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
      <ul class="pagination pagination-sm no-margin pull-left"><?php echo ($page); ?></ul>
    </div>  
  </div>
<!-- 查看图片 -->
<div class="modal fade" id="img" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <b>图片详情</b>
      </div>
      <div class="modal-body">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 发货 -->
<div class="modal fade" id="express" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <b>填写发货单</b>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group">   
              <label>快递公司</label>
              <input type="text" name="express" class="form-control">
          </div>  

          <div class="form-group">   
              <label>快递单号</label>
              <input type="text" name="expressnum" class="form-control">
          </div>   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" onclick="Make()">确认</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
function CancelOrder(id){
  if(confirm('您确定取消此订单吗?') == true){
      loading2('操作中...');
      $.post(location.href,{'id':id},function(data){

            alert(data.msg);
            if(data.ret == 1){
              location.reload();
            }else{
              loading2('',0);
            }
      },'JSON');
  }
}

//完成订单
function OrderDone(id){
   if(confirm('您确认要完成此订单吗?') == true){
      loading2('操作中...');
      $.post("<?php echo U('Common/MakeOrderDone');?>",{'table':'car_checklist','id':id},function(data){
          alert(data.msg);
          if(data.ret == 1){
              location.reload();
          }else{
            loading2('',0);
          }

      },'JSON')
    }
}
</script>
<script type="text/javascript">
   function ShowImg(img){
      $("#img .modal-body").empty();
      var imgs = '<img src="'+img+'" style="width:100%;">';
      $("#img .modal-body").append(imgs);
      $("#img").modal('show');

   }

   //发货
   function Express(id){
    IptVal('id',id);
    $('#express').modal('show');
   }
   //寄出
   function Make(){
      var id = IptVal('id');
      var express = IptVal('express');
      var expressnum = IptVal('expressnum');
      loading2('操作中...');
      $.post("<?php echo U('Common/PostNow');?>",{'id':id,'express':express,'expressnum':expressnum,'type':7},function(data){

            alert(data.msg);
            if(data.ret == 1){
              location.reload();
            }else{
              loading2('',0);
            }
      },'JSON');


   }
<?php if($_GET['status'] >= 0): ?>SelVal('status',<?php echo ($_GET['status']); ?>);<?php endif; ?>
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