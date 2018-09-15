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
        .checkuserinfo .layui-input-inline{
            max-width: 200px;
        }
    </style>

</head>

<body>
    <!-- 内容区 -->
    <div class="content">
        
    <form class="layui-form checkuserinfo" action="">
        <div class="item">
            <label>姓名</label>
            <div>
                <input type="text" name="username" required lay-verify="required" placeholder="请输入真实姓名" autocomplete="off">
            </div>
        </div>
        <div class="item">
            <label>手机</label>
            <div>
                <input type="text" name="tel" required lay-verify="required" placeholder="请输入手机号" autocomplete="off">
            </div>
        </div>
        <div class="item button">
            <button class="layui-btn" lay-submit lay-filter="formDemo">提交信息</button>
        </div>
    </form>

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
            console.log(data.field);
            $.post("/index.php/Home/Index/checkuserinfo",data.field,function (res) {
                
                console.log(res)
            })
            return false;
        });
    });
    </script>

</body>
<script type="text/javascript">
	
</script>

</html>