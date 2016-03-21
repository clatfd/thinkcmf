<?php
namespace Travel\Controller;
use Common\Controller\AdminbaseController;

class IndexadminController extends AdminbaseController{
	protected $rawphotodir="tpl/simplebootx/Public/images/raw/";
	protected $photodir="tpl/simplebootx/Public/images/photo/";

	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Travel/photo");
	}

	function index(){
		$sort_method=I("get.sort");
		if(empty($sort_method)){
			$sort_method="capturedt";
		}
		$desc=I("get.sortorder");
		if(empty($desc)){
			$asc="DESC";
		}
		else{
			$asc="";
		}
		$count=$this->posts_model->count();
		$page = $this->page($count, 20);
		$photolist=$this->posts_model
		->limit($page->firstRow . ',' . $page->listRows)
		->order($sort_method." ".$asc)
		->select();
		$this->assign("sort", $sort_method);
		$this->assign("sortorder", $asc);
		$this->assign("Page", $page->show('Admin'));
		$this->assign("photolist",$photolist);
		$formitem=["photoname","title","cam","lat","lon","alt","capturedt","focal","iso","shutter","comment"];
		$this->assign("formitem",$formitem);
		$dirfiles=scandir($this->rawphotodir);
		$rawfiles=array_slice($dirfiles,2);
		$this->assign("rawfiles",$rawfiles);

		$this->display(":photoadd");
	}

	function query(){
		$filename=I("get.filename");
		if(!empty($filename)){
			$info=$this->readexif($filename);
			$photoyear=substr($info->capturedt,0,4);
			$info->photoname=$photoyear.'-'.$this->findnextpic($photoyear).'.jpg';
			$this->ajaxReturn(sp_ajax_return(array("info"=>$info),"query success",1));	
		}
		else{
			$this->ajaxReturn(sp_ajax_return(array("info"=>''),"no file",1));	
		}
	}

	protected function readexif($filename){
		
		$exif = exif_read_data($this->rawphotodir.$filename);
		// var_dump($exif);
		// $info=&$this->posts_model;
		$info->originalname=$exif['FileName'];
		$info->capturedt=date("Y-m-d H:i:s",$exif['FileDateTime']);
		$info->cam=$exif['Make'].' '.$exif['Model'];
		$info->iso=$exif['ISOSpeedRatings'];
		$str=$exif['ShutterSpeedValue'];
		$info->shutter=eval("return $str;");
		$str=$exif['FocalLength'];
		$info->focal=eval("return $str;");

		if($exif['GPSLatitudeRef']){
			$GPSLatitude=array();
			for ($i=0; $i < 3; $i++) { 
				$str=$exif['GPSLatitude'][$i];
				$GPSLatitude[$i]=eval("return $str;");
			}
			$GPSLatitude=number_format($GPSLatitude[0]+$GPSLatitude[1]/60+$GPSLatitude[2]/3600,6);
			$GPSLatitudeRef=$exif['GPSLatitudeRef'];
			if($GPSLatitudeRef=='S'){
				$GPSLatitude=-$GPSLatitude;
			}
			$info->lat=$GPSLatitude;

			$GPSLongitude=array();
			for ($i=0; $i < 3; $i++) { 
				$str=$exif['GPSLongitude'][$i];
				$GPSLongitude[$i]=eval("return $str;");
			}
			$GPSLongitude=number_format($GPSLongitude[0]+$GPSLongitude[1]/60+$GPSLongitude[2]/3600,6);
			$GPSLatitudeRef=$exif['GPSLatitudeRef'];
			if($GPSLatitudeRef=='W'){
				$GPSLongitude=-$GPSLongitude;
			}
			$info->lon=$GPSLongitude;

			$str=$exif['GPSAltitude'];
			$GPSAltitude=eval("return $str;");
			$info->alt=$GPSAltitude;
		}
		else{
			$info->lat='';
			$info->lon='';
			$info->alt='';

		}
		return $info;
	}

	function viewexif(){
		$filename=I("get.filename");
		$exif = exif_read_data($this->rawphotodir.$filename);
		var_dump($exif);
	}

	function writeexif(){
		if(IS_POST){
			if ($this->posts_model->create()) {
				if($lastInsId = $this->posts_model->add($_POST)){
					
					$im=imagecreatefromjpeg($this->rawphotodir.$_POST["originalname"]);
					$maxwidth="600";
					// $maxheight="400";
					$name=$this->photodir.substr($_POST["photoname"],0,strlen($_POST["photoname"])-4);
					$filetype=".jpg";
					$this->resizeImage($im,$maxwidth,$name,$filetype);
				    $this->success('inserted');
				}
				else{
				    $this->error('insert error');
				}
			}
		}
	}
	 function findnextpic($photoyear){
		$condition["capturedt"]=array(array('egt',$photoyear.'-01-01'),array('elt',$photoyear.'-12-31'));
		$nextphoto=$this->posts_model->where($condition)->field('photoname')->limit(1)->order("id desc")->find();
		if($nextphoto){
			$photoint=(int)substr($nextphoto['photoname'],strlen($nextphoto['photoname'])-7,3);
			$nextphotoid=sprintf("%03d", $photoint+1);
			return $nextphotoid;
		}
		else{
			return '000';
		}
		
	}

	function del(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->posts_model->where("id=$id")->delete()!==false) {
				$this->success("删除成功！");
				// $this->ajaxReturn(sp_ajax_return(array("id"=>$id),"删除成功！",1));
			} else {
				$this->error("删除失败！");
			}
		}
	}

//todo
	function resizeImage($im,$maxwidth,$name,$filetype){
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
	 
		if(($maxwidth && $pic_width > $maxwidth)){
			$ratio = $maxwidth/$pic_width;
			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;

			if(function_exists("imagecopyresampled")){
				$newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
				imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
			}
			else{
				$newim = imagecreate($newwidth,$newheight);
				imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
			}

			$name = $name.$filetype;
			imagejpeg($newim,$name);
			imagedestroy($newim);
		}
		else{
			$name = $name.$filetype;
			imagejpeg($im,$name);
		}
	}
}