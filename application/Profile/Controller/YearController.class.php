<?php
namespace Profile\Controller;
use Common\Controller\HomeBaseController;

class YearController extends HomeBaseController{
	protected $year;
	function _initialize() {
		parent::_initialize();
		$this->sensor_model =D("Sensor/sensor");
		$this->mi_model =D("Sensor/mifit");
		$this->movie_model =D("Movie/movie");
		$this->photo_model =D("Travel/photo");
		$this->pj_model =D("Profile/proj");
		if(I("get.year")){
			$this->year=intval(I("get.year"));
		}
	}

	public function indexyear(){
		if(I("get.year")){
			$this->assign("year",I("get.year"));
	  		$this->display(":indexyear");
		}
	}
	public function year(){
		if(I("get.year")){
			//weight
			$data["weight"]=$this->avg($this->sensor_model,70);
			$data["bmi"]=number_format($data["weight"]/1.8/1.8, 1);
			$data["bmitag"]=$bmi<25?"Normal weight":"Over-weight";
			//sensor
			$data["rundist"]=$this->total($this->sensor_model,2000)/1000;
			$data["gymcount"]=$this->count($this->sensor_model,95);
			$data["pushupcount"]=$this->total($this->sensor_model,75);
			//$pullupcount=$this->count(20);
			//mi_sensor
			$data["midata"]=$this->getmidata();
			//movie
			$data["moviecount"]=$this->getmoviecount();
			//pj
			$data["pjcount"]=$this->getpjcount();

			//special	
			switch ($this->year) {
				case 2015:
					$data["wordtransaction"]=10207;
					$data["sendemail"]=614;
					$data["recvemail"]=2574;
					$data["librarycount"]=388;
					$data["borrowbook"]=7;
					$data["readstory"]=array('count'=>2,'storyname'=>'The Shaw shank Redemption, 1984');
					$data["papercount"]=5;
					$data["GPA"]=3.84;
					$data["travelcount"]=4;
					break;
				
				default:
					break;
			}

			//photo
			$memphoto=$this->getmemphoto();
			$this->assign("year",$this->year);
			$this->assign("data",$data);
			$this->assign("memphoto",$memphoto);

	  		$this->display(":year".I("get.year"));
		}
	}
	protected function cal($sensorno){
		switch ($sensorno) {
			case 2000:
				echo $total($sensorno);
				break;
			case 95:
				echo $count($sensorno);
				break;
			case 70:
				echo $avg($sensorno);
				break;
			case 75:
				echo $total($sensorno);
				break;
			default:
				break;
		}
	}
	protected function total($modeltype,$sensorno){
		//$sensorno=I("get.sensorno");
		$condition["time"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		$condition["sensorno"]=$sensorno;
		$result=$modeltype->where($condition)->field('sensordata,time')->select();
		$totaldata=0;
		for($i=0;$i<sizeof($result);$i++){
			foreach ($result[$i] as $key => $value) {
				if($key=="sensordata"){
					$totaldata+=floatval($value);
				}
			}
		}
		return $totaldata;
	}

	protected function avg($modeltype,$sensorno){
		//$sensorno=I("get.sensorno");
		$condition["time"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		$condition["sensorno"]=$sensorno;
		$result=$modeltype->where($condition)->field('sensordata,time')->select();
		$totaldata=0;
		for($i=0;$i<sizeof($result);$i++){
			foreach ($result[$i] as $key => $value) {
				if($key=="sensordata"){
					$totaldata+=floatval($value);
				}
			}
		}
		return number_format($avgdata=$totaldata/sizeof($result),2);
	}

	protected function count($modeltype,$sensorno){
		//$sensorno=I("get.sensorno");
		$condition["time"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		$condition["sensorno"]=$sensorno;
		return $result=$modeltype->where($condition)->field('sensordata,time')->count();
	}

	protected function getmidata(){
		$condition["date"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		$midata_result=$this->mi_model->where($condition)->field("date,summary")->select();
		$sumstp=0;
		$sumlt=0;
		$sumdp=0;
		$sumslp=0;
		$sumwak=0;
		$skip=0;
		for ($i=0;$i<sizeof($midata_result);$i++){
			$sm=json_decode($midata_result[$i]['summary']);
			$lti=number_format(($sm->slp->lt+$sm->slp->dp)/60,1);
			$dpi=number_format($sm->slp->dp/60,1);
			$stpi=$sm->stp->ttl;
			$slpi=$sm->slp->st;//current day sleep time in unix
			$waki=$sm->slp->ed;
			if($slpi==$waki){
				$skip++;
				continue;
			}

			$timei=$midata_result[$i]['date'];

			$sumstp+=$stpi;
			$sumlt+=$lti;
			$sumdp+=$dpi;
			$slpi=$slpi%(3600*24);
			$waki=$waki%(3600*24);
			//unixtime start from 8:00 beijing time, add a day to time from 8:00-24:00
			if($waki<16*3600)
				$waki+=24*3600;
			//add a day to time from 8:00-18:00, starting from 18:00~
			if($slpi<10*3600)
				$slpi+=24*3600;
			$sumslp+=$slpi;
			$sumwak+=$waki;
			// echo date('H:i',$slpi).";";
		}
		$totalcount=sizeof($midata_result)-$skip;
		$midata['avgstp']=number_format($sumstp/$totalcount,0,'','');
		$midata['avglt']=number_format($sumlt/$totalcount,1);
		$midata['avgdp']=number_format($sumdp/$totalcount,1);
		$midata['avgslp']=date('H:i',number_format($sumslp/$totalcount,0,'',''));
		$midata['avgwak']=date('H:i',number_format($sumwak/$totalcount,0,'',''));
		return $midata;
	}
	protected function countmovie(){
		$condition["viewdate"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		return $this->movie_model->where($condition)->count();
	}
	protected function getmemphoto(){
		$condition["capturedt"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		$condition["fav"]=array('eq',1);
		return $this->photo_model->where($condition)->order("capturedt")->select();
	}
	protected function getpjcount(){
		$condition["enddate"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		return $this->pj_model->where($condition)->count();
	}
	protected function getmoviecount(){
		$condition["viewdate"]=array(array('egt',$this->year.'-01-01'),array('elt',$this->year.'-12-31'));
		return $this->movie_model->where($condition)->count();
	}
}