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
        
    <?php if(!empty($parklist)): ?><div class="parklist">
            <?php if(is_array($parklist)): $i = 0; $__LIST__ = $parklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i%2 == 0): ?><div class="item">
                        <?php else: ?>
                        <div class="item line"><?php endif; ?>
                    <img class="car" src="/Public/images/usercar.png">
                    <div class="info">
                        <p>停车位号：<?php echo ($vo["num"]); ?>号</p>
                        <p>车位属性：<?php if(($vo["status"]) == "0"): ?>租赁<?php else: ?>个人车位<?php endif; ?></p>
                        <?php if(($vo["status eq 0"]) == ""): ?><p>车位状态：<?php if(($vo["feestatus"]) == "1"): ?><span style="color: green;">完成缴费</span><span style="font-size: 12px;color: gray;margin-left: 5px;"><?php echo ($vo["last_pay_time"]); ?></span>
                                <?php else: ?>
                                <span style="color: red;">等待缴费</span><br/><b style="color: red;">￥<?php echo ($vo["fee"]); ?></b>
                                <button class="layui-btn layui-btn-sm" style="height: 20px;line-height:20px;margin-left: 5px;">缴费</button><?php endif; ?></p><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php else: ?>
        <p class="msg">暂无车位信息</p><?php endif; ?>

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