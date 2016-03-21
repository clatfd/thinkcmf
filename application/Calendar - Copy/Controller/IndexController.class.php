<?php
namespace Calendar\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Calendar/Calendar");
	}

	function index(){
	  $this->display(":index");
	}

	function content(){
	  $this->display(":content");
	}

	function query(){

	}
}