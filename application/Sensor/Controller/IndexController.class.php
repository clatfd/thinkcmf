<?php
namespace Sensor\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	private $sensordata=array();
	

	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Sensor/Sensor");
		$this->mi_model =D("Sensor/Mifit");

		$this->sensordata[70] = array('name' => "Body Weight", 'type' => "Line",'serialtype' => 1,'legend'=>'Kg');
		$this->sensordata[75] = array('name' => "Push Up", 'type' => "Bar",'serialtype' => 1,'legend'=>'times');
		$this->sensordata[20] = array('name' => "Pull Up", 'type' => "Bar",'serialtype' => 1,'legend'=>'times');
		$this->sensordata[2000] = array('name' => "Run", 'type' => "Bar",'serialtype' => 1,'legend'=>'meters');
		$this->sensordata[95] = array('name' => "Gym", 'type' => "Bar",'serialtype' => 1,'legend'=>'times');
		$this->sensordata['mi_slp'] = array('name' => "Sleep duration", 'type' => "Line",'serialtype' => 2,'legend'=>array('sleep hours','deep sleep hours'));
		$this->sensordata['mi_stp'] = array('name' => "Steps", 'type' => "Bar",'serialtype' => 1,'legend'=>'steps');
		$this->sensordata['mi_sw'] = array('name' => "Sleep/Wake time", 'type' => "Scatter",'serialtype' => 3,'legend'=>'Hour:Min');
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
		$this->assign("legend",$this->sensordata[$sn]['legend']);
		if($this->sensordata[$sn]['serialtype']==1){
			//$this->display(":echart");//new
			$this->display(":content");//old
		}
		elseif($this->sensordata[$sn]['serialtype']==2){
			$this->display(":contentdouble");//old
		}
		elseif($this->sensordata[$sn]['serialtype']==3){
			$this->display(":scatter");//old
		}
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
	//for android only
	function postmidata(){
		if(IS_POST){
			if(!empty($_POST["date"])){
				$postdate=$_POST["date"];
				$existitem=$this->mi_model->where(array("date"=>$postdate))->find();
				if(!$existitem){
					if ($this->mi_model->create()) {
						$result=$this->mi_model->add($_POST);
						if ($result!==false) {
							$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"OK",1));
						}
						else {
							$this->error("添加失败！");
						}
					}
					else {
						$this->error($this->mi_model->getError());
					}
				}
				else{
					$result=$this->mi_model->where(array('date' => $_POST["date"]))->save($_POST);
					if ($result!==false) {
						$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"OK",1));
					}
					else {
						$this->error("修改失败！");
					}
				}
			}
		}
		else {
			$this->error("No POST!");
		}
	}
	//get data for chart
	function getdata(){
		$id=I("get.sensorno")?I("get.sensorno"):75;
		$num= I("get.num")?intval(I("get.num")):15;
		if($id=="mi_slp"){
			$lt= array();
			$dp= array();
			$time= array();
			$lti= array();
			$dpi= array();
			$timei= array();
			$midata=$this->mi_model->order("date desc")->limit($num)->field("date,summary")->select();
			//var_dump(json_decode($midata[0]['summary'])->slp->lt);
			for ($i=0;$i<sizeof($midata);$i++){
				$sm=json_decode($midata[$i]['summary']);
				$slpi=$sm->slp->st;
				$waki=$sm->slp->ed;
				//avoid blank data
				if($slpi==$waki)
					continue;
				$lti=number_format(($sm->slp->lt+$sm->slp->dp)/60,1);
				$dpi=number_format($sm->slp->dp/60,1);
				$timei=$midata[$i]['date'];
				array_unshift($lt,$lti);
				array_unshift($dp,$dpi);
				array_unshift($time,$timei);
			}
			$etda = json_encode(array("data1"=>$lt,"data2"=>$dp,"time"=>$time));
		}
		elseif($id=="mi_stp"){
			$stp= array();
			$time= array();
			$stpi= array();
			$timei= array();
			$midata=$this->mi_model->order("date desc")->limit($num)->field("date,summary")->select();
			 // var_dump(json_decode($midata[0]['summary'])->stp->ttl);
			for ($i=0;$i<sizeof($midata);$i++){
				$sm=json_decode($midata[$i]['summary']);
				$stpi=$sm->stp->ttl;
				$timei=$midata[$i]['date'];
				array_unshift($stp,$stpi);
				array_unshift($time,$timei);
			}
			$etda = json_encode(array("data"=>$stp,"time"=>$time));
		}
		elseif($id=="mi_sw"){
			$data= array();
			$midata=$this->mi_model->order("date desc")->limit($num)->field("date,summary")->select();
			//var_dump(json_decode($midata[0]['summary'])->slp);
			for ($i=0;$i<sizeof($midata);$i++){
				$sm=json_decode($midata[$i]['summary']);
				$slpi=$sm->slp->st;
				$waki=$sm->slp->ed;
				//avoid blank data
				if($slpi==$waki)
					continue;
				$slpi=$slpi%(24*3600);
				$waki=$waki%(24*3600);
				//unixtime start from 8:00 beijing time, add a day to time from 8:00-24:00
				if($waki<16*3600)
					$waki+=24*3600;
				//add a day to time from 8:00-18:00, starting from 18:00~
				if($slpi<10*3600)
					$slpi+=24*3600;
				$dpi=number_format($sm->slp->dp/60,1);
				$timei=$midata[$i]['date'];
				array_unshift($data,array('date'=>$timei,'x'=>$slpi, 'y'=>$waki, 'z'=>$dpi));
				// $slpi=$sm->slp->st+8*3600;
				// $waki=$sm->slp->ed;
				// $timei=$midata[$i]['date'];
				// $slpi="2015-01-01".substr(date(DATE_ATOM,$slpi),10,19);
				// $waki="2015-01-01".substr(date(DATE_ATOM,$waki),10,19);
				// array_unshift($data,array('x'=>$slpi,'y'=>$waki,'date'=>$timei));
			}
			// $etda = json_encode($data);
			$etda = json_encode(array("data"=>$data));
		}
		else{
			$data= array();
			$time= array();
			$datai= array();
			$timei= array();
			$post=$this->posts_model->where("sensorno=$id")->order("id desc")->limit($num)->select();
			for ($i=0;$i<sizeof($post);$i++){	
				$datai=(float)$post[$i]['sensordata'];
				$timei=substr($post[$i]['time'],0,10);
				array_unshift($data,$datai);
				array_unshift($time,$timei);
			}
			$etda = json_encode(array("data"=>$data,"time"=>$time));
		}
		if(isset($_GET['callback'])){
			$callback=$_GET['callback'];  
		    echo $callback."($etda)";
		}
		else
			echo $etda;
	}

	//calendar
	function getCalData(){
		if(isset($_GET["month"])){
			$getmonth=$_GET["month"];
		}
		else{
			$getmonth=date('Y-m',time());
		}
		$yearmonth = explode('-',$getmonth);

		$condition=array();
		$condition['sensorno']=array(75,2000,20,95,'or');
		$start = date('Y-m-d',mktime(0,0,0,$yearmonth[1],-7,$yearmonth[0]));
		$end = date('Y-m-d',mktime(0,0,0,$yearmonth[1]+1,7,$yearmonth[0]));
		$condition["time"]=array(array("egt",$start),array("elt",$end));

		$post=$this->posts_model->where($condition)->order("time")->select();
		$etda=array();
		for ($i=0;$i<sizeof($post);$i++){	
			$post[$i]['date']=substr($post[$i]['time'],0,10);
			unset($post[$i]['time']);
		}
		$etda = json_encode($post);
		if(isset($_GET['callback'])){
			$callback=$_GET['callback'];  
		    echo $callback."($etda)";
		}
		else
			echo $etda;
	}

}