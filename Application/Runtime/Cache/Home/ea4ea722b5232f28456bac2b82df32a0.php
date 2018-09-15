<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?></title>
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/Public/home.css">
    <script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/Public/layui/layui.js"></script>
    
</head>

<body>
    <!-- 内容区 -->
    <div class="content">
        
    <div class="header">
        <img src="http://thirdwx.qlogo.cn/mmopen/vi_32/vcM6tkqVrfgC9BB2ANmiaWjBuZhjBTNeXuOImDcFbkD39YtdbXrEGg8OTribsDGqx4Xr6PQvBic4IgcQHnDU55taw/132">
        <div class="userinfobox">
            <p>雨后桥前</p>
            <div>
                <?php if($userinfo["status"] == 1): ?><span onclick="window.location.href='<?php echo U(checkuserinfo);?>'">待认证</span><img onclick="window.location.href='<?php echo U(checkuserinfo);?>'" style="width: 20px;height: 20px;" src="/Public/images/checkin.png"><?php elseif($userinfo["status"] == 2): ?><span>已认证</span><?php else: ?><span>被拉黑</span><?php endif; ?>
            </div>
        </div>
    </div>
    <div class="list">
        <ul>
            <!-- <li onclick="window.location.href='<?php echo U(checkuserinfo);?>'"><img src="/Public/images/check.png"><p>信息登记<?php if(($userinfo["status"]) == "1"): ?><span style="color: red">待认证</span><?php else: ?><span style="color: red">待认证</span><?php endif; ?></p><img src="/Public/images/in.png"></li> -->
            <li onclick="window.location.href='<?php echo U(userhome);?>'"><img src="/Public/images/home.png"><p>我的租房</p><img src="/Public/images/in.png"></li>
            <li onclick="window.location.href='<?php echo U(userpark);?>'"><img src="/Public/images/park.png"><p>我的停车位</p><img src="/Public/images/in.png"></li>
            <li onclick="window.location.href='<?php echo U(userpro);?>'"><img src="/Public/images/pro.png"><p>物业费</p><img src="/Public/images/in.png"></li>
            <li onclick="window.location.href='<?php echo U(msg);?>'"><img src="/Public/images/msg.png"><p>消息</p><img src="/Public/images/in.png"></li>
        </ul>
    </div>

        <!-- <div class="bottom">
            <p>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div> -->
    </div>
    
    <script>
    
    </script>

</body>
<script type="text/javascript">
	
</script>

</html>