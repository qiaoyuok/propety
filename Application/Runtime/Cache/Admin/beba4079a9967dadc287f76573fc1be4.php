<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo ($companyinfo['company_name']); ?>|<?php echo ($meta_title); ?></title>
    <link href="/Public/images/ico.png" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/base.css">
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
    <script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/Public/common.js"></script>
    <script type="text/javascript" src="/Public/layui/layui.js"></script>
    
    <link href="/editor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/editor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/editor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/editor/umeditor.min.js"></script>
    <script type="text/javascript" src="/editor/lang/zh-cn/zh-cn.js"></script>

</head>

<body>
    <!-- 头部 -->
    <div class="header">
        <ul class="main_menu">
            <?php if(is_array($menu_nav)): $i = 0; $__LIST__ = $menu_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["controller"]); ?>_nav" onclick="javascript:;window.location.href='<?php echo U($vo['url']);?>'"><?php echo ($vo["title"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="userbox">
            <img src="/Public/images/avatar/<?php echo ($admininfo['avatarurl']); ?>" onerror="javascript:;this.src='/Public/images/avatar.jpg'">
            <div class="useroption">
                <p>欢迎您：<?php echo ($admininfo['nickname']); ?></p>
                <p class="option edit_option" data-href="<?php echo U('User/adminedit?flag=1&uid='.$admininfo['uid']);?>" data-title="修改昵称">修改昵称</p>
                <p class="option edit_option" data-href="<?php echo U('User/adminedit?flag=2&uid='.$admininfo['uid']);?>" data-title="修改密码">修改密码</p>
                <p class="option edit_option" data-href="<?php echo U('User/adminedit?flag=3&uid='.$admininfo['uid']);?>" data-title="更换头像">更换头像</p>
                <p class="option" id="login_out">退出</p>
            </div>
        </div>
    </div>
    <!-- /头部 -->
    <!-- 边栏 -->
    <div class="sidebar">
        
            <?php if(!empty($menus)): if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo)): $index = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($index % 2 );++$index; if(($index) == "1"): if(!empty($v["group"])): ?><p><?php echo ($v["group"]); ?></p>
                                <?php else: ?>
                                <!-- <hr/> -->
                                <p><?php echo ($v["title"]); ?></p><?php endif; ?>
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/System/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li>
                            <?php else: ?>
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/System/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        
    </div>
    <!-- /边栏 -->
    <!-- 内容区 -->
    <div class="content">
        
    <div class="set">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">新闻标题</label>
                <div class="layui-input-inline">
                    <input type="text" name="title" required lay-verify="required" placeholder="请输入新闻标题" autocomplete="company_name" class="layui-input">
                </div>
                <!-- <div class="layui-form-mid layui-word-aux">填写公司名称会在底部显示</div> -->
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作者</label>
                <div class="layui-input-inline">
                    <input type="text" name="author" placeholder="请输入作者名称" autocomplete="address" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="height:350px;overflow: auto;">
                <label class="layui-form-label">新闻内容</label>
                <div class="layui-input-block">
                    <script type="text/plain" name="content" id="myEditor" style="width:700px;height:340px;">
                        <p>在这里输入新闻内容</p>
                    </script>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="confirm">立即提交</button>
                    <button class="layui-btn layui-btn-primary" onclick="javascript:;window.history.go(-1)">返回</button>
                </div>
            </div>
        </form>
    </div>

        <div class="bottom">
            <p><?php echo ($companyinfo['company_name']); ?>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div>
    </div>
    
   
   <script type="text/javascript">
        //实例化编辑器
        var um = UM.getEditor('myEditor');
    </script>
   
    <script type="text/javascript">
    $(".system_nav").attr("class", "active")
    layui.use(['layer', 'form'], function() {
        var form = layui.form;
        var layer = layui.layer;

        //监听提交
        form.on('submit(confirm)', function(data) {
            // console.log(data.field);return false;
            $.post("/index.php/Admin/System/addnews", data.field, function(res) {

                if (res.status == 1) {
                    layer.msg(res.info, { icon: 1, offset: '70px' });
                    setTimeout(() => {
                        parent.window.location.href = "/index.php/Admin/System/news"
                    }, 1000)
                } else {
                    layer.msg(res.info, { icon: 2, offset: '70px' });
                }
            })
            return false;
        });
    })
    </script>

</body>
<script type="text/javascript">
var controller = '<?php echo ($controller); ?>';

$(".userbox").mousemove(function() {
    $(".useroption").show();
})

$(".userbox").mouseout(function() {
    $(".useroption").hide();
})

var option = "<?php echo $option?>";
$(".menu" + option).attr("class", "active");

$(".sidebar").css("height", ($(window).height() - 100));
$(".content").css("height", ($(window).height() - 100));
$(".content-box").css("height", ($(window).height() - 180));

$("#login_out").click(function() {

    $.post("/index.php/Admin/System/../Login/loginout", "", function(res) {
        location.reload();

    })
})
</script>

</html>