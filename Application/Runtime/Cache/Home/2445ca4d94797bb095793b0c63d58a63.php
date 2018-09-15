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
    
    <style type="text/css">
    .checkuserinfo .layui-input-inline {
        max-width: 200px;
    }
    </style>

</head>

<body>
    <!-- 内容区 -->
    <div class="content">
        
    <?php if(!empty($rentlist)): ?><div class="homelist">
            <?php if(is_array($rentlist)): $i = 0; $__LIST__ = $rentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item">
                    <img class="house" src="/Public/images/house.png">
                    <div class="info">
                        <p>房间信息：<?php echo ($vo["build"]); ?>幢<?php echo ($vo["unit"]); ?>单元<?php echo ($vo["room"]); ?>室</p>
                        <p>房屋属性：
                            <?php if(($vo["status"]) == "0"): ?>租赁
                                <?php else: ?>房东自住<?php endif; ?>
                        </p>
                        <p>租房状态：
                            <?php if(($vo["rfeestatus"]) == "1"): ?><span style="color: green;">完成缴费</span><span style="font-size: 12px;color: gray;margin-left: 5px;"><?php echo ($vo["rlast_pay_time"]); ?></span>
                                <?php else: ?><span style="color: red;">等待缴费</span><b style="color: red;">￥<?php echo ($vo["rfee"]); ?></b>
                                <button class="layui-btn layui-btn-sm" style="height: 20px;line-height:20px;margin-left: 5px;">缴费</button><?php endif; ?>
                            
                        </p>
                        <p>物业费：<?php if(($vo["pofeestatus"]) == "1"): ?><span style="color: green;">完成缴费</span><span style="font-size: 12px;color: gray;margin-left: 5px;"><?php echo ($vo["polast_pay_time"]); ?></span><?php else: ?><span style="color: red;">等待缴费</span><b style="color: red;">￥<?php echo ($vo["pofee"]); ?></b>
                            <button class="layui-btn layui-btn-sm" style="height: 20px;line-height:20px;margin-left: 5px;">缴费</button><?php endif; ?>
                        </p>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php else: ?>
        <p class="msg">暂无租房信息</p><?php endif; ?>

        <!-- <div class="bottom">
            <p>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div> -->
    </div>
    
    <script>
    layui.use('form', function() {
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function(data) {
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });
    </script>

</body>
<script type="text/javascript">
	
</script>

</html>