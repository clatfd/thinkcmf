<?php
namespace Movie\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Movie/movie");
	}

	function index(){
		$sort_method=I("get.sort");
		if(empty($sort_method)){
			$sort_method="viewdate";
		}
		$desc=I("get.sortorder");
		if(empty($desc)){
			$asc="DESC";
		}
		else{
			$asc="";
		}
		$count=$this->posts_model->count();
		$page = $this->page($count, 20);
		$movielist=$this->posts_model
		->limit($page->firstRow . ',' . $page->listRows)
		->field('id,imdbid,dbid,myrating,moviename,avgrating,director,year,viewdate,poster')
		->order($sort_method." ".$asc)
		->select();
		$this->assign("sort", $sort_method);
		$this->assign("sortorder", $asc);
		$this->assign("Page", $page->show('Admin'));
		$this->assign("movielist",$movielist);
	  	$this->display('movieadd');
	}

	function addmovie(){
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
				$this->error($this->posts_model->getError());
			}
		}
	}

	function del(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->posts_model->where("id=$id")->delete()!==false) {
				$this->success("删除成功！");
				// $this->ajaxReturn(sp_ajax_return(array("id"=>$id),"删除成功！",1));
			} else {
				$this->error("删除失败！");
			}
		}
	}

}