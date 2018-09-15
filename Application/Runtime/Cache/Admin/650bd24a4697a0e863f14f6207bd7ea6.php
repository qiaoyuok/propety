<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>添加菜单</title>
    <link rel="stylesheet" type="text/css" href="/Public/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
    <script type="text/javascript" src="/Public/layui/layui.js"></script>
    <script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
    <style type="text/css">
    .layui-input-inline,
    .layui-input-block {
        width: 400px;
    }
    </style>
</head>

<body>
    <div class="iframe_box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">用户　名</label>
                <div class="layui-input-block">
                    <input type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">昵　　称</label>
                <div class="layui-input-block">
                    <input type="text" name="nickname" placeholder="请输入昵称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密　　码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">不低于6位字符</div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="repassword" required lay-verify="required" placeholder="请输入确认密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">不低于6位字符</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript">
//Demo
layui.use(['form','layer'], function() {
    var form = layui.form;
    var layer = layui.layer;
    //监听提交
    form.on('submit(submit)', function(data) {
        console.log(data.field);
        $.post("/index.php/Admin/User/adminadd", data.field, function (res) {
        	console.log(res)
        	if(res.status == 1){
        		layer.msg(res.info,{icon:1,offset: '70px'});
        		setTimeout(()=>{
        			parent.window.location.href="/index.php/Admin/User/"
        		},1000)
        	}else{
        		layer.msg(res.info,{icon:2,offset: '70px'});
        	}
        })
        return false;
    });
});
</script>

</html>