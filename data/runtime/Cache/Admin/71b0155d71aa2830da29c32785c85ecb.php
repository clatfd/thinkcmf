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
<body class="J_scroll_fixed">
<div class="wrap jj">
  <ul class="nav nav-tabs">
      <li><a href="<?php echo U('setting/site');?>">网站信息</a></li>
      <li><a href="<?php echo U('route/index');?>" >URL美化</a></li>
      <li class="active"><a href="<?php echo U('route/add');?>" >添加URL规则</a></li>
  </ul>
  <div class="common-form">
    <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('route/add_post');?>">
      <div class="table_list">
        <table cellpadding="2" cellspacing="2" class="table_form" width="100%">
          <tbody>
            <tr>
              <td width="180">原始网址:</td>
              <td><input type="text" class="input" name="full_url" value=""><span class="must_red">*</span></td>
            </tr>
             <tr>
              <td width="180">显示网址:</td>
              <td><input type="text" class="input" name="url" value=""><span class="must_red">*</span></td>
            </tr>
            <tr>
              <td width="180">显示网址:</td>
              <td>
              	<select name="status" class="normal_select">
                  <option value="1" >启用</option>
                  <option value="0" >禁用</option>
                </select>
				</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">添加</button>
            <a class="btn" href="/thinkcmfx1.5.0/index.php/Admin/Route">返回</a>
      </div>
    </form>
  </div>
</div>
<script src="/thinkcmfx1.5.0/statics/js/common.js"></script>
</body>
</html>