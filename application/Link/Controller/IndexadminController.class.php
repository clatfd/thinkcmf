<?php
namespace Link\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Link/shortcut");
	}

	function index(){
		$linkdata = $this->posts_model->order("id ASC")->select();
		for($i=0; $i<sizeof($linkdata);$i++) {
			$linkdata[$i]["shortcut"]="http://s.clatfd.cn/".$linkdata[$i]["shortcut"];
		}
		$this->assign("linkrecord",$linkdata);
	 	$this->display();
	}
	
	function postdata(){
		if(IS_POST){
			if ($this->posts_model->create()) {
				$result=$this->posts_model->add($_POST);
				if ($result!==false) {
					$this->success("添加成功！");
				}
				else {
					$this->error("添加失败！");
				}
			}
			else {
				$this->error("添加失败！");
			}
		}
	}

}