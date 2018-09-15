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
        
    <?php if(!empty($orderlist)): ?><div class="orderlist">
            <?php if(is_array($orderlist)): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item">
                    <p class="title">缴费项目：<?php echo ($vo["name"]); ?></p>
                    <p class="des"><?php echo ($vo["des"]); ?></p>
                    <p class="time">缴费时间：<?php echo ($vo["update_time"]); ?></p>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php else: ?>
        <p class="msg">暂无消息</p><?php endif; ?>

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