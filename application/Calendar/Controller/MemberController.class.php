<?php
namespace Calendar\Controller;
use Common\Controller\MemberbaseController;

class MemberController extends MemberbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Calendar/Calendar");
	}

	function add(){
		if(IS_POST){
			if(isset($_POST["id"])){

			}
			else{
				$_POST["mem"]=$_SESSION["user"]["user_nicename"];
				$_POST["show"]=0;
				$_POST["privacy"]=3;
				$result=$this->posts_model->add($_POST);
			}
			if ($result!==false) {
				// $this->success("添加成功！");
				//echo json_encode(array('status' => 1));
				$this->ajaxReturn(sp_ajax_return(array("id"=>$result,"backgroundColor"=>"rgb(255, 0, 0)"),"添加成功！",1));
			}
			else {
				$this->error("添加失败！");
			}
		}
		else{
			$this->error("添加失败！");
		}
	}

}