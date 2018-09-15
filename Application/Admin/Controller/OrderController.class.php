<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class OrderController extends BaseController{
	
	/**
	 * 订单管理
	 * @return [type] [description]
	 */
	public function index($username=''){
		
		$order = M("order");
		$where = "o.status = 1 and o.uid = u.uid";
		if(!empty($username)||$username==0){
			$where .= " and u.username like '%".$username."%'";
		}
		// 自定义分页连表查询
        $page = new \Think\Page($order->table("pro_order o,pro_user u")->where($where)->count(),10);
        $orderlist = $order->table("pro_order o,pro_user u")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        

		foreach ($orderlist as $k => $v) {
			// {"flag":2,"name":"物业费用","num":28}
			$detail = json_decode($v['detail'],true);
			switch ($detail['flag']) {
				case 1:
					$orderlist[$k]['num'] = "房间号：".$this->getHousenum($detail['num']);
					break;
				case 2:
					$orderlist[$k]['num'] =  "房间号：".$this->getHousenum($detail['num']);
					break;
				case 3:
					$orderlist[$k]['num'] =  "车位号：".$this->getParknum($detail['num']);
				break;
			}
			$orderlist[$k]['name'] = $detail['name'];
		}

		$this->assign('_page', $p? $p: '');
		$this->assign("orderlist",$orderlist);
		$this->assign("meta_title","订单管理");
		$this->display();
	}

	/**
	 * 获取房间号
	 * @param  string $num [房间序号]
	 * @return [type]        [description]
	 */
	public function getHousenum($num=''){
		
		$room = M("room");
		return $room->where("id = ".$num)->find()['room'];
	}

	/**
	 * 获取车位号
	 * @param  string $num [车位序号]
	 * @return [type]        [description]
	 */
	public function getParknum($num=''){
		
		$park = M("park");
		return $park->where("id = ".$num)->find()['num'];
	}
}





?>