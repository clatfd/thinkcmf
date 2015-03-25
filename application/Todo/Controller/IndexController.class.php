<?php
namespace Todo\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	protected $todo_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->todo_obj = D("Todo/Todo");
	}
	function index()
	{
		$this->display(":index");
	}
	function content(){
	  $todos_src = $this->todo_obj
		->where(array("show"=>1,'privacy'=>1))
		->order("listname, priority ASC")
		->select();
		
		$tds=array();
		foreach ($todos_src as $r){
			$todid=$r['id'];
			$listname=$r['listname'];
			if($r['state']==1)
				$tds["$listname"]['todos']["$todid"]=$r;
			elseif($r['state']==2)
				$tds["$listname"]['doings']["$todid"]=$r;
			elseif($r['state']==3)
				$tds["$listname"]['dones']["$todid"]=$r;
		}
		$this->assign("tds",$tds);
		$this->display(":content");
	  // $this->display(":index");
	}

}