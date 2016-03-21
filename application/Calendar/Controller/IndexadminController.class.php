<?php
namespace Calendar\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Calendar/Calendar");
	}

	function index(){
	  $this->display();
	}

	function _query($yearmonth){
		$start = date('Y-m-d',mktime(0,0,0,$yearmonth[1],-7,$yearmonth[0]));
		$end = date('Y-m-d',mktime(0,0,0,$yearmonth[1]+1,7,$yearmonth[0]));
		$condition =array();
		$condition["start"]=array(array("egt",$start),array("elt",$end));
		$event_src = $this->posts_model->where($condition)->select();
		
		$events=array();
		foreach ($event_src as $r){
			$item=array('nid'=>$r["id"],'title'=>$r["title"],'start'=>$r["start"],'allDay'=>(bool)$r["allDay"],'evtype'=>$r["evtype"]);
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

	function query(){
		if(isset($_GET["month"])){
			$getmonth=$_GET["month"];
		}
		else{
			$getmonth=date('Y-m',time());
		}
		$yearmonth = explode('-',$getmonth);
		$events=json_encode($this->_query($yearmonth));

		if(isset($_GET['callback'])){
			$callback=$_GET['callback'];  
		    echo $callback."($events)";
		}
		else
			echo $events;
	}

	function add(){
		if(IS_POST){
			if(isset($_POST["id"])){
				$result=$this->posts_model->save($_POST);
				$id=$_POST["id"];
			}
			else{
				$_POST["mem"]="admin";
				if($_POST["rep"]!=""){
					$reparr=explode("+",$_POST["rep"]);
					unset($_POST["rep"]);
					$times=(int)$reparr[0];
					$period=(int)$reparr[1];
					$lastitem=$this->posts_model->order('id desc')->limit(1)->find();
					$id=$lastitem["id"]+1;
					$_POST["repid"]=$id;
					$result=$this->posts_model->add($_POST);
					for($i=0;$i<$times;$i++){
						$_POST["start"]=date("Y-m-d H:i",strtotime($_POST["start"])+$period*24*3600);
						$_POST["end"]=date("Y-m-d H:i",strtotime($_POST["end"])+$period*24*3600);
						$result=$this->posts_model->add($_POST);
					}
				}
				else{
					unset($_POST["rep"]);
					$result=$this->posts_model->add($_POST);
					$id=$result;
				}
				
			}
			if ($result!==false) {
				// $this->success("添加成功！");
				//echo json_encode(array('status' => 1));
				if($_POST["evtype"]=="Courses")
					$backgroundColor="rgb(55, 134, 26)";
				elseif($_POST["evtype"]=="Labs")
					$backgroundColor="rgb(39, 160, 201)";
				elseif($_POST["evtype"]=="Hobbies")
					$backgroundColor="rgb(255, 212, 70)";
				else{
					$backgroundColor="rgb(58, 135, 173)";
				}
				$this->ajaxReturn(sp_ajax_return(array("id"=>$id,"backgroundColor"=>$backgroundColor),"添加成功！",1));
			}
			else {
				$this->error("添加失败！");
			}
		}
		else{
			$this->error("添加失败！");
		}
	}

	function del(){
		$id=$_GET['id'];
		if(!$id)
			$this->error("No id");
		else{
			$result=$this->posts_model->delete($id);
			if ($result!==false) {
				// $this->success("删除成功！");
				//echo json_encode(array('status' => 1));
				$this->ajaxReturn(sp_ajax_return(array("id"=>$id),"删除成功！",1));
			}
			else {
				$this->error("database error");
			}
		}
	}

	// function insertgc(){
	// 	if(IS_POST){
	// 		$this->assign("summary",$_POST["title"]);	
	// 		$this->assign("description",$_POST["description"]);	
	// 		$this->assign("start",date(DATE_ATOM,strtotime($_POST["start"])));	
	// 		$this->assign("end",date(DATE_ATOM,strtotime($_POST["end"])));	
	// 		$this->assign("htmlLink",$_POST["url"]);
	// 		$this->display("googleinsert");
	// 	}
	// }
}