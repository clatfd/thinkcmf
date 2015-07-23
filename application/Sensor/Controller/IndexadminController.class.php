<?php
namespace Sensor\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Sensor/Sensor");
	}
	//show post data
	function index(){
	  $this->display();
	}
	
	function postdata(){
		if(IS_POST){
			if ($this->posts_model->create()) {
				$_POST['time']=date("Y-m-d H:i:s",time());
				$result=$this->posts_model->add($_POST);
				if ($result!==false) {
					$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"OK",1));
				}
				else {
					$this->error("添加失败！");
				}
			}
			else {
				$this->error($this->posts_model->getError());
			}
		}
	}

	function getdata(){
		
	}
}