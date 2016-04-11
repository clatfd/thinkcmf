<?php
namespace Comment\Controller;
use Common\Controller\MemberbaseController;
class CommentController extends MemberbaseController{
	
	protected $comments_model;
	
	function _initialize() {
		parent::_initialize();
		$this->comments_model=D("Common/Comments");
	}
	
	function index(){
		$uid=sp_get_current_userid();
		$where=array("uid"=>$uid);
		
		$count=$this->comments_model->where($where)->count();
		
		$page=$this->page($count,20);
		$page->setLinkWraper("li");
		
		$comments=$this->comments_model->where($where)
		->order("createtime desc")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
		$this->assign("pager",$page->show("default"));
		$this->assign("comments",$comments);
		$this->display(":index");
	}
	
	function post(){
		/* if($_SESSION['_verify_']['verify']!=I("post.verify")){
			$this->error("验证码错误！");
		} */
		
		if (IS_POST){
			
			$post_table=sp_authcode($_POST['post_table']);
			
			$_POST['post_table']=$post_table;
			
			$url=parse_url(urldecode($_POST['url']));
			$query=empty($url['query'])?"":"?{$url['query']}";
			$url="{$url['scheme']}://{$url['host']}{$url['path']}$query";

			$_POST['url']=sp_get_relative_url($url);
			
			if(isset($_SESSION["user"])){//用户已登陆,且是本站会员
				$uid=$_SESSION["user"]['id'];
				$_POST['uid']=$uid;
				$users_model=M('Users');
				$user=$users_model->field("user_login,user_email,user_nicename")->where("id=$uid")->find();
				$username=$user['user_login'];
				$user_nicename=$user['user_nicename'];
				$email=$user['user_email'];
				$_POST['full_name']=empty($user_nicename)?$username:$user_nicename;
				$_POST['email']=$email;
			}
			
			if(C("COMMENT_NEED_CHECK")){
				$_POST['status']=0;//评论审核功能开启
			}else{
				$_POST['status']=1;
			}
			
			if ($this->comments_model->create()){
				$this->check_last_action(intval(C("COMMENT_TIME_INTERVAL")));
				$result=$this->comments_model->add();
				if ($result!==false){
					
					//评论计数
					$post_table=ucwords(str_replace("_", " ", $post_table));
					$post_table=str_replace(" ","",$post_table);
					$post_table_model=M($post_table);
					$pk=$post_table_model->getPk();
					
					$post_table_model->create(array("comment_count"=>array("exp","comment_count+1")));
					$post_table_model->where(array($pk=>intval($_POST['post_id'])))->save();
					
					$post_table_model->create(array("last_comment"=>time()));
					$post_table_model->where(array($pk=>intval($_POST['post_id'])))->save();
					if($_POST['to_uid']){
						$users_model=M("Users");
						$find_user=$users_model->where(array("id"=>$_POST["to_uid"]))->find();
						$receiver=$find_user["user_email"];
						$content="Dear ".$find_user["user_nicename"].", <br/>Your comment posted on <a href='http://clatfd.cn/thinkcmfx/".$_POST["url"]."'>http://clatfd.cn/thinkcmfx/".$_POST["url"]. "</a> is replied.";
						$this->sendmail($receiver, "Comment Reply from clatfd.cn", $content);
						// sp_send_email($receiver, "Comment Reply from clatfd.cn", $content);
					}
					$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"评论成功！",1));
				} else {
					$this->error("评论失败！");
				}
			} else {
				$this->error($this->comments_model->getError());
			}
		}
		
	}

	function sendmail($address,$subject,$message){
	 	//sp_send_email($receiver, $title, $content);
	 	import("PHPMailer");
		$mail=new \PHPMailer();
		// 设置PHPMailer使用SMTP服务器发送Email
		$mail->IsSMTP();
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 25;
		$mail->IsHTML(true);
		// 设置邮件的字符编码，若不指定，则为'UTF-8'
		$mail->CharSet='UTF-8';
		// 添加收件人地址，可以多次使用来添加多个收件人
		$mail->addAddress($address, '');
		// 设置邮件正文
		$mail->Body=$message;
		// 设置邮件头的From字段。
		$mail->From=C('SP_MAIL_ADDRESS');
		// 设置发件人名字
		$mail->FromName=C('SP_MAIL_SENDER');;
		// 设置邮件标题
		$mail->Subject=$subject;
		// 设置SMTP服务器。
		$mail->Host=C('SP_MAIL_SMTP');
		// 设置为"需要验证"
		$mail->SMTPAuth=true;
		// 设置用户名和密码。
		$mail->Username=C('SP_MAIL_LOGINNAME');
		$mail->Password=C('SP_MAIL_PASSWORD');
		// 发送邮件。
		if(!$mail->Send()) {
	 		//$this->error('邮件发送失败！');
		}else{
	 		//$this->success('邮件发送！');
		}
	}
}