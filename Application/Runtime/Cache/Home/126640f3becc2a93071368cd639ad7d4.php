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
        
    <div class="msgdetail">
        <p class="time" style="border-bottom: none;">投诉时间：<?php echo ($complaintdetail["create_time"]); ?></p>
        <p class="time">投诉状态：
            <?php if(($complaintdetail["status"]) == "0"): ?><span style="color: red;">待处理</span>
                <?php else: ?><span style="color: green;">已处理　　</span>处理时间:<?php echo ($complaintdetail["update_time"]); endif; ?>
        </p>
        <div class="content">
            <?php echo ($complaintdetail["content"]); ?>
        </div>
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