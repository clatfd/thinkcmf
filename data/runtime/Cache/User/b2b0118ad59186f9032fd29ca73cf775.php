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
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="#">
      <div class="table_list">
	    <table class="table table-hover">
	        <thead>
	          <tr>
	            <th align='center'>ID</th>
	            <th>来源</th>
	            <th>用户名</th>
	            <th>头像</th>
	            <th>绑定账号</th>
	            <th>首次登录时间</th>
	            <th>最后登录时间</th>
	            <th>最后登录IP</th>
	            <th>登录次数</th>
	            <th align='center'>操作</th>
	          </tr>
	        </thead>
	        <tbody>
	        	<?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
	            <td align='center'><?php echo ($vo["id"]); ?></td>
	            <td><?php echo ($vo["from"]); ?></td>
	            <td><?php echo ($vo["name"]); ?></td>
	            <td><img width="25" height="25" src="<?php echo ($vo["head_img"]); ?>" /></td>
	            <td><?php echo ((isset($vo['uid']) && ($vo['uid'] !== ""))?($vo['uid']):'无'); ?></td>
	            <td><?php echo ($vo['create_time']); ?></td>
	            <td><?php echo ($vo['last_login_time']); ?></td>
	            <td><?php echo ($vo["last_login_ip"]); ?></td>
	            <td><?php echo ($vo["login_times"]); ?></td>
	            <td align='center'>
		            <a href="<?php echo U('oauthadmin/delete',array('id'=>$vo['id']));?>" class="J_ajax_del" >删除</a>
		        </td>
	          	</tr><?php endforeach; endif; ?>
			</tbody>
	      </table>
	      <div class="pagination"><?php echo ($page); ?></div>
  </div>
    </form>
  </div>
</div>
<script src="/thinkcmfx1.5.0/statics/js/common.js"></script>
<script>
</script>
</body>
</html>