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
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/Index/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li>
                            <?php else: ?>
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/Index/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        
    </div>
    <!-- /边栏 -->
    <!-- 内容区 -->
    <div class="content">
        
    <div class="intro_box">
        <div style="padding: 20px;">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card" style="height: 262px;margin-top: 52px;border-radius: 15px;">
                        <div class="layui-card-header">物业名称：<?php echo ($companyinfo['company_name']); ?></div>
                        <div class="layui-card-header">物业地址：<?php echo ($companyinfo['company_address']); ?></div>
                        <div class="layui-card-header">负责　人：<?php echo ($companyinfo['company_manager']); ?></div>
                        <div class="layui-card-header">邮　　箱：<?php echo ($companyinfo['company_email']); ?></div>
                        <div class="layui-card-header">联系电话：<?php echo ($companyinfo['company_tel']); ?></div>
                        <div class="layui-card-header">物业介绍：<?php echo ($companyinfo['company_des']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="bottom">
            <p><?php echo ($companyinfo['company_name']); ?>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div>
    </div>
    
    <script type="text/javascript">
    $(".index_nav").attr("class", "active");
    $(".sidebar").hide();
    layui.use("layer",function() {
        var layer = layui.layer;
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

    $.post("/index.php/Admin/Index/../Login/loginout", "", function(res) {
        location.reload();

    })
})
</script>

</html>