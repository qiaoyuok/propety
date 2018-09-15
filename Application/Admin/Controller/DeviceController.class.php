<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class DeviceController extends BaseController{
	
	/**
	 * 
	 * 首页操作
	 * @return [type] [description]
	 */
	public function index($username=''){

		$device = M("device");
		// $devicelists = $device->table("pro_user u,pro_device d")->where("u.uid = d.uid")->select();
		$where = "u.uid = d.uid";
		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}
		// 自定义分页连表查询
        $page = new \Think\Page($device->table("pro_user u,pro_device d")->where($where)->count(),10);
        $devicelists = $device->table("pro_user u,pro_device d")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		$this->assign("meta_title","设备报修");
		$this->assign("devicelists",$devicelists);
		$this->display();
	}

	/**
	 * 确认已完成设备报修处理
	 * @param  string $id [设备报修的ID号]
	 * @return [type]        [description]
	 */
	public function dealed($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$device = M("device");

		$saveres = $device->where("id in (".$id.")")->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));
		if($saveres){
			die($this->success("确认处理成功"));
		}else{
			die($this->error("确认处理失败"));
		}
	}

	/**
	 * 改变已确认的设备报修状态
	 * @param  string $id [设备报修的ID号]
	 * @return [type]        [description]
	 */
	public function dealing($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$device = M("device");

		$saveres = $device->where("id in (".$id.")")->save(array("status"=>0,"update_time"=>date("Y-m-d H:i:s",time())));
		if($saveres){
			die($this->success("恢复处理成功"));
		}else{
			die($this->error("恢复处理失败"));
		}
	}

	/**
	 * 删除设备报修内容
	 * @param  string $id [设备报修的ID号]
	 * @return [type]        [description]
	 */
	public function delete($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$device = M("device");

		$delres = $device->where("id in (".$id.")")->delete();
		if($delres){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

}





?>