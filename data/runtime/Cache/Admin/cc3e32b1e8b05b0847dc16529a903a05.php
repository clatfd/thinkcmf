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
	        <li class="active"><a href="#A" data-toggle="tab">网站信息</a></li>
	        <li><a href="#B" data-toggle="tab">SEO设置</a></li>
	        <li><a href="#C" data-toggle="tab">URL设置</a></li>
	        <li><a href="<?php echo U('route/index');?>" >URL美化</a></li>
	        <li><a href="#D" data-toggle="tab">用户同步</a></li>
	        <li><a href="#E" data-toggle="tab">评论设置</a></li>
	        <li><a href="#F" data-toggle="tab">用户名过滤</a></li>
	    </ul>
		
		<form class="J_ajaxForms" name="myform" id="myform" action="<?php echo u('setting/site_post');?>" method="post">
		 <fieldset>
		<div class="tabbable">
        <div class="tab-content">
          <div class="tab-pane active" id="A">
            <table cellpadding="2" cellspacing="2" class="table_form" width="100%">
				<tbody>
					<tr>
						<td width="180">网站名称：</td>
						<td><input type="text" class="input" name="options[site_name]" value="<?php echo ($site_name); ?>"><span class="must_red">*</span>
						<?php if($option_id): ?>
						<input type="hidden" class="input" name="option_id" value="<?php echo ($option_id); ?>">
						<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>网站域名：</td>
						<td><input type="text" class="input" name="options[site_host]" value="<?php echo ($site_host); ?>"><span class="must_red">*</span></td>
					</tr>
					<tr>
						<td>安装路径：</td>
						<td><input type="text" class="input" name="options[site_root]" value="<?php echo ($site_root); ?>"><span class="must_red">*&nbsp;&nbsp;如安装在根目录请填“/”</span></td>
					</tr>
					<tr>
						<td>模版方案：</td>
						<td>
							<select name="options[site_tpl]" class="normal_select" >
								<?php if(is_array($templates)): foreach($templates as $key=>$vo): $tpl_selected=$site_tpl==$vo?"selected":""; ?>
									<option value="<?php echo ($vo); ?>" <?php echo ($tpl_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>开启手机模板：</td>
						<td>
							<?php $mobile_tpl_enabled_checked=empty($mobile_tpl_enabled)?'':'checked'; ?>
							<label class="checkbox inline">
								<input type="checkbox" name="options[mobile_tpl_enabled]" <?php echo ($mobile_tpl_enabled_checked); ?> value="1"/>
							</label>
						</td>
					</tr>
					<tr>
						<td>后台风格：</td>
						<td>
							<select name="options[site_adminstyle]" class="normal_select" >
								<?php if(is_array($adminstyles)): foreach($adminstyles as $key=>$vo): $adminstyle_selected=$site_adminstyle==$vo?"selected":""; ?>
									<option value="<?php echo ($vo); ?>" <?php echo ($adminstyle_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>备案信息：</td>
						<td><input type="text" class="input" name="options[site_icp]" value="<?php echo ($site_icp); ?>"></td>
					</tr>
					<tr>
						<td>站长邮箱：</td>
						<td><input type="text" class="input" name="options[site_admin_email]" value="<?php echo ($site_admin_email); ?>"></td>
					</tr>
					
					<tr>
						<td>统计代码：</td>
						<td><textarea name="options[site_tongji]" rows="5" cols="57"><?php echo ($site_tongji); ?></textarea></td>
					</tr>
					<tr>
						<td>版权信息：</td>
						<td><textarea name=options[site_copyright] rows="5" cols="57"><?php echo ($site_copyright); ?></textarea></td>
					</tr>
				</tbody>
			</table>
          </div>
          <div class="tab-pane" id="B">
            <table cellpadding="2" cellspacing="2" class="table_form"
							width="100%">
							<tbody>
								<tr>
									<td width="180">SEO标题:</td>
									<td><input type="text" class="input" name="options[site_seo_title]" value="<?php echo ($site_seo_title); ?>"></td>
								</tr>
								<tr>
									<td>SEO关键字:</td>
									<td><input type="text" class="input" name="options[site_seo_keywords]" value="<?php echo ($site_seo_keywords); ?>"></td>
								</tr>
								<tr>
									<td>SEO描述:</td>
									<td><textarea name="options[site_seo_description]" rows="5" cols="57"><?php echo ($site_seo_description); ?></textarea></td>
								</tr>
							</tbody>
						</table>
          </div>
          <div class="tab-pane" id="C">
            <table cellpadding="2" cellspacing="2" class="table_form" width="100%">
							<tbody>
								<tr>
									<td width="180">url模式：</td>
									<td>
										<?php $urlmodes=array( "0"=>"普通模式", "1"=>"PATHINFO模式", "2"=>"REWRITE模式" ); ?>
										<select name="options[urlmode]"  class="normal_select">
											<?php if(is_array($urlmodes)): foreach($urlmodes as $key=>$vo): $urlmode_selected=$key==$urlmode?"selected":""; ?>
												<option value="<?php echo ($key); ?>" <?php echo ($urlmode_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
										</select>
										<span class="must_red">*&nbsp;&nbsp;如果你开启的是REWRITE模式，请确保服务器支持REWRITE；</span>
									</td>
								</tr>
								<tr>
									<td>URL伪静态后缀：</td>
									<td><input type="text" class="input" name="options[html_suffix]" value="<?php echo ($html_suffix); ?>"><span class="must_red">&nbsp;&nbsp;普通模式不支持</span></td>
								</tr>
							</tbody>
						</table>
          </div>
          <div class="tab-pane" id="D">
            <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
							<tbody>
								<tr>
									<td width="200">开启Ucenter:</td>
									<td>
										<?php $ucenter_enabled_checked=empty($ucenter_enabled)?"":"checked"; ?>
										<input type="checkbox" class="J_check" name="options[ucenter_enabled]" value="1" <?php echo ($ucenter_enabled_checked); ?>>
									</td>
								</tr>
							</tbody>
						</table>
          </div>
          <div class="tab-pane" id="E">
            <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
							<tbody>
								<tr>
									<td width="200">评论审核:</td>
									<td>
										<?php $comment_need_checked=empty($comment_need_check)?"":"checked"; ?>
										<input type="checkbox" class="J_check" name="options[comment_need_check]" value="1" <?php echo ($comment_need_checked); ?>>
									</td>
								</tr>
								<tr>
									<td width="200">评论时间间隔:</td>
									<td>
										<input type="text" name="options[comment_time_interval]" value="<?php echo ((isset($comment_time_interval) && ($comment_time_interval !== ""))?($comment_time_interval):60); ?>">
									</td>
								</tr>
							</tbody>
						</table>
          </div>
          <div class="tab-pane" id="F">
            <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
							<tbody>
								<tr>
									<td width="200">特殊用户名:</td>
									<td>
										<textarea name="cmf_settings[banned_usernames]" rows="5" cols="57"><?php echo ($cmf_settings["banned_usernames"]); ?></textarea>
									</td>
								</tr>
							</tbody>
						</table>
          </div>
        </div>
      </div>
      
      	<div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">提交</button>
          </div>
           </fieldset>
		</form>
		
	</div>
	<script type="text/javascript" src="/thinkcmfx1.5.0/statics/js/common.js"></script>
	<script>
/////---------------------
	 Wind.use('validate', 'ajaxForm', 'artDialog', function () {
			//javascript
	        var form = $('form.J_ajaxForms');
	        //ie处理placeholder提交问题
	        if ($.browser.msie) {
	            form.find('[placeholder]').each(function () {
	                var input = $(this);
	                if (input.val() == input.attr('placeholder')) {
	                    input.val('');
	                }
	            });
	        }
	        //表单验证开始
	        form.validate({
				//是否在获取焦点时验证
				onfocusout:false,
				//是否在敲击键盘时验证
				onkeyup:false,
				//当鼠标掉级时验证
				onclick: false,
	            //验证错误
	            showErrors: function (errorMap, errorArr) {
					//errorMap {'name':'错误信息'}
					//errorArr [{'message':'错误信息',element:({})}]
					try{
						$(errorArr[0].element).focus();
						art.dialog({
							id:'error',
							icon: 'error',
							lock: true,
							fixed: true,
							background:"#CCCCCC",
							opacity:0,
							content: errorArr[0].message,
							cancelVal: '确定',
							cancel: function(){
								$(errorArr[0].element).focus();
							}
						});
					}catch(err){
					}
	            },
	            //验证规则
	            rules: {'options[site_name]':{required:1},'options[site_host]':{required:1},'options[site_root]':{required:1}},
	            //验证未通过提示消息
	            messages: {'options[site_name]':{required:'请输入网站名称！'},'options[site_host]':{required:'请输入网站域名！'},'options[site_root]':{required:'请输入安装路径！'}},
	            //给未通过验证的元素加效果,闪烁等
	            highlight: false,
	            //是否在获取焦点时验证
	            onfocusout: false,
	            //验证通过，提交表单
	            submitHandler: function (forms) {
	                $(forms).ajaxSubmit({
	                    url: form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
	                    dataType: 'json',
	                    beforeSubmit: function (arr, $form, options) {
	                        
	                    },
	                    success: function (data, statusText, xhr, $form) {
	                        if(data.status){
								setCookie("refersh_time",1);
								//添加成功
								Wind.use("artDialog", function () {
								    art.dialog({
								        id: "succeed",
								        icon: "succeed",
								        fixed: true,
								        lock: true,
								        background: "#CCCCCC",
								        opacity: 0,
								        content: data.info,
										button:[
											{
												name: '确定',
												callback:function(){
													return true;
												},
												focus: true
											},{
												name: '关闭',
												callback:function(){
													return true;
												}
											}
										]
								    });
								});
							}else{
								alert(data.info);
							}
	                    }
	                });
	            }
	        });
	    });
	////-------------------------
	
	
	</script>
</body>
</html>