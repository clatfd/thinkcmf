<?php
namespace Sensor\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function index(){
	  $this->display(":index");
	}
	function content(){
		$this->display(":content");
	}
}