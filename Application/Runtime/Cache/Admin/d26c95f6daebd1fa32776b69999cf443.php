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
                <label class="layui-form-label">菜单名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required lay-verify="required" value="<?php echo ($menuinfo['title']); ?>" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
                    <input type="text" name="id" hidden value="<?php echo ($menuinfo['id']); ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排　　序</label>
                <div class="layui-input-inline">
                    <input type="text" name="sort" required lay-verify="required" value="<?php echo ($menuinfo['sort']); ?>" placeholder="请输入排序序号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">降序显示</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">菜单地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="url" required lay-verify="required" value="<?php echo ($menuinfo['url']); ?>" placeholder="菜单链接地址" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">如（User/index）</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上级菜单</label>
                <div class="layui-input-block">
                    <select name="parent_id" lay-verify="required">
                        <option value="0">顶级菜单</option>
                        <?php if(is_array($menulists)): $i = 0; $__LIST__ = $menulists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["id"]) == $menuinfo['parent_id']): ?><option selected="selected" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分　　组</label>
                <div class="layui-input-inline">
                    <input type="text" name="group" placeholder="分组名称" value="<?php echo ($menuinfo['group']); ?>" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">如（用户管理）</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否隐藏</label>
                <div class="layui-input-block">
                    <?php if(($menuinfo["hide"]) == "0"): ?><input type="checkbox" name="hide" value="1" lay-skin="switch" lay-text="是|否">
                        <?php else: ?>
                        <input type="checkbox" name="hide" checked="checked" value="1" lay-skin="switch" lay-text="是|否"><?php endif; ?>
                </div>
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
layui.use(['form', 'layer'], function() {
    var form = layui.form;
    var layer = layui.layer;
    //监听提交
    form.on('submit(submit)', function(data) {
        console.log(data.field);
        $.post("/index.php/Admin/System/edit", data.field, function(res) {
            console.log(res)
            if (res.status == 1) {
                layer.msg(res.info, { icon: 1, offset: '70px' });
                setTimeout(() => {
                    parent.window.location.href = "/index.php/Admin/System/"
                }, 1000)
            } else {
                layer.msg(res.info, { icon: 2, offset: '70px' });
            }
        })
        return false;
    });
});
</script>

</html>