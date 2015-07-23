<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomeBaseController;
/**
 * 文章列表
*/
class ListController extends HomeBaseController {

	//文章内页
	public function index() {
		if(I("get.vs")){
            $vs= I("get.vs");
            $this->viplist_model =D("Profile/viplist");
            $vipsrc = $this->viplist_model->where(array("vs"=>$vs))->select();
            if(sizeof($vipsrc))
                $vipname=$vipsrc[0]['name'];
            elseif(isset($_SESSION["user"]))
                $vipname=$_SESSION["user"];
            else
                $vipname="";
            $_SESSION['vip']=$vipname;
        }
		$term=sp_get_term($_GET['id']);
		$tplname=$term["list_tpl"];
    	$tplname=sp_get_apphome_tpl($tplname, "list");
    	$this->assign($term);
    	$this->assign('cat_id', intval($_GET['id']));

    	if(isset($_SESSION['vip'])){
            $this->posts_model =D("Profile/visitorrecord");
            $insert_data=array('visitorname'=>$_SESSION['vip'],'visittime'=>date("Y-m-d H:i:s",time()),'type'=>'List:'.$term['name'],'ip'=>$_SERVER["REMOTE_ADDR"]);
            $result=$this->posts_model->add($insert_data);
        }

    	$this->display(":$tplname");
	}
	
	public function nav_index(){
		$navcatname="文章分类";
		$datas=sp_get_terms("field:term_id,name");
		$navrule=array(
				"action"=>"List/index",
				"param"=>array(
						"id"=>"term_id"
				),
				"label"=>"name");
		exit(sp_get_nav4admin($navcatname,$datas,$navrule));
		
	}
	
}
