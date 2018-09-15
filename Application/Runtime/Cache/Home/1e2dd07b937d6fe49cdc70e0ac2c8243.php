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
        
    <?php if(!empty($devicelist)): ?><div class="complaintlist">
            <?php if(is_array($devicelist)): $i = 0; $__LIST__ = $devicelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item" onclick="javascript:;window.location.href='/index.php/Home/Index/devicedetail/id/<?php echo ($vo["id"]); ?>'">
                    <div class="info">
                        <p class="content"><?php echo ($vo["content"]); ?> </p>
                        <p class="time"><?php echo ($vo["create_time"]); ?></p>
                    </div>
                    <div class="status">
                        <?php if(($vo["status"]) == "0"): ?><span style="color: red;">待处理</span>
                            <?php else: ?>
                            <span style="color: green;">已处理</span><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php else: ?>
        <p class="msg">你还设备报修记录</p><?php endif; ?>
    <div class="addcom" onclick="javascript:;window.location.href='<?php echo U(adddevice);?>'">
        我要报修设备
    </div>

        <!-- <div class="bottom">
            <p>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div> -->
    </div>
    
    <script>
    // console.log($(window).height());
    $(".complaintlist").css("height", $(window).height() - 60);
    </script>

</body>
<script type="text/javascript">
	
</script>

</html>