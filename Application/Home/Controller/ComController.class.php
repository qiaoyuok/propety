<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 支付通知类
 */
class ComController extends Controller{
	
	// 1：获取通知数据  ->转为数组
	// 2：验证签名	->签名校验
	// 3：验证业务结果	->result_code  和  return_code
	// 4：验证订单号和金额  out_trade_no 和 total_fee
	// 5：修改订单状态，可以发货
	const KEY = "6D8C998D1F086E581382983C60E554EE";

	public function notify(){
		$xmldata = $this->getPost();
		$arr = $this->xmlToArr($xmldata);
		file_put_contents("./stat.txt", json_encode($arr)."\n",FILE_APPEND);
		if($this->checkSign($arr)){
			if($arr['result_code']=="SUCCESS" && $arr['return_code'] == "SUCCESS"){
				// 根据订单号查询数据库中该订单的金额
				$order = M("order");
				$orderinfo = $order->where("sn = '".$arr['out_trade_no']."'")->find();
				if ($orderinfo) {
					if($arr['total_fee'] == $orderinfo['total_fee']*100){
						file_put_contents("./log.txt", "订单确认无误"."\n",FILE_APPEND);
						// 修改订单状态
						$saveres = $order->where("id = ".$orderinfo['id'])->save(array("status"=>1,"update_time"=>date("Y-m-d H:i:s",time())));
						// 更新租房/物业费/停车位费下的状态
						$detail = json_decode($orderinfo['detail'],true);
						switch ($detail['flag']) {
							case 1:  //租房
								$rent = M("rent");
								$rent->where("room_id = ".$detail['num'])->save(array("out_time"=>date("Y-m-d H:i:s",time()+2678400),"last_pay_time"=>date("Y-m-d H:i:s",time())));
								break;
							case 2:  //物业
								$rent = M("pro");
								$rent->where("room_num = ".$detail['num'])->save(array("out_time"=>date("Y-m-d H:i:s",time()+2678400),"last_pay_time"=>date("Y-m-d H:i:s",time())));
								break;
							case 3:  //停车位
								$rent = M("park");
								$rent->where("id = ".$detail['num'])->save(array("out_time"=>date("Y-m-d H:i:s",time()+2678400),"last_pay_time"=>date("Y-m-d H:i:s",time())));
								break;
						}

						file_put_contents("./log.txt", "支付完成"."\n",FILE_APPEND);
						// 给微信服务器做应答
						$params = [
							"return_code"=>"SUCCESS",
							"return_msg"=>"OK"
						];
						echo $this->arrToXml($params);
					}else{

						file_put_contents("./log.txt", "支付金额有误！"."\n",FILE_APPEND);

					}
				}
			}else{
				file_put_contents("./log.txt", "业务结果错误"."\n",FILE_APPEND);
			}
		}else{
			file_put_contents("./log.txt", "签名错误！"."\n",FILE_APPEND);
		}
	}

	// 获取POST过来的数据
    public function getPost(){
        return file_get_contents('php://input'); 
    }

    // XML转数组
    public function xmlToArr($xml=''){

        if($xml == '') return '';

        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);     
        return $arr;
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
}