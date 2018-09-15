<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台基础类，入口类
 */
class BaseController extends Controller {

    /**
     * 
     * 后台入口校验
     * @return [type] [description]
     */
    public function _initialize(){
        
        if (empty($_SESSION['admininfo'])) {
            $this->redirect("Login/index");
        }
        // var_dump($_SESSION);
        // 获取该控制器下的菜单
        $menulists = D("menu")->where("hide = 0")->order("sort desc")->select();
        if($menulists){
            foreach ($menulists as $key => $value) {
                $controller = strtolower(explode("/",$value['url'])[0]);
                $value['controller'] = $controller;
                if(strtolower(CONTROLLER_NAME) == $controller && $value['parent_id'] == 0){
                    foreach ($menulists as $k => $v) {
                        $v['option'] = explode("/",$v['url'])[1];
                        $v['controller'] = $controller;
                        if($v['parent_id'] == $value['id']){
                            if($v['group']){
                                $menus[$v['group']][] = $v;
                            }else{
                                $menus[$k][] = $v;
                            }
                        }
                    }
                }
                if ($value['parent_id'] == 0) {
                    $menu_nav[] = $value;
                }
            }
        }

        // var_dump($_REQUEST);exit;
        if(count($_REQUEST)>1){
            $this->assign("back",1);
        }

        // var_dump($menu_nav);
        // var_dump($menus);
        $this->assign("option",ACTION_NAME);
        $this->assign("controller",CONTROLLER_NAME);
        !empty($menus)?$this->assign("menus",$menus):"";
        $this->assign("menu_nav",$menu_nav);
        $this->assign("admininfo",$_SESSION['admininfo']);
        $this->assign("companyinfo",$_SESSION['companyinfo']);

    }
}