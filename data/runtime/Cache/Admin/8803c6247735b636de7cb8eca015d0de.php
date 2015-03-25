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
<style>
.home_info li em {
float: left;
width: 100px;
font-style: normal;
}
li {
list-style: none;
}

</style>
</head>

<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <h4>Notable Notice</h4>
  <div class="home_info">
    <ul id="notable_notices">
      <li><img src="/ThinkCMFX1.5.0/tpl_admin/simpleboot/assets/images/loading.gif"  style="vertical-align: middle;"/><span style="display:inline-block;vertical-align: middle;">加载中...</span></li>
    </ul>
  </div>
  <h4 class="well">System Notice</h4>
  <div class="home_info">
    <ul id="thinkcmf_notices">
    	<li><img src="/ThinkCMFX1.5.0/tpl_admin/simpleboot/assets/images/loading.gif"  style="vertical-align: middle;"/><span style="display:inline-block;vertical-align: middle;">加载中...</span></li>
    </ul>
  </div>
  <h4 class="well">System Info</h4>
  <div class="home_info">
    <ul>
      <?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li> <em><?php echo ($key); ?></em> <span><?php echo ($vo); ?></span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
</div>
<script src="/ThinkCMFX1.5.0/statics/js/common.js"></script> 
<script>
//get notable notice

//获取官方通知
$.getJSON("http://www.thinkcmf.com/service/sms_jsonp.php?callback=?",function(data){
	var tpl='<li><em class="title"></em><span class="content"></span></li>';
	var $thinkcmf_notices=$("#thinkcmf_notices");
	$thinkcmf_notices.empty();
	if(data.length>0){
		$.each(data,function(i,n){
			var $tpl=$(tpl);
			$(".title",$tpl).html(n.title);
			$(".content",$tpl).html(n.content);
			$thinkcmf_notices.append($tpl);
		});
	}else{
		$thinkcmf_notices.append("<li>^_^,没有通知~~</li>");
	}
	
});
</script>
</body>
</html>