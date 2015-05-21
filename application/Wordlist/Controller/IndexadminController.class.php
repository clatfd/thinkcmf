<?php
namespace Wordlist\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{

	function _initialize() {
		parent::_initialize();
		$this->todo_obj = D("Todo/Todo");
	}
		
	function index(){
		//$this->display();
		//echo "<script laguage='javascript'>window.open("."/H-wordlist/".");</script>";
		header("Location:/H-wordlist/");
	}

}