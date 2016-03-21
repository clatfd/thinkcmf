<?php
namespace Profile\Controller;
use Common\Controller\HomeBaseController;

class RemarkController extends HomeBaseController{
	protected $posts_model;

	function index(){
		if(isset($_GET["src"])&&$_GET["src"]!=""){
			$this->assign("src",$_GET["src"]);
  			$this->display(":remarkindex");
		}
	}

	function content(){
		if(isset($_GET["src"])&&$_GET["src"]!=""){
			$this->assign("src",$_GET["src"]);
  			$this->display(":remark");
		}
		
	}
}