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
                <label class="layui-form-label">用户姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="username" readonly="true" required lay-verify="required" value="<?php echo ($feedetail['username']); ?>" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
                    <input type="text" name="id" hidden value="<?php echo ($feedetail['id']); ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="username" readonly="true" required lay-verify="required" value="<?php echo ($feedetail['tel']); ?>" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
                    <input type="text" name="id" hidden value="<?php echo ($feedetail['id']); ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">房屋租金</label>
                <div class="layui-input-block">
                    <input type="text" name="rfee" required lay-verify="required" readonly="true" value="<?php echo ($feedetail['rfee']); ?>" placeholder="请输入排序序号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-input-block" style="margin-top: 15px;">
                    <div class="layui-form-mid layui-word-aux">缴费记录：
                        <?php if($feedetail["rstatus"] == 1): ?><b>房东自住,无需缴费</b>
                            <?php else: ?>
                            <?php if($feedetail["rfeestatus"] == -1): ?><b style="color: red">暂无缴费记录</b>
                                <?php else: ?> 上次缴费时间：<?php echo ($feedetail["rlast_pay_time"]); endif; endif; ?>
                    </div>
                    <hr/>
                    <hr/>
                    <div class="layui-form-mid layui-word-aux">缴费状态：
                        <?php if(($feedetail["rstatus"]) == "1"): ?><b>无需缴费</b>
                            <?php else: ?>
                            <?php if(($feedetail["rfeestatus"]) == "1"): ?><b style="color: green">已完成缴费</b>
                                <?php else: ?>
                                <b style="color: red">等待缴费</b><span data-title="房租催收" data-uid="<?php echo ($feedetail["uid"]); ?>" data-content="亲爱的租客，您本月尚有未缴纳房租，请及时缴纳；" data-num="房间号<?php echo ($feedetail["room"]); ?>" style="background: #009688;color: #fff;margin-left: 10px;padding: 5px;border-radius: 3px;cursor: pointer;" class="sendmsg">发送通知</span><?php endif; endif; ?>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">物业费</label>
                <div class="layui-input-block">
                    <input type="text" name="pofee" required lay-verify="required" readonly="true" value="<?php echo ($feedetail['pofee']); ?>" placeholder="请输入排序序号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-input-block" style="margin-top: 15px;">
                    <div class="layui-form-mid layui-word-aux">缴费记录：
                        <?php if($feedetail["pofeestatus"] == -1): ?><b style="color: red">暂无缴费记录</b>
                            <?php else: ?> 上次缴费时间：<?php echo ($feedetail["polast_pay_time"]); endif; ?>
                    </div>
                    <hr/>
                    <hr/>
                    <div class="layui-form-mid layui-word-aux">缴费状态：
                        <?php if(($feedetail["pofeestatus"]) == "1"): ?><b style="color: green">已完成缴费</b>
                            <?php else: ?><b style="color: red">等待缴费</b><span style="background: #009688;color: #fff;margin-left: 10px;padding: 5px;border-radius: 3px;cursor: pointer;" data-title="物业催收" data-uid="<?php echo ($feedetail["uid"]); ?>" data-content="亲爱的租客，您本月尚有未缴纳的物业费，请及时缴纳；" data-num="房间号<?php echo ($feedetail["room"]); ?>" class="sendmsg">发送通知</span><?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript">
//Demo
layui.use(['form', 'layer'], function() {
    var form = layui.form;
    var layer = layui.layer;
    //监听提交
    form.on('submit(submit)', function(data) {
        console.log(data.field);
        $.post("/index.php/Admin/Fee/edit", data.field, function(res) {
            console.log(res)
            if (res.status == 1) {
                layer.msg(res.info, { icon: 1, offset: '70px' });
                setTimeout(() => {
                    parent.window.location.href = "/index.php/Admin/Fee/"
                }, 1000)
            } else {
                layer.msg(res.info, { icon: 2, offset: '70px' });
            }
        })
        return false;
    });

    $(".sendmsg").click(function(e) {
        // console.log(e)
        var title = e.currentTarget.dataset.title;
        var content = e.currentTarget.dataset.content;
        var num = e.currentTarget.dataset.num;
        var uid = e.currentTarget.dataset.uid;
        $.post("/index.php/Admin/Fee/sendmsg", "title=" + title + "&content=" + content + "&num=" + num + "&uid=" + uid, function(res) {
            console.log(res)
            if (res.status == 1) {
                layer.msg(res.info, { icon: 1, offset: '70px' });
            } else {
                layer.msg(res.info, { icon: 2, offset: '70px' });
            }
        })
    });

});
</script>

</html>