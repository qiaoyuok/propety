<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {


	/**
	 * 用户登录操作
	 * @param  string $username [用户名]
	 * @param  string $password [用户密码]
	 * @param  string $code     [验证码]
	 * @return [type]           [description]
	 */
    public function index($username='',$password='',$code=''){

    	if(IS_POST){

    		if(empty($username)){
    			$this->error("用户名不能为空");
    		}

    		if(empty($password)){
    			$this->error("密码不能为空");
    		}

    		if(empty($code)){
    			$this->error("验证码不能为空");
    		}

    		// 开始校验严验证码
    		if($this->check_verify($code)){

    			// 开始校验用户信息
    			$admin = M("admin");
    			$admininfo = $admin->where("username = '".$username."' and status = 1")->find();
    			if($admininfo){
    				if($admininfo['password'] == md5($password)){

                        $_SESSION['admininfo']['uid'] = $admininfo['uid'];
                        $_SESSION['admininfo']['avatarurl'] = $admininfo['avatarurl'];
    					$_SESSION['admininfo']['nickname'] = $admininfo['nickname'];

                        // 登录时获取公司信息
                        $company = M("company");
                        $companyinfo = $company->select()[0];
                        $_SESSION['companyinfo'] = $companyinfo;
                        $count = $admininfo['count']+1;
                        $admin->where("uid = ".$admininfo['uid'])->save(array("count"=>$count,"last_login_time"=>date("Y-m-d H:i:s",time())));
    					$this->success("登陆成功");
    				}else{

    					$this->error("密码错误");
    				}
    			}else{
    				$this->error("用户不存在或被禁用");
    			}

    		}else{
    			$this->error("验证码错误");
    		}

    		return ;
    	}

    	//登录态直接进入首页
    	if(!empty($_SESSION['admininfo'])){
    		$this->redirect("Index/index");
    	}

        $this->display();
    }

    /**
     * 获取登录页验证码
     * @return [type] [description]
     */
    public function getCode(){
    	$config =    array(
		    'fontSize'    =>    17,    // 验证码字体大小
		    'length'      =>    4,     // 验证码位数
		    'useNoise'    =>    false, // 关闭验证码杂点
		    'imageW'	  =>150,
		    'imageH'	  =>50
		);
		$Verify =     new \Think\Verify($config);
		$Verify->entry();
    }

    /**
     * 验证码校验
     * @param  [type] $code [description]
     * @param  string $id   [description]
     * @return [type]       [description]
     */
    function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}

    /**
     * 退出操作
     * @return [type] [description]
     */
    public function loginOut(){
        unset($_SESSION['admininfo']);
        return ;
    }

    public function Token()
    {
        var_dump(111);
        exit;
    }
}