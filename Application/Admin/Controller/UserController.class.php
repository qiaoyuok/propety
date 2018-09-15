<?php
namespace Admin\Controller;

/**
* 后台用户管理类
*/
class UserController extends BaseController{
	
	/**
	 * 获取后台管理员列表
	 * @param  string $nickname [昵称]
	 * @return [type]           [description]
	 */
	public function index($nickname=''){
		
		$admin = M("admin");
		$where = "status >=0";

		if(!empty($nickname)||$nickname==0){
			$where .= " and nickname like '%".$nickname."%'";
		}

		// 自定义分页连表查询
        $page = new \Think\Page($admin->where($where)->order("uid desc")->count(),10);
        $adminlists = $admin->where($where)->order("uid desc")->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		$this->assign("adminlists",$adminlists);
		$this->assign("meta_title","管理员列表");
		$this->display();
	}

	/**
	 * 添加后台管理员
	 * @param string $username   [用户名]
	 * @param string $nickname   [昵称]
	 * @param string $password   [密码]
	 * @param string $repassword [重复密码]
	 */
	public function adminAdd($username='',$nickname='',$password='',$repassword=''){

		if(IS_POST){

			!empty($username) or die($this->error("用户名不能为空"));
			!empty($password) or die($this->error("密码不能为空"));
			!empty($repassword) or die($this->error("确认密码不能为空"));
			!empty($nickname) or $_POST['nickname'] = $username;
			$password == $repassword or die($this->error("两次输入的密码不同"));
			mb_strlen($password)>=6 or die($this->error("密码不低于6个字符"));
			mb_strlen($username)>=6 or die($this->error("用户名不低于6个字符"));

			$admin = M("admin");

			if($admin->where("username = '".$username."' and status >= 0")->find()){
				die($this->error("用户名已存在"));
			}

			$_POST['password'] = md5($password);
			$_POST['create_time'] = date("Y-m-d H:i:s",time());
			$_POST['update_time'] = date("Y-m-d H:i:s",time());

			$data = $admin->create($_POST);
			$addres = $admin->add($data);
			if($addres){
				$this->success("添加成功");
			}else{
				$this->error("添加失败");
			}
			return ;
		}

		$this->display();
	}

	/**
	 * 删除管理员用户
	 * @param  string $uid [管理员ID号]
	 * @return [type]      [description]
	 */
	public function adminDel($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));
		!in_array(1,explode(",",$uid)) or die($this->error("不能对超级管理员执行该操作"));

		$admin = M("admin");

		$delres = $admin->where("uid in (".$uid.")")->delete();

		if($delres){
			$this->success("删除成功");
		}else{
			$rhis->error("删除失败");
		}

		return;
	}

	/**
	 * 禁用管理员操作
	 * @param  string $uid [管理员ID号]
	 * @return [type]      [description]
	 */
	public function adminForbid($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));
		!in_array(1,explode(",",$uid)) or die($this->error("不能对超级管理员执行该操作"));

		$admin = M("admin");
		$forbidres = $admin->where("uid in (".$uid.")")->save(array("status"=>0,"update_time"=>date("Y-m-d H:i:s",time())));
		if($forbidres){
			$this->success("禁用成功");
		}else{
			$this->error("禁用失败");
		}
		return ;
	}

	/**
	 * 启用管理员操作
	 * @param  string $uid [管理员ID号]
	 * @return [type]      [description]
	 */
	public function adminOpen($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));
		!in_array(1,explode(",",$uid)) or die($this->error("不能对超级管理员执行该操作"));

		$admin = M("admin");
		$openres = $admin->where("uid in (".$uid.")")->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));
		if($openres){
			$this->success("启用成功");
		}else{
			$this->error("启用失败");
		}
		return ;
	}

	/**
	 * 编辑管理员
	 * @param string $uid        	[管理员ID号]
	 * @param string $nickname   	[原始昵称]
	 * @param string $renickname   	[新昵称]
	 * @param string $flag   		[修改密码或昵称标志  1：修改昵称；2：修改密码]
	 * @param string $password   	[密码]
	 * @param string $repassword   	[确认密码]
	 */
	public function adminEdit($uid='',$nickname='',$renickname='',$flag='',$password='',$repassword=''){
		!empty($uid) or die($this->error("缺少参数"));
		$admin = M("admin");
		if(IS_POST){
			switch ($flag) {
				case "1":
					!empty($renickname) or die($this->error("新昵称不能为空"));
					$nickname != $renickname or die($this->error("新旧昵称相同"));
					$_POST['nickname'] = $renickname;
					break;
				case "2":
					!empty($password) or die($this->error("密码不能为空"));
					!empty($repassword) or die($this->error("确认密码不能为空"));
					$password == $repassword or die($this->error("两次输入密码不同"));
					$_POST['password'] = md5($password);
					break;
				case "3":
					$config = array( 'maxSize' => 1048576, 'rootPath' => './Public/', 'savePath' => './images/avatar/', 'saveName' => $uid, 'exts' => '', 'autoSub' => true, 'subName' => "",'replace'=>true,'exts'=>array('jpg', 'gif', 'png', 'jpeg')); 
			        $upload = new \Think\Upload($config);
			        $info = $upload->upload();
			        if(!$info) {
			        	die($this->error($upload->getError()));    
			        }
				    $_POST['avatarurl']	= $info['file']['savename'];
					break;
				default:
					!empty($uid) or die($this->error("缺少参数"));
			}

			$_POST['update_time'] = date("Y-m-d H:i:s",time());
			
			$data = $admin->create($_POST);

			$saveres = $admin->where("uid = ".$uid)->save($data);
			if($saveres){

				if($flag == "1" && $uid == $_SESSION['admininfo']['uid']){
					$_SESSION['admininfo']['nickname'] = $renickname;
				}

				if($flag == "3" && $uid == $_SESSION['admininfo']['uid']){
					$_SESSION['admininfo']['avatarurl'] = $info['file']['savename']."?a=".rand();
				}

				$this->success("编辑成功");
			}else{
				$this->error("编辑失败");
			}
			return ;
		}
		$flag = !empty($flag)?$flag:1;
		$userinfo = $admin->where("uid = ".$uid)->find();
		$this->assign("userinfo",$userinfo);
		$this->assign("flag",$flag);
		$this->display();
	}

	/**
	 * 获取用户列表
	 * @param  string $page     [页数]
	 * @param  string $limit    [记录数]
	 * @param  string $nickname [昵称或姓名]
	 * @return [type]           [description]
	 */
	public function user($page='',$limit='',$nickname=''){
		
		$user = M("user");
		
		if(IS_POST){
			$page = !empty($page)?$page:1;
			$limit = !empty($limit)?$limit:6;
			$where = "status = 2";	
			$userlists = $user->page($page)->limit($limit)->where($where)->select();
			$count = $user->where($where)->count();	
			die('{"code":0,"data":'.json_encode($userlists).',"count":'.$count.'}');
		}
		
		$where = "1";

		if(!empty($nickname)||$nickname==0){
			$where .= " and nickname like '%".$nickname."%' or username like '%".$nickname."%'";
		}

		// 自定义分页连表查询
        $page = new \Think\Page($user->where($where)->count(),10);
        $userlists = $user->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        // var_dump($list);exit;
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
        $this->assign('_page', $p? $p: '');

		// var_dump($userlists);exit;
	
		$this->assign("meta_title","用户列表");
		$this->assign("userlists",$userlists);
		$this->display();
	}

	/**
	 * 拉黑用户
	 * @param  string $uid [用户ID号]
	 * @return [type]      [description]
	 */
	public function toDark($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));

		$user = M("user");

		$saveres = $user->where("uid in (".$uid.")")->save(array("status"=>0,"update_time"=>date("Y-m-d H:i:s",time())));

		if($saveres){
			die($this->success("拉黑成功"));
		}else{
			die($this->error("拉黑失败"));
		}
	}

	/**
	 * 解救用户
	 * @param  string $uid [用户ID号]
	 * @return [type]      [description]
	 */
	public function help($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));

		$user = M("user");

		$saveres = $user->where("uid in (".$uid.")")->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));

		if($saveres){
			die($this->success("解救成功"));
		}else{
			die($this->error("解救失败"));
		}
	}

	/**
	 * 认证通过
	 * @param  string $uid [用户ID号]
	 * @return [type]      [description]
	 */
	public function pass($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));

		$user = M("user");

		$saveres = $user->where("uid in (".$uid.")")->save(array("status"=>2,"update_time"=>date("Y-m-d H:i:s",time())));

		if($saveres){
			die($this->success("认证成功"));
		}else{
			die($this->error("认证失败"));
		}
	}

	/**
	 * 删除用户
	 * @param  string $uid [用户ID号]
	 * @return [type]      [description]
	 */
	public function delUser($uid=''){
		
		!empty($uid) or die($this->error("缺少参数"));

		$user = M("user");

		$delres = $user->where("uid in (".$uid.")")->delete();

		if($delres){
			die($this->success("删除成功"));
		}else{
			die($this->error("删除失败"));
		}
	}

	/**
	 * 编辑用户
	 * @param  string $uid      [用户ID号]
	 * @param  string $username [用户姓名]
	 * @param  string $nickname [用户昵称]
	 * @param  string $tel      [用户电话]
	 * @return [type]           [description]
	 */
	public function editUser($uid='',$username='',$nickname='',$tel=''){
		
		!empty($uid) or die($this->error("缺少参数"));

		$user = M("user");

		if(IS_POST){

			if(!empty($tel)){

				$checktel="/^1[345678]{1}\d{9}$/";//定义正则表达式  
				if(!preg_match($checktel,$tel)){
					die($this->error("手机号格式不正确"));
				}
			}
			$_POST['update_time'] = date("Y-m-d H:i:s",time());
			$data = $user->create($_POST);
			$saveres = $user->where("uid = ".$uid)->save($data);
			if($saveres){
				die($this->success("编辑成功"));
			}else{
				die($this->error("编辑失败"));
			}
		}
		$userinfo = $user->where("uid = ".$uid)->find();

		$this->assign("userinfo",$userinfo);
		$this->display();
	}
}





?>