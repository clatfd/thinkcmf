<?php
namespace Profile\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	protected $posts_model;
	protected $viplist_model;

	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Profile/visitorrecord");
		$this->viplist_model =D("Profile/viplist");
	}
		
	
	function index(){
	  $this->display(":index");
	}
	function content(){
		$this->display(":content");
	}
	function ram(){
		$this->display(":ramindex");
	}
	function ramcontent(){
		$this->display(":relation");
	}

//for professor
	function cv(){
		if(I("get.vs")||isset($_SESSION["user"])||isset($_SESSION['vip'])){
			if(I("get.vs")){
				$vs= I("get.vs");
				$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
				if(sizeof($vipsrc))
					$vipname=$vipsrc[0]['name'];
				else
					$vipname="";
			}
			elseif(isset($_SESSION["user"]))
				$vipname=$_SESSION["user"];
			elseif(isset($_SESSION["vip"]))
				$vipname=$_SESSION["vip"];
			else
				$vipname="";
			$_SESSION['vip']=$vipname;
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'cv','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				$this->success("Welcome ".$vipname."!",U('portal/page/index',array('id'=>110)),1);
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			$this->error("Register and login required",U('user/register/index'));
	}

	function resume(){
		if(isset($_SESSION['vip'])||isset($_SESSION["user"])){
			if(isset($_SESSION['vip']))
				$pfname= $_SESSION['vip'];
			elseif(isset($_SESSION["user"]))
				$pfname= $_SESSION['user'];
			$pfname= $_SESSION['vip'];
			$insert_data=array('visitorname'=>$pfname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'resume','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				header("location:index.php?m=page&a=index&id=74");
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			$this->error("Register and login required",U('user/register/index'));
	}

	function archive(){
		if(isset($_SESSION['vip'])||isset($_SESSION["user"])){
			if(isset($_SESSION['vip']))
				$pfname= $_SESSION['vip'];
			elseif(isset($_SESSION["user"]))
				$pfname= $_SESSION['user'];
			$insert_data=array('visitorname'=>$pfname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'archive','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				header("location:index.php?m=page&a=index&id=75");
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			$this->error("Register and login required",U('user/register/index'));
	}
	function toindex(){
		if(I("get.vs")){
			$vs= I("get.vs");
			$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
			if(sizeof($vipsrc))
				$vipname=$vipsrc[0]['name'];
			else
				$vipname="";
			
			$_SESSION['vip']=$vipname;
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'index','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				$this->success("Welcome ".$vipname."!",U('/'),1);
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			$this->error("Register and login required",U('user/register/index'));
	}
	function echovip(){
		var_dump($_SESSION);
	}
	function testvip(){
		if(isset($_SESSION['vip'])){
			var_dump($_SESSION);
		}
		else
			echo "No vip";
	}
}
