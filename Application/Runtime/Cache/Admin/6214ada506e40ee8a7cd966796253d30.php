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

    .table_box {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #ddd;
        z-index: 99;
        display: none;
    }

    .layui-table-main {
        height: 418px;
    }
    </style>
</head>

<body>
    <div class="table_box">
        <table class="layui-table" lay-data="{width: 500, url:'/index.php/Admin/User/user', method:'post',page:true,limit:6,limits:[6], id:'idTest'}" lay-filter="demo">
            <thead>
                <tr>
                    <th lay-data="{field:'uid', width:80, sort: true, fixed: true}">ID</th>
                    <th lay-data="{field:'username',align:'center', width:180}">用户姓名</th>
                    <th lay-data="{fixed: 'right', width:236, align:'center', toolbar: '#barDemo'}">操作</th>
                </tr>
            </thead>
        </table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-sm" lay-event="detail">选择</a>
        </script>
    </div>
    <div class="iframe_box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">房间地址</label>
                <div class="layui-input-block">
                    <input type="text" readonly="true" value="<?php echo ($roominfo['name']); ?>小区第<?php echo ($roominfo['build']); ?>幢第<?php echo ($roominfo['unit']); ?>单元<?php echo ($roominfo['room']); ?>室" autocomplete="off" class="layui-input">
                    <input type="text" name="id" hidden value="<?php echo ($roominfo['id']); ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">房间属性</label>
                <div class="layui-input-block">
                    <?php if(($roominfo['attribute']) == "0"): ?><input type="radio" name="attribute" value="0" title="租赁" checked>
                        <input type="radio" name="attribute" value="1" title="房东自住">
                        <?php else: ?>
                        <input type="radio" name="attribute" value="0" title="租赁">
                        <input type="radio" name="attribute" value="1" title="房东自住" checked><?php endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">选择户主</label>
                <div class="layui-input-inline">
                    <input type="text" readonly="true" value="<?php echo ($roominfo['username']); ?>" lay-verify="required" id="username" autocomplete="off" class="layui-input changeuser">
                    <input type="text" name="uid" value="<?php echo ($roominfo['uid']); ?>" id="uid" hidden>
                </div>
                <div class="layui-form-mid layui-word-aux changeuser">点击更换</div>
            </div>
            <?php if(($roominfo['attribute']) == "0"): ?><div class="layui-form-item fee">
                    <?php else: ?>
                    <div class="layui-form-item fee" hidden><?php endif; ?>
            <label class="layui-form-label">租　　金</label>
            <div class="layui-input-inline">
                <input type="text" name="fee" placeholder="请输入租金" required lay-verify="required" value="<?php echo ($roominfo['fee']); ?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">元</div>
            </div>
            <div class="layui-form-item"> 
            <label class="layui-form-label">物业费</label>
            <div class="layui-input-inline">
                <input type="text" name="profee" placeholder="请输入物业费" required lay-verify="required" value="<?php echo ($roominfo['profee']); ?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">元</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                    <button type="button" id="cancel" class="layui-btn layui-btn-primary">取消</button>
                </div>
            </div>
        </form>
        </div>
</body>
<script type="text/javascript">
//Demo
layui.use(['form', 'layer', 'table', 'element'], function() {
    var form = layui.form;
    var layer = layui.layer;
    var table = layui.table;
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    table.render({ //其它参数在此省略
        height: 315 //固定值
    });
    //监听提交
    form.on('submit(submit)', function(data) {
        console.log(data.field);
        $.post("/index.php/Admin/System/editroom", data.field, function(res) {
            console.log(res)
            if (res.status == 1) {
                layer.msg(res.info, { icon: 1, offset: '70px' });
                setTimeout(() => {
                    parent.layer.close(index); //再执行关闭     
                }, 1000)
            } else {
                layer.msg(res.info, { icon: 2, offset: '70px' });
            }
        })
        return false;
    });

    $(".changeuser").click(function(e) {
        console.log(e)
        $(".table_box").show();
        $(".table_box").css("display", "flex")
        $(".table_box").css("justify-content", "center")
    });

    form.on('radio', function(e) {

        console.log(e)
        if (e.value == 0) {
            $(".fee").show();
        } else {
            $(".fee").hide();
        }

    });

    //监听工具条
    table.on('tool(demo)', function(obj) {
        console.log(obj)
        var data = obj.data;
        if (obj.event === 'detail') {
            layer.msg('选择了' + data.username);
            $("#username").attr("value", data.username);
            $("#uid").attr("value", data.uid);
            $(".table_box").hide();
        }
    });

    $("#cancel").click(function() {
        parent.layer.close(index); //再执行关闭     
    });
    $('.demoTable .layui-btn').on('click', function() {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

});
</script>

</html>