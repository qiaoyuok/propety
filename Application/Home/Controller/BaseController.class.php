<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    const APPID = "wxb8952d943b52bfe6";
    const APPSECRET = "95d66c1770c171182cffc0682284ec61";
    const MCH_ID ="1487930592";
    const KEY = "6D8C998D1F086E581382983C60E554EE";

    // 微信客户端入口基础类
    protected function _initialize(){

        // 判断是否已经登录
        if(empty($_SESSION["wxb8952d943b52bfe6"]['uid'])){

            $this->login();
        }
        // var_dump($_SESSION);
        $company = M("company");

        $companyinfo = $company->select();

        $_SESSION['company'] = $companyinfo[0];
        $this->assign("option",ACTION_NAME);
    }

    //判断用户是否已经登录
    public function login(){
        // var_dump($_SERVER);exit;

            //重新登录
        if(!isset($_GET['code'])){
    
            // 获取code
            $redirect_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::APPID.'&redirect_uri='.$redirect_url.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header("Location: ".$url);
        }else{

            // 通过code获取access_token
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.self::APPID.'&secret='.self::APPSECRET.'&code='.$code.'&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url); 
            curl_setopt($ch,CURLOPT_HEADER,0); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
            $res = curl_exec($ch);
            curl_close($ch);
            $tokeninfo = json_decode($res,true);
            // var_dump($tokeninfo);exit;

            // 获取从用户信息
            $get_token_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$tokeninfo['access_token'].'&openid='.$tokeninfo['openid'].'&lang=zh_CN';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_token_url); 
            curl_setopt($ch,CURLOPT_HEADER,0); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
            $res = curl_exec($ch); 
            curl_close($ch);
            $userinfo = json_decode($res,true);
            // var_dump($json_obj);
            $_SESSION["wxb8952d943b52bfe6"]['nickname'] = $userinfo["nickname"];
            $_SESSION["wxb8952d943b52bfe6"]['headimgurl'] = str_replace("thirdwx","wx",$userinfo["headimgurl"]);
            $_SESSION["wxb8952d943b52bfe6"]['openid'] = $userinfo["openid"];
            $_SESSION["wxb8952d943b52bfe6"]['sex'] = $userinfo["sex"];
            
            $this->dealUser();
        }   
    }

    //对用户信息进入处理
    public function dealUser(){

        // !empty($userinfo) or die("<p>获取用户信息失败</p>");
        $user = M("user");

        $res = $user->where("openid = '".$_SESSION["wxb8952d943b52bfe6"]['openid']."'")->find();
        // 用户信息已存在
        if($res){
            $_SESSION["wxb8952d943b52bfe6"]['uid'] = $res['uid'];
        }else{
            // 用户信息不存在
            $_SESSION["wxb8952d943b52bfe6"]['create_time'] = date("Y-m-d H:i:s",time());
            $data = $user->create($_SESSION["wxb8952d943b52bfe6"]);
            $uid = $user->add($data);

            if($uid){
                $_SESSION["wxb8952d943b52bfe6"]['uid'] = $uid;
            }
        }
    }

    /**
     * 生成签名
     * @Author孙乔雨
     * @DateTime  2018-04-07T15:38:55+0800
     * @param     string                   $arr [签名数组]
     * $arr = [
     *      "appid"=>"qiaoyuok",
     *      "mch_id"=>"wahaha",
     *      "char"=>"123456"
     * ]
     * @return    [type]                        [description]
     */
    
    public function getSign($arr=''){

        // 将签名项去掉
        if (array_key_exists("sign", $arr)) {
            unset($arr['sign']);
        }

        // 去除数组中的空值
        $arr = array_filter($arr);
        // 桉字典进行排序
        ksort($arr);
        // 把数组拼成字符串
        $sign = http_build_query($arr);  //http_build_query()把数组快速拼接为url键值对参数
        // 加上密钥key
        $sign = urldecode($sign."&key=".$this::KEY);  //urldecode()解决http_bulid_query函数使用后的中文转码问题

        // 先进行md5加密，再转为大写 最终生成签名
        $sign =  strtoupper(md5($sign));

        return $sign;
    }

    // 获取带签名的数组
    public function setSign($arr=''){
        
        $sign = $this->getSign($arr);

        $arr["sign"] = $sign;

        return $arr;

    }

    // 校验签名 带有签名的数组
    public function checkSign($arr=''){
        
        // 先签名，再比对签名
        $sign = $this->getSign($arr);

        if ($sign == $arr['sign']) {
            return true;
        }else{
            return false;
        }
    }

    //获取用户openID
    public function getOpenId(){
        if(isset($_SESSION['wxb8952d943b52bfe6']['openid'])){
            return $_SESSION['wxb8952d943b52bfe6']['openid'];
        }else{
            // var_dump($_SERVER);return ;
            if(empty($_GET['code'])){
                $REDIRECT_URI = "http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].$_SERVER[''];
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
                header("Location: $url");
            }else{
                $code = $_GET['code'];
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::APPID."&secret=".self::SECRET."&code=".$code."&grant_type=authorization_code";
                $curl = curl_init(); // 启动一个CURL会话
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
                $res = curl_exec($curl);     //返回api的json对象
                //关闭URL请求
                curl_close($curl);
                // 把access_token存到文件中
                $res = json_decode($res,true);
                $_SESSION['wxb8952d943b52bfe6']['openid'] = $res['openid'];
                return $_SESSION['wxb8952d943b52bfe6']['openid'];
            }
        }
    }
    
    /**
     * 统一下单api
     * @param  string $sn        [订单号]
     * @param  string $total_fee [费用]
     * @param  string $detail      [商品详情]
     * @return [type]            [description]
     */
    public function unifiedOrder($sn='',$total_fee='',$detail=''){
        
        // 1:构建原始数据
        $nonce_str = md5(time());
        $fee = $total_fee*100;
        $params = [

            "appid"=>self::APPID,
            "mch_id"=>self::MCH_ID,
            "nonce_str"=>$nonce_str,
            "body"=>"商品描述",
            "out_trade_no"=>$sn,
            "total_fee"=>$fee,
            "spbill_create_ip"=>$_SERVER['REMOTE_ADDR'],
            "notify_url"=>"http://pro.mysvip.cn/index.php/Home/Com/notify",
            "trade_type"=>"JSAPI",
            "product_id"=>"123",
            "openid"=>$this->getOpenId(),
        ];

        // 创建订单
        if(!$this->buildOrder($sn,$total_fee,$detail)){
            die($this->error("创建订单失败"));
        }

        // 2:加入签名
        $sign = $this->setSign($params);
        // var_dump($sign);
        // 3:将数组转化为XML
        $xml = $this->arrToXml($sign);
        $res = $this->psotXML($xml);

        // 返回的数据为XML格式，将其转化为数组
        $arr = $this->xmlToArr($res);
        return $arr;
    }

    /**
     * 创建订单
     * @param  string $sn        [订单号]
     * @param  string $total_fee [费用]
     * @param  string $detail      [商品详情]
     * @return [type]            [description]
     */
    public function buildOrder($sn='',$total_fee='',$detail=''){
        
        $order = M("order");

        $data = [
            "sn"        =>$sn,
            "total_fee" =>$total_fee,
            "detail"    =>$detail,
            "create_time"=>date("Y-m-d H:i:s",time()),
            "uid"       =>$_SESSION['wxb8952d943b52bfe6']['uid']
        ];

        $data = $order->create($data);
        $addres = $order->add($data);

        if($addres){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取prepayid
     * @param  string $sn        [订单编号]
     * @param  string $total_fee [费用]
     * @param  string $detail    [商品详情]
     * @return [type]            [description]
     */
    public function getPrepayId($sn='',$total_fee='',$detail=''){
        
        $res = $this->unifiedOrder($sn,$total_fee,$detail);
        return $res['prepay_id'];
    }

    // 获取支付所需的json数据
    public function getJson($prepay_id=''){
        
        $params = [
            "appId"=>self::APPID,
            "timeStamp"=>(string)time(),
            "nonceStr"=>md5(time()),
            "package"=>"prepay_id=".$prepay_id,
            "signType"=>"MD5"
        ];
        $params['paySign'] = $this->getSign($params);
        return json_encode($params);
    }

    // 数组转XML
    public function arrToXml($arr=''){

        if(!is_array($arr) || count($arr) == 0) return '';

        $xml = "<xml>";

        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }

        $xml.="</xml>";
        return $xml; 
    }

    // XML转数组
    public function xmlToArr($xml=''){

        if($xml == '') return '';

        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);     
        return $arr;
    }

    // 发送XML数据
    public function psotXML($data=''){
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_SSL_VERIFYHOST] = false; //是否重定向
        $params[CURLOPT_SSL_VERIFYPEER] = false; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $data;

        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content; //输出登录结果

    }

    // 获取POST过来的数据
    public function getPost(){
        return file_get_contents('php://input'); 
    }
}