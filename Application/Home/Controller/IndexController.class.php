<?php
namespace Home\Controller;
// use Think\Controller;
class IndexController extends BaseController {
// class IndexController extends Controller {

    public function index(){

        // 获取站内通知
        $announce = M("announce");
        $announcelist = $announce->where("status = 1")->order("create_time desc")->select();

        // 获取新闻
        $news = M("news");
        $newslist = $news->where("status = 1")->order("create_time desc")->select();
        // var_dump($newslist);
        $this->assign("announcelist",$announcelist);
        $this->assign("newslist",$newslist);
        $this->assign("meta_title","用户首页");
        $this->display();
    }

    /**
     * 个人中心
     * @return [type] [description]
     */
    public function my(){
    	// var_dump($_SESSION);
        // // 获取用户当前状态
        $user = M("user");
        $userinfo = $user->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])->find();
        $this->assign("userinfo",$userinfo);
        $this->assign("meta_title","个人中心");
    	$this->display();
    }

    /**
     * 提交用户信息
     * @param  string $username [用户名]
     * @param  string $tel      [手机号]
     * @return [type]           [description]
     */
    public function checkuserinfo($username='',$tel=''){
        
        $user = M("user");
        if(IS_POST){
            !empty($username) or die($this->error("用户姓名不能为空"));
            !empty($tel) or die($this->error("用户手机不能为空"));

            $checktel="/^1[345678]{1}\d{9}$/";//定义正则表达式  
            if(!preg_match($checktel,$tel)){
                die($this->error("手机号格式不正确"));
            }

            $data = $user->create($_POST);

            $saveres = $user->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])->save($data);

            if($saveres){
                die($this->success("提交成功"));
            }else{
                die($this->error("提交失败"));
            }
        }

        $userinfo = $user->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])->find();
        $this->assign("meta_title","登记个人信息");
        $this->assign("userinfo",$userinfo);
        $this->display();
    }

    /**
     * 获取用户租房信息
     * @return [type] [description]
     */
    public function userHome(){
        
        $rent = M("rent");
        $room = M("room");
        $roomlist = $room->field("r.*,v.name")->table("pro_room r,pro_village v")->where("v.id = r.village_id")->select();
        $rentlist = $rent
        ->table("pro_rent r,pro_pro po")
        ->field("r.out_time rout_time,r.room_id,r.fee rfee,r.last_pay_time rlast_pay_time,r.status,po.out_time poout_time,po.fee pofee,po.last_pay_time polast_pay_time")
        ->where("r.room_id = po.room_num and r.uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])
        ->select();
        // var_dump($rentlist);
        if ($rentlist) {
            foreach ($rentlist as $k => $v) {
                
                foreach ($roomlist as $k1 => $v1) {
                    
                    if($v1['id'] == $v['room_id']){
                        // 拿到房间号
                        $rentlist[$k]['room'] = $v1['room'];
                        foreach ($roomlist as $k2 => $v2) {
                            if($v1['parent_id'] == $v2['id']){
                                // 拿到单元号
                                 $rentlist[$k]['unit'] = $v2['room'];
                                 foreach ($roomlist as $k3 => $v3) {
                                    if($v2['parent_id'] == $v3['id']){
                                        // 拿到幢
                                        $rentlist[$k]['build'] = $v3['room'];
                                        break;
                                    }
                                 }
                                 break;
                            }
                        }
                        $rentlist[$k]['village_name'] = $v1['name'];
                        break;
                    }
                }
                $now = date("Y-m",time());
                if ($now<=substr($v['polast_pay_time'],0,7)) {
                    $rentlist[$k]['pofeestatus'] = 1;
                }

                if ($now<=substr($v['rlast_pay_time'],0,7)) {
                    $rentlist[$k]['rfeestatus'] = 1;
                }

            }
        }

        // var_dump($rentlist);exit;
        $this->assign("meta_title","我的租房");
        $this->assign("rentlist",$rentlist);
        $this->display();
    }

    /**
     * 获取用户停车位信息
     * @return [type] [description]
     */
    public function userPark(){
        
        $park = M("park");
        $parklist = $park
        ->field("p.*,v.name")
        ->table("pro_park p,pro_village v")
        ->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid']." and v.id = p.village_id")
        ->select();
        // 判断本月是否已缴费
        $now = date("Y-m",time());
        foreach ($parklist as $k => $v) {
            if ($now<=substr($v['out_time'],0,7)) {
                $parklist[$k]['feestatus'] = 1;
            }
        }
        // var_dump($parklist);exit;
        $this->assign("meta_title","我的停车位");
        $this->assign("parklist",$parklist);
        $this->display();
    }

    /**
     * 获取消息通知
     * @return [type] [description]
     */
    public function msg(){
        
        $msg = M("msg");

        $msglist = $msg
        ->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])
        ->order("create_time desc")
        ->select();
        $this->assign("msglist",$msglist);
        $this->assign("meta_title","消息通知");
        $this->display();
    }

    /**
     * 查看消息详情
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function msgDetail($id=''){
        
        !empty($id) or die($this->error("缺少参数"));

        $msg = M("msg");
        $msgdetail = $msg->where("id = ".$id)->find();
        if($msgdetail['status']==0){
            $msg->where("id = ".$id)->save(array("status"=>1));
        }
        // var_dump($msgdetail);
        $this->assign("msgdetail",$msgdetail);
        $this->assign("meta_title","消息详情");
        $this->display();
    }

    /**
     * 用户投诉列表
     * @return [type] [description]
     */
    public function complaint(){
        
        $complaint = M("complaint");

        $complaintlist = $complaint
        ->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])
        ->order("create_time desc")
        ->select();

        $this->assign("meta_title","我的投诉");
        $this->assign("complaintlist",$complaintlist);
        $this->display();
    }

    /**
     * 用户添加投诉
     * @param string $content [用户投诉内容]
     */
    public function addCom($content=''){
        
        if(IS_POST){

            !empty($content) or die($this->error("投诉内容不能为空"));

            $complaint = M("complaint");
            $_POST['create_time'] = date("Y-m-d H:i:s",time());
            $_POST['uid'] = $_SESSION['wxb8952d943b52bfe6']['uid'];
            
            // 看是否有权限
            $user = M("user");
            $userinfo = $user->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid']." and status = 2")->find();
            if(!$userinfo){
                die($this->error("请先通过认证"));
            }

            $data = $complaint->create($_POST);

            $addres = $complaint->add($data);
            if($addres){
                die($this->success("投诉成功"));
            }else{
                die($this->error("投诉失败"));
            }
        }

        $this->assign("meta_title","添加投诉");
        $this->display();
    }

    /**
     * 查看投诉处理详情
     * @param  string $id [投诉ID号]
     * @return [type]     [description]
     */
    public function complaintDetail($id=''){
        !empty($id) or die($this->error("缺少参数"));
        $complaint = M("complaint");
        $complaintdetail = $complaint->where("id = ".$id)->find();
        // var_dump($msgdetail);
        $this->assign("meta_title","投诉详情");
        $this->assign("complaintdetail",$complaintdetail);
        $this->display();
    }

    /**
     * 用户设备报修列表
     * @return [type] [description]
     */
    public function device(){
        
        $device = M("device");

        $devicelist = $device
        ->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid'])
        ->order("create_time desc")
        ->select();

        $this->assign("devicelist",$devicelist);
        $this->assign("meta_title","设备报修");
        $this->display();
    }

    /**
     * 用户添加设备报修
     * @param string $content [设备报修内容]
     */
    public function addDevice($content=''){
        
        if(IS_POST){

            !empty($content) or die($this->error("报修内容不能为空"));

            $device = M("device");
            $_POST['create_time'] = date("Y-m-d H:i:s",time());
            $_POST['uid'] = $_SESSION['wxb8952d943b52bfe6']['uid'];
            // $_POST['uid'] = 1;
            
            // 看是否有权限
            $user = M("user");
            $userinfo = $user->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid']." and status = 2")->find();
            if(!$userinfo){
                die($this->error("请先通过认证"));
            }

            $data = $device->create($_POST);

            $addres = $device->add($data);
            if($addres){
                die($this->success("报修成功"));
            }else{
                die($this->error("报修失败"));
            }
        }

        $this->assign("meta_title","添加设备报修");
        $this->display();
    }

    /**
     * 查看报修处理详情
     * @param  string $id [报修ID号]
     * @return [type]     [description]
     */
    public function deviceDetail($id=''){
        !empty($id) or die($this->error("缺少参数"));
        $device = M("device");
        $devicedetail = $device->where("id = ".$id)->find();
        // var_dump($msgdetail);
        $this->assign("devicedetail",$devicedetail);
        $this->assign("meta_title","设备报修详情");
        $this->display();
    }

    /**
     * 查看通知详情
     * @param  string $id [投诉ID号]
     * @return [type]     [description]
     */
    public function announceDetail($id=''){
        !empty($id) or die($this->error("缺少参数"));
        $announce = M("announce");
        $announcedetail = $announce->where("id = ".$id)->find();
        // var_dump($msgdetail);
        $this->assign("announcedetail",$announcedetail);
        $this->assign("meta_title","公告详情");
        $this->display();
    }

    /**
     * 调用下单接口
     * @param  string $total_fee [总费用]
     * @param  string $detail    [商品详情]
     * @return [type]            [description]
     */
    public function topay($total_fee='',$detail=''){
        !empty($total_fee) or die($this->error("缺少金额参数"));
        !empty($detail) or die($this->error("缺少详情参数"));
        // 获取用户openID
        $sn = date("YmdHis",time()).rand(100000,999999);
        $prepar_id = $this->getPrepayId($sn,$total_fee,$detail);
        echo  $this->success($this->getJson($prepar_id));
    }

    /**
     * 关于我们
     * @return [type] [description]
     */
    public function about(){
        
        $this->assign("meta_title","关于我们");
        $this->display();
    }

    /**
     * 交易记录查询
     * @return [type] [description]
     */
    public function order(){
        
        $order = M("order");
        $orderlist = $order->where("uid = ".$_SESSION['wxb8952d943b52bfe6']['uid']." and status = 1")->select();
        foreach ($orderlist as $k => $v) {
            $detail = json_decode($v['detail'],true);
            switch ($detail['flag']) {
                case 1:
                    $orderlist[$k]['name'] = "房租费";
                    $orderlist[$k]['des'] = "房间号：".$this->getHousenum($detail['num']);
                    break;
                case 2:
                    $orderlist[$k]['name'] = "物业费";
                    $orderlist[$k]['des'] = "房间号：".$this->getHousenum($detail['num']);
                    break;
                case 3:
                    $orderlist[$k]['name'] = "车位费";
                    $orderlist[$k]['des'] = "车位号：".$this->getParknum($detail['num']);
                    break;
                default:
                    $orderlist[$k]['name'] = "房租费";
                    $orderlist[$k]['des'] = "房间号：".$this->getHousenum($detail['num']);
                    break;
            }
        }
        $this->assign("meta_title","交易记录");
        $this->assign("orderlist",$orderlist);
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

    /**
     * 新闻ID号
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function newsdetail($id=''){
        
        !empty($id) or die($this->error("缺少参数"));

        $news = M("news");
        $newsdetail = $news->where("id = ".$id)->find();
        $this->assign("meta_title",$newsdetail['title']);
        $this->assign("meta_title","新闻详情");
        $this->assign("newsdetail",$newsdetail);
        $this->display();
    }
}