<?php
namespace Profile\Controller;
use Common\Controller\HomeBaseController;

class ProjectController extends HomeBaseController{
	protected $posts_model;
	protected $viplist_model;

	function _initialize() {
		parent::_initialize();
		$this->proj_model =D("Profile/proj");
	}
		
	
	function index(){
	  	$this->display(":proj");
	}
	function pjcontent(){
		$proj_raw = $this->proj_model->where(array("isshow"=>1))->order("startdate DESC")->select();
		$this->assign("pj",$proj_raw);
		$this->display(":pjcontent");
	}
	function ram(){
		$this->display(":ramindex");
	}
	function ramcontent(){
		$this->display(":relation");
	}
	function rampjdata(){
		$proj_raw = $this->proj_model->field("id,category,name,value,target,weight,url")->select();
		echo json_encode($proj_raw);
	}
}
