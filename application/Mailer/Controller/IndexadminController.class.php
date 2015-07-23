<?php
namespace Mailer\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function index()
	{
		$this->display();
	}
	function sent(){
		$mailaddr=explode(",",$_POST['list']);
		$receiver=$_POST['list'];
		$subject=$_POST['subject'];
		$content=$_POST['content'];
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
		for($i=0;$i<count($mailaddr);$i++){
			$mail->addAddress($mailaddr[$i], '');
		}
		// 设置邮件正文
		$mail->Body=$content;
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
	 		$this->error('邮件发送失败！');
		}else{
	 		$this->success('邮件发送！');
		}
	}
}