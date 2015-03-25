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

	<link href="/ThinkCMFX1.5.0/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/ThinkCMFX1.5.0/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/ThinkCMFX1.5.0/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/ThinkCMFX1.5.0/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/ThinkCMFX1.5.0/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/ThinkCMFX1.5.0/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/ThinkCMFX1.5.0/statics/js/jquery.js"></script>
    <script src="/ThinkCMFX1.5.0/statics/js/wind.js"></script>
    <script src="/ThinkCMFX1.5.0/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<body class="J_scroll_fixed">
<div class="wrap jj">
  <ul class="nav nav-tabs">
     <li class="active"><a href="<?php echo U('User/userinfo');?>">修改信息</a></li>
     <li><a href="<?php echo U('setting/password');?>">修改密码</a></li>
  </ul>
  <div class="common-form">
    <form class="form-horizontal J_ajaxForm" method="post" action="<?php echo U('User/userinfo_post');?>">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="input01">昵称:</label>
            <div class="controls">
              <input type="hidden" class="input" name="id" value="<?php echo ($id); ?>">
              <input type="text" name="user_nicename" value="<?php echo ($user_nicename); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">性别:</label>
            <div class="controls">
              <select name="sex">
              	<?php $sexs=array("0"=>"保密","1"=>"男","2"=>"女"); ?>
              	<?php if(is_array($sexs)): foreach($sexs as $key=>$vo): $sexselected=$key==$sex?"selected":""; ?>
					<option value="<?php echo ($key); ?>" <?php echo ($sexselected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
          </div>
          <div class="control-group">
				<label class="control-label" for="input-birthday">生日</label>
				<div class="controls">
					<input class="J_date" type="text" id="input-birthday" placeholder="2013-01-04" name="birthday" value="<?php echo ($birthday); ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-user_url">个人网址</label>
				<div class="controls">
					<input type="text" id="input-user_url" placeholder="http://thinkcmf.com" name="user_url" value="<?php echo ($user_url); ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-signature">个性签名</label>
				<div class="controls">
					<textarea id="input-signature" placeholder="个性签名" name="signature"><?php echo ($signature); ?></textarea>
				</div>
			</div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">更新</button>
          </div>
        </fieldset>
      </form>
  </div>
</div>
<script src="/ThinkCMFX1.5.0/statics/js/common.js"></script>

</body>
</html>