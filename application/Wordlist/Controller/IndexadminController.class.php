<?php
namespace Wordlist\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{

	function _initialize() {
		parent::_initialize();
		$this->wordusergro_obj = D("Wordlist/wdusergro");
		$this->wordremark_obj = D("Wordlist/wdremark");
	}
		
	function index(){
		//header("Location:/H-wordlist/");
		$totalitems=$this->wordusergro_obj->count();
		$users=$this->wordusergro_obj->field('userid')->select();
		$users=array_unique(array_column($users, 'userid'));
		$usernum=sizeof($users);
		$remarknum=$this->wordremark_obj->count();
		$this->assign('totalitems',$totalitems);
		$this->assign('usernum',$usernum);
		$this->assign('remarknum',$remarknum);
		$this->display();

	}

}