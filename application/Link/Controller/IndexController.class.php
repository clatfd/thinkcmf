<?php
namespace Link\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Link/shortcut");
	}

	function index(){
		if(isset($_GET['id'])&&$_GET["id"]!=""){
			echo "redirecting".$_GET["id"]."<br/>";
			$getdata=$this->posts_model->where(array("shortcut"=>$_GET["id"]))->field("url")->find();
			var_dump($getdata);
			$url=$getdata["url"];
			if(substr($url,0,4)!="http")
				$url="http://".$url;
			echo "redirecting to".$url;
			header("location:".$url);
		}
		else
			echo "No input!";
	}

}