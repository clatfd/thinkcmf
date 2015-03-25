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
     <li class="active"><a href="<?php echo U('storage/index');?>">文件存储</a></li>
  </ul>
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="<?php echo U('storage/setting_post');?>">
    	<?php $support_storages=array("Local"=>"系统默认","Qiniu"=>"七牛云存储"); ?>
    	<select name="type">
    		<?php if(is_array($support_storages)): foreach($support_storages as $key=>$vo): $type_selected=$type==$key?"selected":""; ?>
    			<option value="<?php echo ($key); ?>" <?php echo ($type_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
    	</select>
      <div class="">
      	<ul class="nav nav-tabs">
	     <li class="active"><a>七牛云存储</a></li>
	  </ul>
      	<table width="100%" cellpadding="2" cellspacing="2" >
	        <tbody>
	        	<tr>
	        		<td width="120">AccessKey</td>
	        		<td><input type="text" class="input mr5" name="Qiniu[accessKey]" value="<?php echo ($Qiniu["accessKey"]); ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td>SecretKey</td>
	        		<td><input type="text" class="input mr5" name="Qiniu[secrectKey]" value="<?php echo ($Qiniu["secrectKey"]); ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td>空间域名</td>
	        		<td><input type="text" class="input mr5" name="Qiniu[domain]" value="<?php echo ($Qiniu["domain"]); ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td>空间名称</td>
	        		<td><input type="text" class="input mr5" name="Qiniu[bucket]" value="<?php echo ($Qiniu["bucket"]); ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td>获取AccessKey</td>
	        		<td><a href="https://portal.qiniu.com/signup?code=3lfihpz361o42" target="_blank">马上获取</a></td>
	        	</tr>
	        	<tr>
	        		<td>七牛专享优惠码</td>
	        		<td><a href="http://www.thinkcmf.com/topic/topic/index/id/103.html" target="_blank">507670e8</a></td>
	        	</tr>
			</tbody>
	    </table>
  		</div>
  		<div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">确定</button>
      </div>
    </form>
  </div>
</div>
<script src="/thinkcmfx1.5.0/statics/js/common.js?"></script>
</body>
</html>