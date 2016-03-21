<?php
namespace Movie\Controller;
use Common\Controller\HomeBaseController;

class IndexController extends HomeBaseController{
	function _initialize() {
		parent::_initialize();
		$this->posts_model =D("Movie/movie");
	}

	function index(){
	  $this->display(":index");
	}

	function content(){
		$sort_method=I("get.sort");
		if(empty($sort_method)){
			$sort_method="viewdate";
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
		$movielist=$this->posts_model
		->limit($page->firstRow . ',' . $page->listRows)
		->field('id,imdbid,dbid,myrating,moviename,avgrating,director,year,viewdate,poster')
		->order($sort_method." ".$asc)
		->select();
		$this->assign("sort", $sort_method);
		$this->assign("sortorder", $asc);
		$this->assign("Page", $page->show('Admin'));
		$this->assign("movielist",$movielist);
	  	$this->display(':movielist');
	}
	function imdbquery(){
		$id=I("get.id");
		$imdburl="http://www.omdbapi.com/?i=tt".$id."&plot=short&r=json";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $imdburl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = get_object_vars(json_decode(curl_exec($curl)));
		$info["moviename"]=$result['Title'];
		$info["year"]=$result['Year'];
		$info["genre"]=$result['Genre'];
		$info["director"]=$result['Director'];
		$info["summary"]=$result['Plot'];
		$info["country"]=$result['Country'];
		$info["avgrating"]=$result['imdbRating'];
		//&&$result["Poster"]!="N/A"
		if($result["Poster"]){
			$this->_saveposter($result["Poster"],$id);
			$info["poster"]="/thinkcmfx/data/movie/".$id.".jpg";
		}
		$this->ajaxReturn(sp_ajax_return(array("info"=>$info),"query success",1));
	}
	function db(){
		$url="http://api.douban.com/v2/movie/subject/1764796";
		//echo $url;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		$output = curl_exec($ch);
		$data=get_object_vars(json_decode($output));
		$data1=$data['images'];
		var_dump($data1->small);
	}
	
	function dbquery(){
		$id=I("get.id");
		$dburl="http://api.douban.com/v2/movie/subject/".$id;
		$result=$this->http("GET", $dburl, $params);
		$info["poster"]=$result['images']["small"];
		
		// $info["avgrating"]=$result['rating']["average"];
		// $info["moviename"]=$result['title'];
		// $info["year"]=$result['year'];
		// $info["genre"]=implode(",", $result['genres']);
		// $info["country"]=$result['countries'][0];
		// $info["summary"]=$result['summary'];
		// $info["director"]=$result['directors'][0]["name"];
		// $info["movieid"]=$id;

		
		$this->ajaxReturn(sp_ajax_return(array("info"=>$info),"query success",1));

	}
	function getHeader() {
      if (is_null($this->access_token)) {
        return 'Content_type: application/x-www-form-urlencoded';
      }

      return 'Authorization: Bearer ' . $this->access_token;
    }
	function http($method, $url, $params = array()) {
      $ch = curl_init();

      $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => TRUE,

        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HEADER => FALSE,
        CURLOPT_SSL_VERIFYPEER => FALSE,

        CURLOPT_USERAGENT => $this->user_agent,
      );

      $headers = array();
      $headers[] = $this->getHeader();
      $headers[] = 'Expect:';

      $options[CURLOPT_HTTPHEADER] = $headers;

      curl_setopt_array($ch, $options);

      $result = curl_exec($ch);
      $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      return json_decode($result, TRUE);
    }

    protected function _saveposter($url,$id){
    	// $url="http://ia.media-imdb.com/images/M/MV5BOTAzODEzNDAzMl5BMl5BanBnXkFtZTgwMDU1MTgzNzE@._V1_SX300.jpg";
    	// $id="2488496";
    	// echo "wget ".$url." -O /usr/share/nginx/html/thinkcmfx/data/movie/".$id.".jpg";
    	exec("wget ".$url." -O /usr/share/nginx/html/thinkcmfx/data/movie/".$id.".jpg"); 
    }
}