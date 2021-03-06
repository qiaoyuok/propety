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
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/User/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li>
                            <?php else: ?>
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/User/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        
    </div>
    <!-- /边栏 -->
    <!-- 内容区 -->
    <div class="content">
        
    <div class="main_option">
        <ul>
            <li class="batch" data-href="<?php echo U('todark');?>">拉黑</li>
            <li class="batch" data-href="<?php echo U('help');?>">解救</li>
            <li class="batch" data-href="<?php echo U('deluser');?>">删除</li>
            <?php if(($back) == "1"): ?><li class="back" onclick="javascript:;window.history.back()">返回</li><?php endif; ?>
        </ul>
        <div class="search">
            <input type="text" name="nickname" class="search-input" value="<?php echo I('nickname');?>" placeholder="请输入用户昵称或姓名">
            <button id="search" data-href="<?php echo U('user');?>" data-name="nickname">搜索</button>
        </div>
    </div>
    <div class="content_list">
        <table>
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="check-all">序号</th>
                        <th>用户昵称</th>
                    <th>用户头像</th>
                    
                    <th>用户姓名</th>
                    <th>手机号</th>
                    <th>用户性别</th>
                    <th>状态</th>
                    <th>添加时间</th>
                    <th>上次修改时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($userlists)): if(is_array($userlists)): $i = 0; $__LIST__ = $userlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i%2 == 0): ?><tr>
                                <?php else: ?>
                                <tr class="addback"><?php endif; ?>
                        <td>
                            <input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["uid"]); ?>"><?php echo ($i); ?></td>
                            <td><?php echo ($vo["nickname"]); ?></td>
                        <td><img style="width: 35px;height: 35px;border-radius: 50%;" src="<?php echo ($vo["headimgurl"]); ?>"></td>
                        
                        <td><?php echo ($vo["username"]); ?></td>
                        <td><?php echo ($vo["tel"]); ?></td>
                        <td>
                            <?php if(($vo["sex"]) == "1"): ?>男
                                <?php else: ?>女<?php endif; ?>
                        </td>
                        <td>
                            <?php if($vo["status"] == 1): ?><b style="color:#d4237a">待认证</b>
                                <?php elseif($vo["status"] == 2): ?><b style="color: green;">已认证</b>
                                <?php else: ?><b style="color: red;">已拉黑</b><?php endif; ?>
                        </td>
                        <td><?php echo ($vo["create_time"]); ?></td>
                        <td><?php echo ($vo["update_time"]); ?></td>
                        <td>
                            <?php if($vo["status"] == 1): ?><a href="/index.php/Admin/User/pass/uid/<?php echo ($vo["uid"]); ?>" class="confirm ajax-get">通过认证</a>
                                <?php elseif($vo["status"] == 0): ?>
                                <a href="/index.php/Admin/User/help/uid/<?php echo ($vo["uid"]); ?>" class="confirm ajax-get">解救</a>
                                <?php else: ?>
                                <a href="/index.php/Admin/User/todark/uid/<?php echo ($vo["uid"]); ?>" class="confirm ajax-get">拉黑</a><?php endif; ?>
                            <span class="edit_option" data-href="<?php echo U('edituser?uid='.$vo['uid']);?>" data-title="编辑用户">编辑</span>
                            <a href="/index.php/Admin/User/deluser/uid/<?php echo ($vo["uid"]); ?>" class="confirm ajax-get">删除</a>
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <td colspan="9" class="list_notice">列表空空如也！</td><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="page">
            <?php echo ($_page); ?>
        </div>

        <div class="bottom">
            <p><?php echo ($companyinfo['company_name']); ?>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div>
    </div>
    
    <script type="text/javascript">
    $(".user_nav").attr("class", "active")
    layui.use('layer', function() {
        var lauer = layui.layer;
        $("#add").click(function() {
            layer.open({
                type: 2,
                title: '添加管理员',
                shadeClose: true,
                shade: [0.5, '#393D49'],
                maxmin: false, //开启最大化最小化按钮
                area: ['550px', '600px'],
                // content: '<?php echo U("add");?>'
                content: '<?php echo U("adminadd");?>'
            });
        })
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

    $.post("/index.php/Admin/User/../Login/loginout", "", function(res) {
        location.reload();

    })
})
</script>

</html>