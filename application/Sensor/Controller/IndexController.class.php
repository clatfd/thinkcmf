<?php
namespace Sensor\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Sensor/Sensor");
	}
	function index(){
	  $this->display(":index");
	}
	function content(){
		$this->display(":echart");
	}
	function index70(){
	  $this->display(":index70");
	}
	function content70(){
		$this->display(":echart70");
	}
	function index20(){
	  $this->display(":index20");
	}
	function content20(){
		$this->display(":echart20");
	}
	//for android only
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
		else {
			$this->error("No POST!");
		}
	}
	//get data for chart
	function getdata(){
		$id=  intval(I("get.sensorno"));
		$num=  intval(I("get.num"));
		$data= array();
		$time= array();
		$datai= array();
		$timei= array();
		$post=$this->posts_model->where("sensorno=$id")->order("id desc")->limit($num)->select();
		for ($i=0;$i<sizeof($post);$i++)
		{	
			$datai=(int)$post[$i]['sensordata'];
			$timei=substr($post[$i]['time'],0,10);
			array_unshift($data,$datai);
			array_unshift($time,$timei);
		}

		$etda = json_encode(array("data"=>$data,"time"=>$time));
		if(isset($_GET['callback'])){
			$callback=$_GET['callback'];  
		    echo $callback."($etda)";
		}
		else
			echo $etda;
	}
}