<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/Public/home.css">
    <script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/Public/layui/layui.js"></script>
    
</head>

<body>
    <!-- 内容区 -->
    <div class="content content_box">
        <h3 class="header_tip"><img onclick="javascript:;window.history.go(-1)" src="/Public/images/back.png"><span><?php echo ($meta_title); ?></span><img src="/Public/images/la.png"></h3>
        
    <div class="msgdetail">
        <h3><?php echo ($newsdetail["title"]); ?></h3>
        <p class="time">作者：<?php if(empty($newsdetail['author'])): ?>迭名<?php else: echo ($newsdetail["author"]); endif; ?>　　编辑时间：<?php echo ($newsdetail["create_time"]); ?></p>
        <div class="content">
            　　<?php echo ($newsdetail["content"]); ?>
        </div>
    </div>

    </div>
    <div class="nav_bot">
        <ul>
            <li onclick="javascript:;window.location.href='<?php echo U(index);?>'" class="h"><img src="/Public/images/h.png"><p>首页</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(complaint);?>'" class="c"><img src="/Public/images/c.png"><p>我的投诉</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(msg);?>'" class="m"><img src="/Public/images/m.png"><p>消息通知</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(device);?>'" class="f"><img src="/Public/images/f.png"><p>设备报修</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(my);?>'" class="myself"><img src="/Public/images/myself.png"><p>个人中心</p></li>
        </ul>
    </div>
    
    <script>
    </script>

</body>
<script type="text/javascript">

    $(".header_tip").hide();
    var option = "<?php echo ($option); ?>";
    var device = layui.device();
    console.log(option)
    console.log(device)
    if (device.android&&option!="index"&&option!="complaint"&&option!="msg"&&option!="device"&&option!="my") {
        $(".header_tip").show();
    }

    if (option!="index"&&option!="complaint"&&option!="msg"&&option!="device"&&option!="my") {
        $(".nav_bot").hide();
    }else{
        $(".content_box").css("height",$(window).height()-70)
    }

    switch (option) {
        case "index":
            $(".h img").attr("src","/Public/images/s-h.png");
            $(".h p").css("color","#d4237a");
            break;
        case "complaint":
            $(".c img").attr("src","/Public/images/s-c.png");
            $(".c p").css("color","#d4237a");
            break;
        case "msg":
            $(".m img").attr("src","/Public/images/s-m.png");
            $(".m p").css("color","#d4237a");
            break;
        case "device":
            $(".f img").attr("src","/Public/images/s-f.png");
            $(".f p").css("color","#d4237a");
            break;
        case "my":
            $(".myself img").attr("src","/Public/images/s-myself.png");
            $(".myself p").css("color","#d4237a");
            break;
        default:
            $(".h img").attr("src","/Public/images/s-h.png");
            $(".h p").css("color","#d4237a");
            break;
    }

</script>

</html>