<?php
namespace Wordlist\Controller;
use Common\Controller\MemberbaseController;
// include('/H-wordlist/getip.php');

class MemberController extends MemberbaseController{
	function _initialize() {
		$_SESSION['login_http_referer']="index.php?g=wordlist&m=member&a=index";
		if(isset($_GET["username"])&&$_GET["username"]!="index.php")
			$_SESSION['username']=$_GET["username"];
		parent::_initialize();
		$this->wordsrc_obj = D("Wordlist/wdsrc");
		$this->wordusergro_obj = D("Wordlist/wdusergro");
		$this->worduserremark_obj = D("Wordlist/Wdremark");
		$this->userid = $_SESSION["user"]['id'];
	}

	function index(){
		$username=$_SESSION["user"]['user_nicename'];
		$step=100;
		$listsep=array();
		for($i=0;$i<100;$i++){
			$setsep=array();
			for($j=0;$j<6;$j++){
				if(($j+1)*$step+$i*6*$step>3100){
					array_push($setsep, array('',''));
				}
				else
					array_push($setsep, array(1+$j*$step+$i*6*$step,($j+1)*$step+$i*6*$step));
			}
			array_push($listsep, $setsep);
			if(($j+1)*$step+$i*6*$step>3100)
				break;
		}
		$this->assign("username",$username);
		$this->assign("listsep",$listsep);

  		$this->display(":index");
	}

	function _query(){
		$idlo=I("get.idlo")?I("get.idlo"):1;
		$idup=I("get.idup")?I("get.idup"):20;
		$gro=I("get.gro")?I("get.gro"):2;
		$rd=I("get.rd")?I("get.rd"):0;
		$list=I("get.list")?I("get.list"):'gre3000';
		
		$speciallist=array("imp","mfl","ivt");
		if(in_array($list, $speciallist)){
			$wdusergro_join = C('DB_PREFIX').'wdsrc as b on a.wordid =b.id';
			$wd_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array($list=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->select();
		}
		else{
			if($gro==2){
				$wd_src =M()->query("select * from sp_wdsrc where id not in (select wordid from sp_wdusergro where gro!=2 and userid=$this->userid) and id>= $idlo and id<=$idup");
				//var_dump($wd_src);
			}
			else{
		    	$wdusergro_join = C('DB_PREFIX').'wdsrc as b on a.wordid =b.id';
				$wd_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("gro"=>$gro,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->select();
				//var_dump($wd_src);
	    	}
		}
		//remark replace
		$remark_src =$this->worduserremark_obj->where(array("userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('wordid,userremark')->select();
		foreach ($remark_src as $value) {
			foreach ($wd_src as &$ivalue) {
				if($ivalue["id"]==$value["wordid"]){
					$ivalue["chi"]=$value["userremark"];
				}
			}
		}

		//var_dump($wd_src);
    	shuffle($wd_src);
    	if($rd)
    		$wd_src=array_slice($wd_src,0,$rd);

    	return $wd_src;
	}

	function query(){
		$username=$_SESSION["user"]['user_nicename'];
		
		$wd_src=$this->_query();

		$idlo=I("get.idlo")?I("get.idlo"):1;
		$idup=I("get.idup")?I("get.idup"):20;
		$gro=I("get.gro")?I("get.gro"):2;
		$rd=I("get.rd")?I("get.rd"):0;
		$list=I("get.list")?I("get.list"):'gre3000';

    	$wdusergro_join = C('DB_PREFIX').'wdsrc as b on a.wordid =b.id';
		$implist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("imp"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$implist = array_column($implist_src, 'eng');
		$mfllist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("mfl"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$mfllist = array_column($mfllist_src, 'eng');
		$ivtlist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("ivt"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$ivtlist = array_column($ivtlist_src, 'eng');
    	$impalllist= array_merge($implist,$mfllist,$ivtlist);
    	// var_dump($ivtlist);
		$this->assign("username",$username);
		$this->assign("wdlistarr",$wd_src);
		$this->assign("idlo",$idlo);
		$this->assign("idup",$idup);
		$this->assign("gro",$gro);
		$this->assign("list",$list);
		$this->assign("rd",$rd);
		$this->assign("totalnum",sizeof($wd_src));
		$this->assign("ipaddress","104.131.150.53");
		$this->assign("Remote_address",$_SERVER["REMOTE_ADDR"]);
		$this->assign("implist",$implist);
		$this->assign("mfllist",$mfllist);
		$this->assign("ivtlist",$ivtlist);
		$this->assign("impalllist",$impalllist);
  		$this->display(":frame");

	}

	function stat(){
		$idlo=I("get.idlo")?I("get.idlo"):1;
		$idup=I("get.idup")?I("get.idup"):20;
		$wdcount=array();
		$i1 =$this->wordusergro_obj->where(array("gro"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->count();
		$i3 =$this->wordusergro_obj->where(array("gro"=>3,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->count();
		$i4 =$this->wordusergro_obj->where(array("gro"=>4,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->count();
		$i5 =$this->wordusergro_obj->where(array("gro"=>5,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->count();
		$total=$idup-$idlo+1;
		$i2 =$total-$i1-$i3-$i4-$i5;

		$result=array();
		$out1=number_format($i1*100/$total,1);
		$out2=number_format($i2*100/$total,1);
		$out3=number_format($i3*100/$total,1);
		$out4=number_format($i4*100/$total,1);
		$out5=number_format($i5*100/$total,1);
		if($out1+$out2+$out3+$out4+$out5>100)
			$out1-=0.1;
		array_push($result,$out1."%");
		array_push($result,$out2."%");
		array_push($result,$out3."%");
		array_push($result,$out4."%");
		array_push($result,$out5."%");
		array_push($result,number_format($total,0,".",""));
		echo json_encode($result);
	}

	function move(){
		if(I("get.wdid")&&I("get.dir")){
			$wdid=I("get.wdid");
			$dir=I("get.dir");
			if($dir=="up"){
				$recordexist =$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->count();
				if($recordexist){
					$result=$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setInc('gro');
					$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField('modifydate',date("Y-m-d H:i:s"));
				}
				else{
					$addinfo=array("userid"=>$this->userid,"wordid"=>$wdid,"gro"=>3,'modifydate'=>date("Y-m-d H:i:s"));
					$result=$this->wordusergro_obj->add($addinfo);
				}
			}
			elseif($dir=="down"){
				$recordexist =$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->count();
				if($recordexist){
					$result=$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setDec('gro');
					$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField('modifydate',date("Y-m-d H:i:s"));
				}
				else{
					$addinfo=array("userid"=>$this->userid,"wordid"=>$wdid,"gro"=>1,'modifydate'=>date("Y-m-d H:i:s"));
					$result=$this->wordusergro_obj->add($addinfo);
				}
			}
			else
				$this->error("undefined behavior");
			if ($result!==false) {
				$this->ajaxReturn(sp_ajax_return(array("id"=>$wdid),"添加成功！",1));
			}
			else
				$this->error("Database error");

		}
		else{
			$this->error("Not complete");
		}
	}

	function modifyimp(){
		if(I("get.wdid")&&I("get.imptype")){
			$wdid=I("get.wdid");
			$imptype=I("get.imptype");
			$recordexist =$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->count();
			if($recordexist){
				$impstate=$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->field($imptype)->find();
				if($impstate[$imptype])
					$result=$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField($imptype,0);
				else
					$result=$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField($imptype,1);
				$this->wordusergro_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField('modifydate',date("Y-m-d H:i:s"));
			}
			else{
				$addinfo=array("userid"=>$this->userid,"wordid"=>$wdid,"gro"=>2,$imptype=>1,'modifydate'=>date("Y-m-d H:i:s"));
				$result=$this->wordusergro_obj->add($addinfo);
			}
			if ($result!==false) {
				$this->ajaxReturn(sp_ajax_return(array("id"=>$wdid,"exist"=>$recordexist,"origstate"=>$impstate[$imptype]),$imptype."更改成功！",1));
			}
			else
				$this->error("Database error");
		}
		else{
			$this->error("Not complete");
		}
	}

	function mobile(){
		$idlo=I("get.idlo")?I("get.idlo"):1;
		$idup=I("get.idup")?I("get.idup"):20;
		$gro=I("get.gro")?I("get.gro"):2;
		$list=I("get.list")?I("get.list"):'gre3000';
		$this->assign("idlo",$idlo);
		$this->assign("idup",$idup);
		$this->assign("gro",$gro);
		$this->assign("list",$list);
  		$this->display(":mobile");
	}
	function getexamlist(){
		$wd_src=$this->_query();
		$arr=array();
		foreach ($wd_src as $value) {
			$arrt = array(); 
			$id=$value['id'];
			$eng= $value['eng'];
			$rec=$value['rec'];
			$chi= $value['chi'];
			
			array_push($arrt,$id,$eng,$rec,$chi);
			
			array_push($arr,$arrt);
			//print_r($arr);
		}

		shuffle($arr);

		echo json_encode($arr);
	}

	function getimplist(){
		$idlo=I("get.idlo")?I("get.idlo"):1;
		$idup=I("get.idup")?I("get.idup"):20;
		$gro=I("get.gro")?I("get.gro"):2;
		$list=I("get.list")?I("get.list"):'gre3000';

		$arr=array();
    	$wdusergro_join = C('DB_PREFIX').'wdsrc as b on a.wordid =b.id';
		$implist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("imp"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$implist = array_column($implist_src, 'eng');
		$mfllist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("mfl"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$mfllist = array_column($mfllist_src, 'eng');
		$ivtlist_src =$this->wordusergro_obj->alias("a")->join($wdusergro_join)->where(array("ivt"=>1,"userid"=>$this->userid,'wordid'=>array(array('elt',$idup),array('egt',$idlo))))->field('eng')->select();
		$ivtlist = array_column($ivtlist_src, 'eng');
    	$impalllist= array_merge($implist,$mfllist,$ivtlist);
    	// var_dump($ivtlist);

    	array_push($arr,$impalllist);
		array_push($arr,$implist);
		array_push($arr,$mfllist);
		array_push($arr,$ivtlist);

		echo json_encode($arr);
    }

    function updateremark(){
			$recordexist=$this->worduserremark_obj->where(array('wordid'=>$_POST["wordid"],"userid"=>$this->userid))->find();
			if($recordexist){
				$existid=$recordexist["id"];
				$result=$this->worduserremark_obj->where(array('id'=>$existid))->setField(array('userremark'=>$_POST["userremark"],'modifydate'=>date("Y-m-d H:i:s")));
			}
			else{
				if($this->worduserremark_obj->create()){
					$result=$this->worduserremark_obj->add();
				}
				else
					$this->error($this->worduserremark_obj->getError());
			}
			if($result) {
				$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"update success！",1));
            }
            else{
                $this->error('error write!');
            }
    	//if(I("get.wdid")&&I("get.remark")){
			//$wdid=I("get.wdid");
			//$userremark=I("get.remark");
			// $recordexist=$worduserremark_obj->where(array('wordid'=>$_POST["wordid"],"userid"=>$this->userid))->find();
			// var_dump($worduserremark_obj);
			// if($recordexist){
			// 	$worduserremark_obj["id"]=$recordexist["id"];
			// 	$result=$worduserremark_obj->save();
			// 	// $result=$worduserremark_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->setField(array('userremark'=>$_POST["remark"],'modifydate'=>date("Y-m-d H:i:s")));
			// }
			// else{
			// 	// $addinfo=array("userid"=>$this->userid,"wordid"=>$wdid,"userremark"=>$userremark,'modifydate'=>date("Y-m-d H:i:s"));
			// 	if($worduserremark_obj->create()){
			// 		//var_dump($worduserremark_obj);
			// 		$result=$worduserremark_obj->add();
			// 		if($result) {
			// 			$this->ajaxReturn(sp_ajax_return(array("id"=>$result),"更改成功！",1));
		 //            }
		 //            else{
		 //                $this->error('写入错误！');
		 //            }
			// 	}
			// 	else{
			// 		var_dump($worduserremark_obj->getError());
		 //            //$this->error($worduserremark_obj->getError());
		 //        }
			// }
			
		//}
		//else{
		//	$this->error("Not complete");
		//}
    }

    function delremark(){
    	$result=$worduserremark_obj->where(array('wordid'=>$wdid,"userid"=>$this->userid))->delete(array('userremark'=>$userremark,'modifydate'=>date("Y-m-d H:i:s")));
    }
}