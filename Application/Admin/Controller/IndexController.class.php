<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class IndexController extends BaseController{
	
	/**
	 * 首页操作
	 * @return [type] [description]
	 */
	public function index(){
		
		$this->assign("meta_title","后台首页");
		$this->display();
	}
}





?>