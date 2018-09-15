<?php
namespace Admin\Controller;

/**
* 后台首页类文件
*/
class SystemController extends BaseController{
	
	/**
	 * 系统控制器首页
	 * @param  string $parent_id [父及菜单ID号]
	 * @return [type]            [description]
	 */
	public function index($parent_id=''){
		
		$parent_id = empty($parent_id)?0:$parent_id;

		$where = "parent_id = ".$parent_id;
		// 获取菜单列表
		$menu = M("menu");
		// 自定义分页连表查询
        $page = new \Think\Page($menu->where($where)->order("sort desc")->count(),10);
        $menulists = $menu->where($where)->order("sort desc")->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        

		foreach ($menulists as $k => $v) {

			if(empty($v['group'])){
				$menulists[$k]['group'] = "暂无分组";
			}

			if($v['hide'] == 0){
				$menulists[$k]['hide_text'] = "显示";
			}else{
				$menulists[$k]['hide_text'] = "隐藏";
			}

			if($v['parent_id'] == $parent_id && $parent_id != 0){
				$menulists[$k]['parent_text'] = $v['title'];
			}else{
				$menulists[$k]['parent_text'] = "暂无上级菜单";
			}
		}
		
		// var_dump($menulists);
		$this->assign('_page', $p? $p: '');
		$this->assign("meta_title","系统设置");
		$this->assign("menulists",$menulists);
		$this->display();
	}

	/**
	 * 添加菜单
	 * @param string $title     [菜单名]
	 * @param string $sort      [排序序号]
	 * @param string $url       [菜单地址]
	 * @param string $group     [菜单所在分组]
	 * @param string $parent_id [父级ID号]
	 * @param string $hide      [是否隐藏]
	 */
	public function add($title='',$sort='',$url='',$group='',$parent_id='',$hide=''){
		
		$menu = M("menu");
		if(IS_POST){
			
			if(empty($title)){
				$this->error("菜单名称不能为空");
				return ;
			}

			if(empty($url)){
				$this->error("菜单地址不能为空");
				return ;
			}

			// 对url做校验
			$urlarr = explode("/",$url);

			if(count($urlarr)<=1){
				$this->error("请检查菜单地址格式是否正确");
				return ;
			}

			$data = $menu->create($_POST);

			$addres = $menu->add($data);

			if($addres){
				$this->success("添加成功");
			}else{
				$this->error("添加失败");
			}

			return ;
		}


		$parent_menus = $menu->where("parent_id = 0")->select();
		$this->assign("parent_menus",$parent_menus);
		$this->display();
	}

	/**
	 * 删除菜单
	 * @param  string $id [菜单ID号]
	 * @return [type]     [description]
	 */
	public function del($id=''){

		if(empty($id)){
			$this->error("缺少参数");
			return;
		}

		$menu = M("menu");
		$delres = $menu->where("id in (".$id.")")->delete();
		if($delres){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
		exit;
	}

	/**
	 * 修改菜单
	 * @param string $title     [菜单名]
	 * @param string $sort      [排序序号]
	 * @param string $url       [菜单地址]
	 * @param string $group     [菜单所在分组]
	 * @param string $parent_id [父级ID号]
	 * @param string $hide      [是否隐藏]
	 * @param  string $id        [description]
	 * @return [type]            [description]
	 */
	public function edit($title='',$sort='',$url='',$group='',$parent_id='',$hide='',$id=''){
		
		if(empty($id)){
			$this->error("缺少参数");
			return ;
		}

		$menu = M("menu");

		if(IS_POST){

			if(empty($title)){
				$this->error("菜单名称不能为空");
				return ;
			}

			if(empty($url)){
				$this->error("菜单地址不能为空");
				return ;
			}

			// 对url做校验
			$urlarr = explode("/",$url);

			if(count($urlarr)<=1){
				$this->error("请检查菜单地址格式是否正确");
				return ;
			}
			unset($_POST['id']);
			$_POST['hide'] = empty($_POST['hide'])?0:1;
			$data = $menu->create($_POST);
			$saveres = $menu->where("id = ".$id)->save($data);
			if($saveres){
				$this->success("编辑成功");
			}else{
				$this->error("编辑失败");
			}

			return ;

		}

		$menulists = $menu->where("hide = 0 and parent_id = 0 and id != ".$id)->order("sort desc")->select();
		$menuinfo = $menu->where("id = ".$id)->find();

		if(!$menuinfo){
			$this->error("改菜单不存在，请刷新重试");
		}

		// var_dump($menulists);
		$this->assign("menulists",$menulists);
		$this->assign("menuinfo",$menuinfo);
		$this->display();
	}

	/**
	 * 公司设定
	 * @param string $company_name [公司名称]
	 * @param string $company_email [公司邮箱]
	 * @param string $company_tel [公司电话]
	 */
	public function set($company_name='',$company_email='',$company_tel=''){
		
		$company = M("company");
		if(IS_POST){
			!empty($company_name) or die($this->error("公司名称不能为空"));
			
			if(!empty($company_email)){

				$checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式  
				if(!preg_match($checkmail,$company_email)){
					die($this->error("邮箱格式不正确"));
				}
			}

			if(!empty($company_tel)){

				$checktel="/^1[345678]{1}\d{9}$/";//定义正则表达式  
				if(!preg_match($checktel,$company_tel)){
					die($this->error("手机号格式不正确"));
				}
			}

			$data = $company->create($_POST);
			$companyinfo = $company->select();
			if($companyinfo){
				$id = $companyinfo[0]['id'];
				$saveres = $company->where("id = ".$id)->save($data);
				if ($saveres) {
					$_SESSION['companyinfo'] = $data;
					die($this->success("编辑成功"));
				}else{
					die($this->error("编辑失败"));
				}

			}else{
				$addres = $company->add($data);
				if ($addres) {
					$_SESSION['companyinfo'] = $data;
					die($this->success("编辑成功"));
				}else{
					die($this->error("编辑失败"));
				}
			}
			return ;
		}
		$companyinfo = $company->select()[0];
		// var_dump($companyinfo);exit;
		$this->assign("meta_title","物业设置");
		$this->assign("companyinfo",$companyinfo);
		$this->display();
	}

	/**
	 * 房屋管理
	 * @param  string $flag      [标志位]
	 * @param  string $parent_id [父级ID号]
	 * @return [type]            [description]
	 */
	public function house($flag='',$parent_id='',$village_id=''){
		
		$room = M("room");
		
		if(empty($flag)){
			$flag = 1;
		}

		switch ((int)$flag) {
			case 1:
				$where = "r.parent_id = 0 and v.id = r.village_id";
				break;
			case 2:

				$where = "r.parent_id = ".$parent_id." and v.id = r.village_id";
				// 获取幢
				$build = $room->where("id = ".$parent_id)->find()['room'];
				// var_dump($build);exit;
				$this->assign("build",$build);
				break;
			case 3:
				$where = "r.parent_id = ".$parent_id." and v.id = r.village_id";
				// 获取单元
				$unit = $room->where("id = ".$parent_id)->find();
				$this->assign("unit",$unit['room']);
				// 获取幢
				$build = $room->where("id = ".$unit['parent_id'])->find()['room'];
				$this->assign("build",$build);
				break;
			default:
				$where = "r.parent_id = 0";
				break;
		}

		if(!empty($village_id)){
			$where .= " and r.village_id = ".$village_id;
		}

		// 自定义分页连表查询
        $page = new \Think\Page($room->field("r.*,v.name")->table("pro_room r,pro_village v")->where($where)->count(),10);
        $roomlists = $room->field("r.*,v.name")->table("pro_room r,pro_village v")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		$temp_roomslists = $this->count($roomlists,$flag,$village_id);

		foreach ($roomlists as $k => $v) {
			$roomlists[$k]['allcount'] = 0;
			$roomlists[$k]['used'] = 0;
			foreach ($temp_roomslists as $k1 => $v1) {
				if($v1['build'] == $v['id']||$v1['parent_id'] == $v['id']){
					$roomlists[$k]['allcount'] ++;
					if($v1['uid'] != 0){
						$roomlists[$k]['used'] ++;
					}
				}
			}
		}

		// 获取所有小区
		$village = M("village");
		$villagelists = $village->select();
		$this->assign("village_id",$village_id);
		$this->assign("villagelists",$villagelists);
		$this->assign("roomlists",$roomlists);
		$this->assign("meta_title","房屋管理");
		$this->assign("flag",$flag);
		$this->display();
	}

	/**
	 * 统计房间数
	 * @param  string $roomlists [该页面展示的房屋列表]
	 * @param  string $flag 	 [统计模式]
	 * @param  string $flag 	 [小区ID号]
	 * @return [type]            [description]
	 */
	public function count($roomlists='',$flag='',$village_id=''){
		
		if(empty($roomlists)){
			return false;
		}
		if(!empty($village_id)){
			$where = " and village_id = $village_id";
		}
		$roomobj = M("room");

		if($flag == 1){
			// 先查询所有的单元，在查询每个单元下的房间
			// 先获取传递过来的幢的ID号
			foreach ($roomlists as $k => $v) {
				$id[] = $v['id'];
			}
			$ids = implode($id,",");
			$temp_roomslists = $roomobj->table("pro_room r")
									->field("r.*,tmp.parent_id build")
									->join("right join (select * from pro_room where parent_id in ($ids)  $where) as tmp on r.parent_id = tmp.id")
									->select();
		}elseif ($flag == 2) {
			// 先获取传递过来的单元的ID号
			foreach ($roomlists as $k => $v) {
				$id[] = $v['id'];
			}
			$ids = implode($id,",");
			$temp_roomslists = $roomobj->where("parent_id in ($ids) $where")->select();
		}
		foreach ($temp_roomslists as $k => $v) {
			if(!$v['id']){
				unset($temp_roomslists[$k]);
			}
		}
		return $temp_roomslists;
	}


	/**
	 * 添加房屋（包括，幢，单元，室）
	 * @param string $parent_id [父级ID号]
	 * @param string $room      [房间、幢、单元号]
	 * @param string $flag      [房间、幢、单元的标志 1幢，2单元，3房间]
	 * @param string $village_id      [小区ID号]
	 */
	public function addRoom($parent_id='',$room='',$flag='',$village_id=''){
		
		$roomobj = M('room');

		if(IS_POST){

			!empty($room) or die($this->error("必填项不能为空"));
			!empty($flag) or die($this->error("缺少参数"));
			!empty($village_id) or die($this->error("请先选择所属小区"));
			$parent_id != '' or die($this->error("必填项不能为空"));

			switch ((int)$flag) {
				case 1:
					if($roomobj->where("room = ".$room." and parent_id = 0 and village_id = ".$village_id)->select())
						die($this->error("该小区该幢楼号已存在"));
					break;
				case 2:
					$parent_id != 0 or die($this->error("请先选择幢"));
					if($roomobj->where("room = ".$room." and parent_id = ".$parent_id." and village_id = ".$village_id)->select())
						die($this->error("该幢楼已存在该单元"));
					break;
				case 3:
					$parent_id != 0 or die($this->error("请先选择单元"));
					if($roomobj->where("room = ".$room." and parent_id = ".$parent_id." and village_id = ".$village_id)->select())
						die($this->error("该单元已存在该房间号"));
					break;
			}

			$data = $roomobj->create($_POST);

			$addres = $roomobj->add($data);
			if($addres){
				die($this->success("添加成功"));
			}else{
				die($this->error("添加失败"));
			}
		}

		$roomlists = $roomobj->select();
		$village = M("village");
		$villagelists = $village->select();
		$this->assign("roomlists",$roomlists);
		$this->assign("villagelists",$villagelists);
		$this->display();
	}

	/**
	 * 删除房间/单元/幢
	 * @param  string $id [对应的ID号]
	 * @return [type]     [description]
	 */
	public function delRoom($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$room = M("room");
		$delres = $room->where("id in ($id)")->delete();
		M("rent")->where("room_id in ($id)")->delete();

		if($delres){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

	/**
	 * 编辑房屋
	 * @param  string $id 			[房屋ID号]
	 * @param  string $uid 			[用户ID号]
	 * @param  string $attribute 	[房间属性]
	 * @param  string $fee 			[费用]
	 * @param  string $profee 			[物业费]
	 * @return [type]     [description]
	 */
	public function editRoom($id='',$uid='',$attribute='',$fee='',$profee=''){

		!empty($id) or die($this->error("缺少参数1"));

		$room = M("room");

		if(IS_POST){
			!empty($uid) or die($this->error("请先选择户主"));
			!empty($profee) or die($this->error("请填写物业费"));
			!empty($attribute)||$attribute == 0 or die($this->error("缺少参数2"));

			switch ((int)$attribute) {
				case 0:
					!empty($fee) or die($this->error("缺少参数3"));
					$_POST['status'] = 0;
					$_POST['room_id'] = $id;
					break;
				case 1:
					unset($_POST['fee']);
					$_POST['status'] = 1;
					$_POST['room_id'] = $id;
					break;
				default:
					die($this->error("缺少参数"));
					break;
			}

			// 物业费
			$pro = M("pro");
			$paoinfo = $pro->where("room_num = ".$id)->find();
			if ($paoinfo) {
				$pro->where("id = ".$paoinfo['id'])->save(array("uid"=>$uid,"fee"=>$profee));
			}else{
				$pro->add(array("uid"=>$uid,"room_num"=>$id,"fee"=>$profee));
			}

			$data = $room->create($_POST);
			// 对房间进行修改
			$saveroom = $room->where("id = ".$id)->save($data);

			$rent = M("rent");
			$data = $rent->create($_POST);
			unset($data['id']);
			// var_dump($data);
			// 对个人房间信息进行修改
			$rent = M("rent");
			if($rent->where("room_id = ".$id)->find()){
				$saverent = $rent->where("room_id = ".$id)->save($data);
			}else{
				$addrent = $rent->add($data);
			}

			if($saveroom||($saverent||$addrent)){

				die($this->success("配置成功"));
			}else{
				die($this->error("配置失败"));
			}
			exit;
		}
		// $roominfo = $room->table("pro_room r,pro_rent rt,pro_pro po,pro_user u")->field("r.*,u.uid,u.username,rt.fee,po.fee profee")->where("r.id = ".$id." and rt.room_id = po.room_num and r.id = rt.room_id and rt.uid = u.uid")->find();
		$roominfo = $room->table("pro_room r")->field("r.*,u.uid,u.username,rt.fee,po.fee profee,v.name")->join("left join pro_user u on u.uid = r.uid")->join("left join pro_rent rt on rt.uid = r.uid")->join("left join pro_pro po on po.uid = r.uid")->join("left join pro_village v on v.id = r.village_id")->where("r.id = ".$id)->find();
		// 获取房间单元号
		$getunitinfo = $room->where("id = ".$roominfo['parent_id'])->find();

		// 获取幢
		$getbuildinfo = $room->where("id = ".$getunitinfo['parent_id'])->find();
		$roominfo['build'] = $getbuildinfo['room'];
		$roominfo['unit'] = $getunitinfo['room'];
		// var_dump($roominfo);exit;
		$this->assign("roominfo",$roominfo);
		$this->display();
	}

	/**
	 * 停车位
	 * @return [type] [description]
	 */
	public function park($village_id=''){
		
		$park = M("park");
		$where = "1";
		if (!empty($village_id)) {
			$where .= " and p.village_id = ".$village_id;
		}
		
		// 自定义分页连表查询
        $page = new \Think\Page($park->table("pro_park p")->field("p.*,u.uid uuid,u.username,u.tel,u.status ustatus,v.name")->join("left join pro_user u on u.uid = p.uid")->join("left join pro_village v on v.id = p.village_id")->where($where)->order("num asc")->count(),24);
        $parklists = $park->table("pro_park p")->field("p.*,u.uid uuid,u.username,u.tel,u.status ustatus,v.name")->join("left join pro_user u on u.uid = p.uid")->join("left join pro_village v on v.id = p.village_id")->order("num asc")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

        // 获取所有小区
		$village = M("village");
		$villagelists = $village->select();
		$this->assign("village_id",$village_id);
		$this->assign("villagelists",$villagelists);
		$this->assign("meta_title","停车位管理");
		$this->assign("parklists",$parklists);
		$this->display();
	}

	/**
	 *  添加停车位
	 * @param string $num [车位号]
	 * @param string $village_id [小区ID号]
	 */
	public function addPark($num='',$village_id=''){
		
		if(IS_POST){

			!empty($num) or die($this->error("缺少参数"));
			!empty($village_id) or die($this->error("缺少参数"));

			$park = M("park");
			// 检查停车位是否已经存在
			if($park->where("num = ".$num." and village_id = ".$village_id)->find()){
				die($this->error("该小区已经存在该停车位"));
			}

			$data = $park->create($_POST);

			$addres = $park->add($data);

			if($addres){
				die($this->success("添加成功"));
			}else{
				die($this->error("添加失败"));
			}
		}

		$village = M("village");
		$villagelists = $village->select();
		$this->assign("villagelists",$villagelists);
		$this->display();
	}

	/**
	 * 配置停车位信息
	 * @param  string $id        [停车位序号]
	 * @param  string $fee       [费用]
	 * @param  string $status [属性]
	 * @param  string $uid       [所属用户]
	 * @return [type]            [description]
	 */
	public function editPark($id='',$fee='',$status='',$uid=''){
		
		!empty($id) or die($this->error("缺少参数1"));

		$park = M("park");

		if (IS_POST) {

			!empty($status)||$status == 0 or die($this->error("缺少参数2"));

			switch ((int)$status) {
				case 0:
					!empty($fee)||$fee==0 or die($this->error("缺少参数3"));
					break;
				case 1:
					unset($_POST['fee']);
					break;
				default:
					die($this->error("缺少参数"));
					break;
			}
			$data = $park->create($_POST);
			$saveres = $park->where("id = ".$id)->save($data);
			
			if($saveres){
				die($this->success("配置成功"));
			}else{
				die($this->error("配置失败"));
			}
		}

		$parkinfo = $park->table("pro_park p")->field("p.*,u.uid uuid,u.username,p.fee,v.name")->join("left join pro_user u on u.uid = p.uid and u.status = 2")->join("left join pro_village v on v.id = p.village_id")->where("p.id = ".$id)->find();
		// var_dump($parkinfo);exit;
		$this->assign("parkinfo",$parkinfo);
		$this->display();
	}

	/**
	 * 删除停车位
	 * @param  string $id [停车位ID号]
	 * @return [type]     [description]
	 */
	public function delPark($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$park = M("park");

		$delres = $park->where("id = ".$id)->delete();

		if ($delres) {
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

	/**
	 * 前台公告管理
	 * @return [type] [description]
	 */
	public function announce(){

		$announce = M("announce");

		// 自定义分页连表查询
        $page = new \Think\Page($announce->count(),10);
        $announcelists = $announce->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');


		$this->assign("meta_title","公告管理");
		$this->assign("announcelists",$announcelists);
		$this->display();
	}

	/**
	 * 添加系统通知
	 * @param  string $title   [通知标题]
	 * @param  string $content [通知内容]
	 * @param  string $status  [通知是否显示]
	 * @return [type]          [description]
	 */
	public function announceAdd($title='',$content='',$status=''){
		
		if(IS_POST){

			!empty($title) or die($this->error("通知标题不能为空"));
			!empty($content) or die($this->error("通知内容不能为空"));
			$announce = M("announce");
			$_POST['create_time'] = date("Y-m-d H:i:s",time());
			$data = $announce->create($_POST);
			$addres = $announce->add($data);
			if($addres){
				die($this->success("添加成功"));
			}else{
				die($this->error("添加失败"));
			}
		}
		$this->display();
	}

	/**
	 * 显示通知
	 * @param  string $id [通知ID号]
	 * @return [type]     [description]
	 */
	public function announceShow($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$announce = M("announce");

		$saveres = $announce->where("id in (".$id.")")->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));

		if ($saveres) {
			die($this->success("显示通知成功"));
		}else{
			die($this->error("显示通知失败"));
		}
	}

	/**
	 * 隐藏通知
	 * @param  string $id [通知ID号]
	 * @return [type]     [description]
	 */
	public function announceHide($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$announce = M("announce");

		$saveres = $announce->where("id in (".$id.")")->save(array("status"=>0,"update_time"=>date("Y-m-d H:i:s",time())));

		if ($saveres) {
			die($this->success("隐藏通知成功"));
		}else{
			die($this->error("隐藏通知失败"));
		}
	}

	/**
	 * 删除通知
	 * @param  string $id [通知ID号]
	 * @return [type]     [description]
	 */
	public function announceDel($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$announce = M("announce");

		$delres = $announce->where("id in (".$id.")")->delete();

		if ($delres) {
			die($this->success("删除通知成功"));
		}else{
			die($this->error("删除通知失败"));
		}
	}

	/**
	 * 编辑通知
	 * @param  string $id [通知ID号]
	 * @return [type]     [description]
	 */
	public function announceEdit($id='',$title='',$content='',$status=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$announce = M("announce");

		if(IS_POST){

			!empty($title) or die($this->error("通知标题不能为空"));
			!empty($content) or die($this->error("通知内容不能为空"));
			if (empty($status)) {
				$_POST['status'] = 0;
			}
			$_POST['update_time'] = date("Y-m-d H:i:s",time());
			$data = $announce->create($_POST);
			
			$saveres = $announce->where("id = ".$id)->save($data);

			if ($saveres) {
				die($this->success("编辑通知成功"));
			}else{
				die($this->error("编辑通知失败"));
			}
		}

		$announceinfo = $announce->where("id =".$id)->find();
		// var_dump($announceinfo);exit;
		$this->assign("announceinfo",$announceinfo);
		$this->display();
	}

	/**
	 * 小区管理
	 * @return [type] [description]
	 */
	public function village($name=''){
		
		$village = M("village");

		$where = "1";
		if(!empty($name)||$name==0){
			$where .= " and name like '%".$name."%'";
		}

		// 自定义分页连表查询
        $page = new \Think\Page($village->where($where)->count(),10);
        $villagelists = $village->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		$this->assign("meta_title","小区管理");
		$this->assign("villagelists",$villagelists);
		$this->display();
	}

	/**
	 * 添加小区
	 * @param string $name    [小区名称]
	 * @param string $address [小区地址]
	 */
	public function addVillage($name='',$address=''){
		
		if (IS_POST) {
			
			$village = M("village");
			!empty($name) or die($this->error("小区名称不能为空"));
			// !empty($address) or die($this->error("小区地址不能为空"));
			$_POST['create_time'] = date("Y-m-d H:i:s",time());
			$data = $village->create(array_filter($_POST));
			$addres = $village->add($data);
			if($addres){
				die($this->success("添加成功"));
			}else{
				die($this->error("添加失败"));
			}
		}
		$this->display();
	}

	/**
	 * 小区编辑
	 * @param  string $id      [小区ID号]
	 * @param  string $name    [小区名称]
	 * @param  string $address [小区地址]
	 * @return [type]          [description]
	 */
	public function editVillage($id='',$name='',$address=''){
		
		!empty($id) or die($this->error("缺少参数"));
		$village = M("village");
		if (IS_POST) {
			
			!empty($name) or die($this->error("小区名称不能为空"));

			$_POST['update_time'] = date("Y-m-d H:i:s",time());
			$data = $village->create(array_filter($_POST));

			$saveres = $village->where("id = $id")->save($data);

			if($saveres){
				die($this->success("编辑成功"));
			}else{
				die($this->error("编辑失败"));
			}
		}
		$villagedetail = $village->where("id = $id")->find();
		$this->assign("villagedetail",$villagedetail);
		$this->display();
	}

	/**
	 * 小区删除
	 * @param  string $id [小区ID号]
	 * @return [type]     [description]
	 */
	public function delVillage($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$village = M("village");

		$delres = $village->where("id = $id")->delete();

		if($delres){

			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

	/**
	 * 小区新闻
	 * @return [type]          [description]
	 */
	public function news($title='',$author='',$content=''){

		$news = M("news");
		$newslist = $news->order("create_time desc")->select();
		$this->assign("newslist",$newslist);
		$this->assign("meta_title","小区新闻");

		$this->display();
	}

	/**
	 * 添加小区新闻
	 * @param  string $title   [新闻标题]
	 * @param  string $author  [新闻作者]
	 * @param  string $content [新闻内容]
	 * @return [type]          [description]
	 */
	public function addnews($title='',$author='',$content=''){

		if(IS_POST){
			!empty($title) or die($this->error("新闻标题不能为空"));
			!empty($content) or die($this->error("新闻内容不能为空"));

			$news = M("news");
			$_POST['create_time'] = date("Y-m-d H:i:s",time());
			if(empty($author)){
				unset($_POST['author']);
			}
			$data = $news->create($_POST);

			$addres = $news->add($data);

			if($addres){
				die($this->success("添加成功"));
			}else{
				die($this->error("添加失败"));
			}
		}
		$this->assign("meta_title","添加新闻");

		$this->display();
	}

	/**
	 * 编辑小区新闻
	 * @param  string $title   [新闻标题]
	 * @param  string $author  [新闻作者]
	 * @param  string $content [新闻内容]
	 * @return [type]          [description]
	 */
	public function editnews($id='',$title='',$author='',$content=''){
		!empty($id) or die($this->error("缺少参数"));
		$news = M("news");
		if(IS_POST){
			!empty($title) or die($this->error("新闻标题不能为空"));
			!empty($content) or die($this->error("新闻内容不能为空"));
			$_POST['update_time'] = date("Y-m-d H:i:s",time());
			
			if(empty($author)){
				unset($_POST['author']);
			}
			$data = $news->create($_POST);

			$addres = $news->where("id = ".$id)->save($data);

			if($addres){
				die($this->success("编辑成功"));
			}else{
				die($this->error("编辑失败"));
			}
		}
		$newsdetail = $news->where("id = ".$id)->find();
		$this->assign("meta_title","编辑新闻");
		$this->assign("newsdetail",$newsdetail);
		$this->display();
	}

	/**
	 * 删除新闻
	 * @param  string $id [新闻ID号]
	 * @return [type]     [description]
	 */
	public function delnews($id=''){
		
		!empty($id) or die($this->error("缺少参数"));

		$news = M("news");

		if($news->where("id in(".$id.")")->delete()){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

	/**
	 * 显示新闻
	 * @param  string $id [新闻ID号]
	 * @return [type]     [description]
	 */
	public function shownews($id=''){

		!empty($id) or die($this->error("缺少参数"));

		$news = M("news");

		if($news->where("id in(".$id.")")->save(array("status"=>1))){
			die($this->success("显示成功"));
		}else{
			die($this->error("显示失败"));
		}
	}

	/**
	 * 隐藏新闻
	 * @param  string $id [新闻ID号]
	 * @return [type]     [description]
	 */
	public function hidenews($id=''){

		!empty($id) or die($this->error("缺少参数"));

		$news = M("news");

		if($news->where("id in(".$id.")")->save(array("status"=>0))){
			die($this->success("隐藏成功"));
		}else{
			die($this->error("隐藏失败"));
		}
	}
}





?>