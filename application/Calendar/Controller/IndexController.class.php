<?php
namespace Calendar\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Calendar/Calendar");
	}

	function index(){
	  $this->display(":index");
	}

	function content(){
		$tz=I("get.tz");
		if(!isset($tz)||$tz==''){
			$tz="+8";
		}
		$this->assign("tz",$tz);
	  	$this->display(":content");
	}

	protected function _query($yearmonth){
		$start = date('Y-m-d',mktime(0,0,0,$yearmonth[1],-7,$yearmonth[0]));
		$end = date('Y-m-d',mktime(0,0,0,$yearmonth[1]+1,7,$yearmonth[0]));
		$condition =array();
		$condition["show"]=1;
		$condition["privacy"]=1;
		$condition["start"]=array(array("egt",$start),array("elt",$end));

		$event_src = $this->posts_model->where($condition)->select();

		if(isset($_SESSION["user"]["user_nicename"])){
			$event_mem_src = $this->posts_model->where(array("mem"=>$_SESSION["user"]["user_nicename"]))->select();
			$event_src=array_merge($event_src,$event_mem_src);
		}

		$events=array();
		foreach ($event_src as $r){
			$item=array('nid'=>$r["id"],'title'=>$r["title"],'start'=>$r["start"],'allDay'=>(bool)$r["allDay"]);
			if($r["end"])
				$item["end"]=$r["end"];
			if($r["url"])
				$item["d_url"]=$r["url"];
			if($r["description"])
				$item["description"]=$r["description"];
			//if($r["repid"])
				$item["id"]=$r["id"];
			if($r["evtype"]=="Courses")
				$item["backgroundColor"]="rgb(55, 134, 26)";
			elseif($r["evtype"]=="Labs")
				$item["backgroundColor"]="rgb(39, 160, 201)";
			elseif($r["evtype"]=="Hobbies")
				$item["backgroundColor"]="rgb(255, 212, 70)";
			elseif($r["evtype"]=="guest")
				$item["backgroundColor"]="rgb(255, 0, 0)";
			else{
				$item["backgroundColor"]="rgb(58, 135, 173)";
			}
			$item["borderColor"]="#fff";
			array_push($events, $item);
		}
		return $events;
	}

	protected function _timezoneconvet($data,$tz){
		foreach ($data as &$r){
			if($r["start"]){
				$r["start"]=date("Y-m-d G:i:s",strtotime(($tz-8)." hours",strtotime($r["start"])));
			}
			if($r["end"])
				$r["end"]=date("Y-m-d G:i:s",strtotime(($tz-8)." hours",strtotime($r["end"])));
		}
			return $data;
	}

	function query(){
		if(isset($_GET["month"])){
			$getmonth=$_GET["month"];
		}
		else{
			$getmonth=date('Y-m',time());
		}
		$yearmonth = explode('-',$getmonth);
		$tzconvert=I("get.tz");
		if(isset($tzconvert)&&$tzconvert!=''){
			$events=json_encode($this->_timezoneconvet($this->_query($yearmonth),$tzconvert));
		}
		else{
			$events=json_encode($this->_query($yearmonth));
		}

		if(isset($_GET['callback'])){
			$callback=$_GET['callback'];  
		    echo $callback."($events)";
		}
		else
			echo $events;
	}
}