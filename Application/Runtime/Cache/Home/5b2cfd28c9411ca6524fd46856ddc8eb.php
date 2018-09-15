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
        
    <?php if(!empty($msglist)): ?><div class="msglist">
            <?php if(is_array($msglist)): $i = 0; $__LIST__ = $msglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item" onclick="javascript:;window.location.href='/index.php/Home/Index/msgdetail/id/<?php echo ($vo["id"]); ?>'">
                    <p class="title"><?php echo ($vo["title"]); ?>：<span><?php echo (strdeal($vo["content"])); ?></span></p>
                    <p class="time"><?php echo ($vo["create_time"]); ?></p>
                    <?php if(($vo["status"]) == "0"): ?><img src="/Public/images/new.png"><?php endif; ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php else: ?>
        <p class="msg">暂无消息</p><?php endif; ?>

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