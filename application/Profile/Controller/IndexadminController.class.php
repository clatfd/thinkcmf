<?php
namespace Profile\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	protected $profile_obj;
	protected $viplist_model;

	function _initialize() {
		parent::_initialize();
		$this->profile_obj = D("Profile/visitorrecord");
		$this->viplist_model =D("Profile/viplist");
	}
	
	function viprecord(){
		$viprecord_src = $this->profile_obj->order("id ASC")->select();
		$this->assign("viprecord",$viprecord_src);
		$this->display();
	}
	function viplist(){
		$viplist_src = $this->viplist_model->order("id ASC")->select();
		$this->assign("viplist",$viplist_src);
		$this->display();
	}
	function addnewvip(){
		if(IS_POST){
			if ($this->viplist_model->create()) {
				$result=$this->viplist_model->add($_POST);
				if ($result!==false) {
					$this->success("添加成功！");
				}
				else {
					$this->error("添加失败！");
				}
			}
			else {
				$this->error($this->viplist_model->getError());
			}
		}
	}
	function delviprecord(){
		$id=I("get.id");
		if ($this->profile_obj->delete($id)!==false) {
			$this->success("删除成功！");
		}
		else 
			$this->error("删除失败！");
	}
	function delviprecords(){
		if(isset($_POST['idlo'])&&isset($_POST['idup']))
		$idlo=$_POST['idlo'];
		$idup=$_POST['idup'];
		if ($this->profile_obj->where(array('id'=>array(array('egt',$idlo),array('elt',$idup))))->delete()!==false) {
			$this->success("删除成功！");
		}
		else 
			$this->error("删除失败！");
	}
	
}
