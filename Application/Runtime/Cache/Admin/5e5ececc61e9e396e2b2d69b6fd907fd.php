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
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/System/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li>
                            <?php else: ?>
                            <li><a class="menu<?php echo ($v["option"]); ?>" href="/index.php/Admin/System/../<?php echo ($v["url"]); ?>.html"><?php echo ($v["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        
    </div>
    <!-- /边栏 -->
    <!-- 内容区 -->
    <div class="content">
        
    <div class="content-box">
        <div class="main_option">
            <ul>
                <li id="add">新增</li>
                <!-- <li class="batch" data-href="<?php echo U('del');?>">删除</li> -->
                <?php if(($back) == "1"): ?><li class="back" onclick="javascript:;window.history.back()">返回</li><?php endif; ?>
            </ul>
            <form class="mid layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">所属小区</label>
                <div class="layui-input-block">
                    <select name="village_id" required lay-verify="required" lay-filter='villageselect' class="village">
                        <option value="0">全部</option>
                        <?php if(!empty($villagelists)): if(is_array($villagelists)): $i = 0; $__LIST__ = $villagelists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["id"]) == $village_id): ?><option selected="selected" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                    </select>
                </div>
            </div>
        </form>
        </div>
        <div style="width:100%;padding: 20px; background-color: #F2F2F2;box-sizing: border-box;overflow: auto;">
            <div class="layui-row">
                <?php if(!empty($parklists)): if(is_array($parklists)): $i = 0; $__LIST__ = $parklists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($i%12 == 1 && $i != 1): ?><hr/>
                            <br/><?php endif; ?>
                        <div class="layui-col-md1">
                            <div class="layui-card">
                                <div class="layui-card-header" style="text-align: center;background: #01AAED;color: #fff"><?php echo ($vo["name"]); ?></div>
                                <div class="layui-card-header" style="text-align: center;"><?php echo ($vo["num"]); ?>号停车位</div>
                                <div class="layui-card-body edit_option" data-id="$vo['id']" data-href="<?php echo U('editpark?id='.$vo['id']);?>" data-title="配置停车位" style="text-align: center;">
                                    <img class="car" src="/Public/images/car.png">
                                    <?php if(!empty($vo["uuid"])): ?><b class="carused">使用中</b>
                                        <?php else: ?>
                                        <b class="carempt">暂空</b><?php endif; ?>
                                    <button class="layui-btn layui-btn-sm layui-btn-danger ajax-get" data-href="<?php echo U('delpark?id='.$vo['id']);?>">删除</button>
                                </div>
                            </div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <p style="text-align:center;">列表空空如也！</p><?php endif; ?>
            </div>
        </div>
        <div class="page">
            <?php echo ($_page); ?>
        </div>
    </div>


        <div class="bottom">
            <p><?php echo ($companyinfo['company_name']); ?>小区物业管理系统</p>
            <p>Copy Right-2018</p>
        </div>
    </div>
    
    <script type="text/javascript">
    $(".system_nav").attr("class", "active")
    layui.use(['layer', 'element','form'], function() {
        var lauer = layui.layer;
        var form = layui.form;
        $("#add").click(function() {
            layer.open({
                type: 2,
                title: '添加菜单',
                shadeClose: true,
                shade: [0.5, '#393D49'],
                maxmin: false, //开启最大化最小化按钮
                area: ['550px', '600px'],
                // content: '<?php echo U("add");?>'
                content: '<?php echo U("addpark");?>'
            });
        })

        // 选择了小区，显示出该小区下的幢及该第一幢的所有单元
        form.on('select(villageselect)', function(data) {
            console.log("选择了", data)
            window.location.href="/index.php/Admin/System/park/village_id/"+data.value;
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