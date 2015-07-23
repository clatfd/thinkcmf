<?php
namespace Profile\Controller;
use Common\Controller\MemberbaseController;

class MemberController extends MemberbaseController{
	function cv(){
		header("location:index.php?m=page&a=index&id=110");
	}
	function resume(){
		header("location:index.php?m=page&a=index&id=74");
	}
	function archive(){
		header("location:index.php?m=page&a=index&id=75");
	}
}
