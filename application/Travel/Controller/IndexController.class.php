<?php
namespace Travel\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	protected $year;
	function _initialize() {
		parent::_initialize();
		$this->photo_model =D("Travel/photo");
		if(I("get.year")){
			$this->year=intval(I("get.year"));
		}
	}

	function photo(){
		if(I("get.year")){
			$this->assign("year",I("get.year"));
	  		$this->display(":photoindex");
	  	}
	}

	function photocontent(){
		if(I("get.year")){
			$condition["capturedt"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
			$photosrc=$this->photo_model->where($condition)->order("fav DESC,capturedt")->select();
			$this->assign("photosrc",$photosrc);
			$this->assign("year",I("get.year"));
			$this->display(":photocontent");
		}
	}
	
	function photomap(){
		if(I("get.type")){
			$maptype=I("get.type");
		}
		else{
			$maptype="Google";
		}
		$this->assign("map",$maptype);
	  	$this->display(":photomap");
	}
	function baidumap(){
	  	$this->display(":baidumap");
	}
	function googlemap(){
	  	$this->display(":googlemap");
	}
	

	public function query(){
		$condition['lat']=array('neq','');
		$photoresult=$this->photo_model->where($condition)->field('lat,lon,title,comment,photoname,capturedt')->select();
		$photoinfo=array();
		foreach ($photoresult as $value) {
			$item=array();
			array_push($item, $value["lon"],$value["lat"],$value["title"],$value["comment"],$value["photoname"],$value["capturedt"]);
			array_push($photoinfo, $item);
		}
		echo json_encode($photoinfo);
	}
}