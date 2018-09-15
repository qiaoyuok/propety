<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class FeeController extends BaseController{
	
	/**
	 * 费用管理
	 * @param  string $username [用户姓名]
	 * @return [type]           [description]
	 */
	public function index($username=''){
		
		$where = "u.uid = r.uid and r.room_id = po.room_num";

		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}

		// 自定义分页连表查询
        $page = new \Think\Page(M("rent")
        	->table("pro_rent r,pro_pro po,pro_user u")
			->field("u.*, po.fee pofee,po.out_time poout_time,po.last_pay_time polast_pay_time,r.fee rfee,r.out_time rout_time,r.status rstatus,r.id,r.last_pay_time rlast_pay_time")
			->where($where)
			->count(),10);
        $feelists =  M("rent")
        	->table("pro_rent r,pro_pro po,pro_user u")
			->field("u.*, po.fee pofee,po.out_time poout_time,po.last_pay_time polast_pay_time,r.fee rfee,r.out_time rout_time,r.status rstatus,r.id,r.last_pay_time rlast_pay_time")
			->where($where)
			->limit($page->firstRow.','.$page->listRows)
			->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		foreach ($feelists as $k => $v) {
			$now = date("Y-m",time());

			
			$feelists[$k]['rfee_status'] = 1;
			if($now>substr($v['polast_pay_time'],0,7)){
				$feelists[$k]['pofee_status'] = 0;
			}else{
				$feelists[$k]['pofee_status'] = 1;
			}

			//不是房东
			if(!$v['rstatus']){

				// 房租费没交
				if($now>substr($v['rlast_pay_time'],0,7)){
					$feelists[$k]['rfee_status'] = 0;
				}
				continue;
			}
		}

		// var_dump($feelists);exit;

		$this->assign("meta_title","房租物业费用管理");
		$this->assign("feelists",$feelists);
		$this->display();
	}

	/**
	 * 用户缴费详情
	 * @param  string $id [租房表的ID号]
	 * @return [type]      [description]
	 */
	public function feeDetail($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$feedetail = M("user")
					->table("pro_rent r,pro_pro po,pro_user u,pro_room ro")
					->field("u.*, po.fee pofee,po.out_time poout_time,po.last_pay_time polast_pay_time,r.fee rfee,r.out_time rout_time,r.status rstatus,r.last_pay_time rlast_pay_time,ro.room")
					->where("r.id = $id and r.room_id = po.room_num and r.uid = u.uid and ro.id = room_id")
					->find();
		// var_dump($feedetail);
		// 统计缴费情况0000-00-00 00:00:00
		if ($feedetail['polast_pay_time'] == "0000-00-00 00:00:00") {
			$feedetail['pofeestatus'] = -1;
		}elseif (substr($feedetail['polast_pay_time'],0,7)<date("Y-m",time())) {
			$feedetail['pofeestatus'] = 0;
		}else{
			$feedetail['pofeestatus'] = 1;
		}

		if ($feedetail['rlast_pay_time'] == "0000-00-00 00:00:00") {
			$feedetail['rfeestatus'] = -1;
		}elseif (substr($feedetail['rlast_pay_time'],0,7)<date("Y-m",time())) {
			$feedetail['rfeestatus'] = 0;
		}else{
			$feedetail['rfeestatus'] = 1;
		}

		// var_dump($feedetail);exit;
		
		$this->assign("feedetail",$feedetail);
		$this->display();
	}

	/**
	 * 停车位费用管理
	 * @return [type] [description]
	 */
	public function park($username=''){
		
		$park = M("park");
		$where = "p.uid = u.uid";
		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}

		// 自定义分页连表查询
        $page = new \Think\Page($park->field("u.uid,u.tel,u.username,p.*")->table("pro_park p,pro_user u")->where($where)->count(),10);
        $parklists = $park->field("u.uid,u.tel,u.username,p.*")->table("pro_park p,pro_user u")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        foreach ($parklists as $k => $v) {

			if (substr($v['last_pay_time'],0,7)<date("Y-m",time())) {
				$parklists[$k]['feestatus'] = 0;
			}else{
				$parklists[$k]['feestatus'] = 1;
			}

	    }
		// var_dump($parklists);exit;
		$this->assign("meta_title","停车位费用管理");
		$this->assign("parklists",$parklists);
		$this->display();
	}

	/**
	 * 停车位费用详情
	 * @param  string $id [ID号]
	 * @return [type]     [description]
	 */
	public function parkDetail($id=''){

		!empty($id) or die($this->error("缺少参数"));

		$parkdetail = M("park")->table("pro_park p,pro_user u")->field("p.*,u.uid,u.username,u.tel")->where("p.uid = u.uid and p.id = $id")->find();

		if ($parkdetail['last_pay_time'] == "0000-00-00 00:00:00") {
			$parkdetail['feestatus'] = -1;
		}elseif (substr($parkdetail['last_pay_time'],0,7)<date("Y-m",time())) {
			$parkdetail['feestatus'] = 0;
		}else{
			$parkdetail['feestatus'] = 1;
		}

		// var_dump($parkdetail);exit;
		$this->assign("parkdetail",$parkdetail);
		$this->display();
		
	}

	/**
	 * 发送收费通知
	 * @param  string $title   [收费项目]
	 * @param  string $content [通知内容]
	 * @param  string $num     [房号/车位号]
	 * @param  string $uid     [接收人]
	 * @return [type]          [description]
	 */
	public function sendMsg($title='',$content='',$num='',$uid=''){
		
		!empty($title) or die($this->error("发送失败"));
		!empty($content) or die($this->error("发送失败"));
		!empty($num) or die($this->error("发送失败"));
		!empty($uid) or die($this->error("发送失败"));

		$msg = M("msg");

		$data = [
			'title'		=>$title,
			'content'	=>$content.$num,
			'uid' 		=>$uid,
			'create_time'=>date("Y-m-d H:i:s",time())
		];

		$data = $msg->create($data);

		if($msg->add($data)){
			die($this->success("发送成功"));
		}else{
			die($this->error("发送失败"));
		}
	}

	/**
	 * 通知管理
	 * @return [type] [description]
	 */
	public function msg($username=''){
		
		$where = "m.uid = u.uid";
		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}
		$msg = M("msg");
		// 自定义分页连表查询
        $page = new \Think\Page($msg->table("pro_msg m,pro_user u")->where($where)->count(),10);
        $msglists = $msg->table("pro_msg m,pro_user u")->where($where)->field("m.*,u.username,u.tel")->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        // var_dump($msglists);exit;
        $this->assign('_page', $p? $p: '');
        $this->assign('msglists', $msglists);
		$this->assign("meta_title","通知管理");
		$this->display();
	}

	/**
	 * 删除通知
	 * @param  string $id [通知ID号]
	 * @return [type]     [description]
	 */
	public function delmsg($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$msg = M("msg");

		if($msg->where("id in (".$id.")")->delete()){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}
}





?>