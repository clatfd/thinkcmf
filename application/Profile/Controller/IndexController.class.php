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
		if(I("get.vs")){
			$vs= I("get.vs");
			$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
			if(sizeof($vipsrc))
				$vipname=$vipsrc[0]['name'];
			else
				$vipname="";
			$_SESSION['vip']=$vipname;
		}
		elseif(isset($_SESSION["user"]))
			$vipname=$_SESSION["user"]["user_nicename"];
		elseif(isset($_SESSION["vip"]))
			$vipname=$_SESSION["vip"];
		else
			$vipname="";
	  	$this->display(":index");
	}

	function _getSensorData($num){
		$querydata= new \stdClass();
		$this->sensor_model=D("Sensor/Sensor");
		$this->mi_model =D("Sensor/Mifit");
		$querydata->lastweight=$this->sensor_model->where("sensorno=70")->order("id desc")->limit(1)->find();
		$querydata->bmi=number_format($querydata->lastweight['sensordata']/1.8/1.8, 1);
		$querydata->bmitag=$querydata->bmi<25?"Normal weight":"Over-weight";
		
		//mi sleep
		$querydata->midata=$this->mi_model->order("id desc")->limit($num)->field("date,summary")->select();
		$sumstp=0;
		$sumlt=0;
		$sumdp=0;
		$sumslp=0;
		$sumwak=0;
		for ($i=0;$i<sizeof($querydata->midata);$i++){
			$sm=json_decode($querydata->midata[$i]['summary']);
			$lti=number_format(($sm->slp->lt+$sm->slp->dp)/60,1);
			$dpi=number_format($sm->slp->dp/60,1);
			$stpi=$sm->stp->ttl;
			$slpi=$sm->slp->st;//current day sleep time in unix
			$waki=$sm->slp->ed;
			$timei=$querydata->midata[$i]['date'];

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
		$querydata->avgstp=number_format($sumstp/sizeof($querydata->midata),0);
		$querydata->avglt=number_format($sumlt/sizeof($querydata->midata),1);
		$querydata->avgdp=number_format($sumdp/sizeof($querydata->midata),1);
		$querydata->avgslp=number_format($sumslp/sizeof($querydata->midata),0,'','');
		$querydata->avgwak=number_format($sumwak/sizeof($querydata->midata),0,'','');
		return $querydata;
	}

	function content(){
		$querydata=$this->_getSensorData(7);
		$this->assign('weight',$querydata->lastweight);
		$this->assign('bmi',$querydata->bmi);
		$this->assign('bmitag',$querydata->bmitag);
		$this->assign('lt',$querydata->avglt);
		$this->assign('dp',$querydata->avgdp);
		$this->assign('step',$querydata->avgstp);
		$this->assign('sleeptime',date('H:i',$querydata->avgslp));
		$this->assign('waketime', date('H:i',$querydata->avgwak));
		// $this->assign('sleeptime',date('H:i', $slpi));
		// $this->assign('waketime',date('H:i', $waki));
		$this->assign('sleepdate','recent '.sizeof($querydata->midata).' days');

		$this->display(":content");
	}
	
	function getSensorDataForAdmin(){
		$queryweekdata=$this->_getSensorData(7);
		$queryyeardata=$this->_getSensorData(365);
		echo json_encode(array("weight"=>$queryweekdata->lastweight['sensordata'],"bmi"=>$queryweekdata->bmi,"Sleep length"=>$this->_formatRef($queryweekdata->avglt,$queryyeardata->avglt),"Deep Sleep Length"=>$this->_formatRef($queryweekdata->avgdp,$queryyeardata->avgdp),"step"=>$this->_formatRef(str_replace(',','',$queryweekdata->avgstp),str_replace(',','',$queryyeardata->avgstp)),"sleeptime"=>date('H:i',$queryweekdata->avgslp),"waketime"=>date('H:i',$queryweekdata->avgwak)));
	}
	function _formatRef($data,$avg){
		if($data>$avg)
			return $data."  (↑".($data-$avg).")";
		else
			return $data."  (↓".($avg-$data).")";
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
				$_SESSION['vip']=$vipname;
			}
			elseif(isset($_SESSION["user"]))
				$vipname=$_SESSION["user"]["user_nicename"];
			elseif(isset($_SESSION["vip"]))
				$vipname=$_SESSION["vip"];
			else
				$vipname="";
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'cv','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			//$send_result=sp_send_email('c.1994@163.com', $vipname.' read cv', '@'.date("Y-m-d H:i:s",time()));
			if ($result!==false) {
				$this->success("Welcome ".$vipname."!",U('portal/page/index',array('id'=>110)),1);
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			header("location:index.php?m=page&a=index&id=110");
			//$this->success("Welcome!",U('portal/page/index',array('id'=>110)),1);
			//$this->error("Register and login required",U('user/register/index'));
	}

	function resume(){
		if(I("get.vs")||isset($_SESSION['vip'])||isset($_SESSION["user"])){
			if(I("get.vs")){
				$vs= I("get.vs");
				$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
				if(sizeof($vipsrc))
					$vipname=$vipsrc[0]['name'];
				else
					$vipname="";
				$_SESSION['vip']=$vipname;
			}
			elseif(isset($_SESSION["user"]))
				$vipname=$_SESSION["user"]["user_nicename"];
			elseif(isset($_SESSION["vip"]))
				$vipname=$_SESSION["vip"];
			else
				$vipname="";
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'resume','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				header("location:index.php?m=page&a=index&id=74");
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			header("location:index.php?m=page&a=index&id=74");
			//$this->error("Register and login required",U('user/register/index'));
	}

	function archive(){
		if(I("get.vs")||isset($_SESSION['vip'])||isset($_SESSION["user"])){
			if(I("get.vs")){
				$vs= I("get.vs");
				$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
				if(sizeof($vipsrc))
					$vipname=$vipsrc[0]['name'];
				else
					$vipname="";
				$_SESSION['vip']=$vipname;
			}
			elseif(isset($_SESSION["user"]))
				$vipname=$_SESSION["user"]["user_nicename"];
			elseif(isset($_SESSION["vip"]))
				$vipname=$_SESSION["vip"];
			else
				$vipname="";
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'archive','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				header("location:index.php?m=page&a=index&id=75");
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			header("location:index.php?m=page&a=index&id=75");
			//$this->error("Register and login required",U('user/register/index'));
	}

	function trans(){
		if(I("get.vs")||isset($_SESSION['vip'])||isset($_SESSION["user"])){
			if(I("get.vs")){
				$vs= I("get.vs");
				$vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
				if(sizeof($vipsrc))
					$vipname=$vipsrc[0]['name'];
				else
					$vipname="";
				$_SESSION['vip']=$vipname;
			}
			elseif(isset($_SESSION["user"]))
				$vipname=$_SESSION["user"]["user_nicename"];
			elseif(isset($_SESSION["vip"]))
				$vipname=$_SESSION["vip"];
			else
				$vipname="";
			$insert_data=array('visitorname'=>$vipname,'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'transcription','ip'=>$_SERVER["REMOTE_ADDR"]);
			$result=$this->posts_model->add($insert_data);
			if ($result!==false) {
				header("location:index.php?m=page&a=index&id=113");
			}
			else {
				$this->error("添加访问数据失败！");
			}
		}
		else
			header("location:index.php?m=page&a=index&id=113");
			//$this->error("Register and login required",U('user/register/index'));
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
