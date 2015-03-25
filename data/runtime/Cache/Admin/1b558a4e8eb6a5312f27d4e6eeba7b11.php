<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/thinkcmfx1.5.0/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/thinkcmfx1.5.0/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/thinkcmfx1.5.0/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/thinkcmfx1.5.0/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/thinkcmfx1.5.0/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/thinkcmfx1.5.0/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/thinkcmfx1.5.0/statics/js/jquery.js"></script>
    <script src="/thinkcmfx1.5.0/statics/js/wind.js"></script>
    <script src="/thinkcmfx1.5.0/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<head/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <ul class="nav nav-tabs">
     <li><a href="<?php echo U('rbac/index');?>">角色管理</a></li>
     <li class="active"><a href="<?php echo U('rbac/roleadd');?>">添加角色</a></li>
  </ul>
  <form class="form-horizontal J_ajaxForm" action="<?php echo U('Rbac/roleadd_post');?>" method="post" id="myform">
  <div class="table_full">
      <table width="100%" cellpadding="2" cellspacing="2">
        <tr>
          <th width="180">角色名称</th>
          <td><input type="text" name="name" value="" class="input" id="rolename"></input><span class="must_red">*</span></td>
        </tr>
        <tr>
          <th>角色描述</th>
          <td><textarea name="remark" rows="2" cols="20" id="remark" class="inputtext" style="height:100px;width:500px;"></textarea></td>
        </tr>
        <tr>
          <th>是否启用</th>
          <td>
          	<label class="radio inline" for="active_true">
            		<input type="radio" name="status" value="1" checked id="active_true"/>开启
            </label>
            <label class="radio inline" for="active_false">
            		<input type="radio" name="status" value="0" id="active_false">禁止
            </label>
          </td>
        </tr>
      </table>
  </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">提交</button>
        <a class="btn" href="/thinkcmfx1.5.0/index.php/Admin/Rbac">返回</a>
    </div>
    </form>
</div>
<script src="/thinkcmfx1.5.0/statics/js/common.js"></script>
</body>
</html>