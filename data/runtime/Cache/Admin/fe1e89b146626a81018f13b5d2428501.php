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
<div class="wrap J_check_wrap">
  <ul class="nav nav-tabs">
     <li class="active"><a href="<?php echo U('nav/index');?>">前台菜单</a></li>
     <li><a href="<?php echo U('nav/add',array('cid'=>$navcid));?>">添加菜单</a></li>
  </ul>
  
  <form class="well form-search" id="mainform" action="<?php echo U('nav/index');?>" method="post" >
	  <select id="navcid_select" name="cid" class="normal_select">
		  		<?php if(is_array($navcats)): foreach($navcats as $key=>$vo): $navcid_selected=$navcid==$vo['navcid']?"selected":""; ?>
		             <option value="<?php echo ($vo["navcid"]); ?>" <?php echo ($navcid_selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
		  	</select>
	</form>
  <form class="J_ajaxForm" action="<?php echo U('nav/listorders');?>" method="post" >
  	
    <div class="table_list">
      <table width="100%" class="table table-hover">
        <thead>
          <tr>
            <th width="80">排序</th>
            <th width="100">ID</th>
            <th>菜单英文名称</th>
            <th width="80">状态</th>
            <th width="200">管理操作</th>
          </tr>
        </thead>
        <?php echo ($categorys); ?>
      </table>
    </div>
     <div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">排序</button>
      </div>
  </form>
</div>
<script src="/thinkcmfx1.5.0/statics/js/common.js"></script>
<script>
$(function(){
	
	$("#navcid_select").change(function(){
		$("#mainform").submit();
	});
	
	
});


</script>
</body>
</html>