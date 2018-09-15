<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class ComplaintController extends BaseController{
	
	/**
	 * 首页操作
	 * @return [type] [description]
	 */
	public function index($username=''){

		$complaint = M("complaint");
		$where = "u.uid = c.uid";
		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}
		// 自定义分页连表查询
        $page = new \Think\Page($complaint->table("pro_user u,pro_complaint c")->where($where)->count(),10);
        $complaintlists = $complaint->table("pro_user u,pro_complaint c")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
		$this->assign("meta_title","用户投诉");
		$this->assign("complaintlists",$complaintlists);
		$this->display();
	}

	/**
	 * 确认已完成投诉处理
	 * @param  string $id [投诉的ID号]
	 * @return [type]        [description]
	 */
	public function dealed($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$complaint = M("complaint");

		$saveres = $complaint->where("id in (".$id.")")->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));
		if($saveres){
			die($this->success("确认处理成功"));
		}else{
			die($this->error("确认处理失败"));
		}
	}

	/**
	 * 改变已确认的投诉状态
	 * @param  string $id [投诉的ID号]
	 * @return [type]        [description]
	 */
	public function dealing($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$complaint = M("complaint");

		$saveres = $complaint->where("id in (".$id.")")->save(array("status"=>0,"update_time"=>date("Y-m-d H:i:s",time())));
		if($saveres){
			die($this->success("恢复处理成功"));
		}else{
			die($this->error("恢复处理失败"));
		}
	}

	/**
	 * 删除投诉内容
	 * @param  string $id [投诉的ID号]
	 * @return [type]        [description]
	 */
	public function delete($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$complaint = M("complaint");

		$delres = $complaint->where("id in (".$id.")")->delete();
		if($delres){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

}





?>