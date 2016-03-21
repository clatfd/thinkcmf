<?php
namespace Calendar\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Calendar/Calendar");
	}

	function index(){
	  $this->display();
	}

}