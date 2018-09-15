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
    <div class="content">
        <h3 class="header_tip"><img onclick="javascript:;window.history.go(-1)" src="/Public/images/back.png"><span><?php echo ($meta_title); ?></span><img src="/Public/images/la.png"></h3>
        
    <div class="aboutbox">
        <div class="logo">
            <img src="/Public/images/logo.png">
        </div>
        <ul class="aboutlist">
            <li>物业名称：<span><?php echo ($_SESSION['company']['company_name']); ?></span></li>
            <li>物业地址：<span><?php echo ($_SESSION['company']['company_address']); ?></span></li>
            <li>负责　人：<span><?php echo ($_SESSION['company']['company_manager']); ?></span></li>
            <li>物业邮箱：<span><?php echo ($_SESSION['company']['company_email']); ?></span></li>
            <li>物业电话：<span><?php echo ($_SESSION['company']['company_tel']); ?></span></li>
        </ul>
    </div>

    </div>
    
    <script>
    </script>

</body>
<script type="text/javascript">

        $(".header_tip").hide();
        var option = "<?php echo ($option); ?>";
        var device = layui.device();
        console.log(device)
        if (device.android&&option!="index") {
            $(".header_tip").show();
        }
</script>

</html>