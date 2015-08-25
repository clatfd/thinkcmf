<?php
namespace Sensor\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	private $sensordata=array();
	

	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Sensor/Sensor");

		$this->sensordata[70] = array('name' => "Body Weight", 'type' => "Line");
		$this->sensordata[75] = array('name' => "Push Up", 'type' => "Bar");
		$this->sensordata[20] = array('name' => "Pull Up", 'type' => "Bar");
	}
	function index(){
		$sn=I("get.sn")?I("get.sn"):75;
		$this->assign("sn",$sn);
		$this->assign("sname",$this->sensordata[$sn]['name']);
		$this->display(":index");
	}
	function content(){
		$sn=I("get.sn")?I("get.sn"):75;
		$this->assign("sn",$sn);
		$this->assign("type",$this->sensordata[$sn]['type']);

		//$this->display(":echart");//new
		$this->display(":content");//old
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
			$datai=(float)$post[$i]['sensordata'];
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