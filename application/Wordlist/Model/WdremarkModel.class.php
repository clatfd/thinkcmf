<?php
namespace Wordlist\Model;
use Common\Model\CommonModel;
class WdremarkModel extends CommonModel
{
	
	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('userremark', 'require', '名称不能为空！', 1, 'regex', 3),
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
		$data["userid"]=$_SESSION["user"]['id'];
		$data["modifydate"]=date("Y-m-d h:i:s");
	}
	
}




