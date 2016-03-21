<?php
namespace Wordlist\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		$_SESSION['login_http_referer']="index.php?g=wordlist&m=member&a=index";
	}
	
	function index(){
	  	$this->display(":login");
	}
}