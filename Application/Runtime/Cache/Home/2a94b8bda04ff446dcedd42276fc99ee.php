<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/Public/home.css">
    <script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/Public/layui/layui.js"></script>
    
    <style type="text/css">
    #test2 div div {
        background: #e6e6e6;
        color: #d4237a;
        overflow: hidden;
    }
    </style>

</head>

<body>
    <!-- 内容区 -->
    <div class="content content_box">
        <h3 class="header_tip"><img onclick="javascript:;window.history.go(-1)" src="/Public/images/back.png"><span><?php echo ($meta_title); ?></span><img src="/Public/images/la.png"></h3>
        
    <div class="layui-carousel" id="test1">
        <div carousel-item>
            <div><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1526469152075&di=c71b6a9ef6fd262dea36158c9bfe90f1&imgtype=0&src=http%3A%2F%2Fpic34.photophoto.cn%2F20150310%2F0017030247988384_b.jpg"></div>
            <div><img src="http://mpic.tiankong.com/114/6cc/1146cc774fb3929f1353ac00cd5932a5/640.jpg@!670w"></div>
            <div><img src="http://img.mp.itc.cn/upload/20170316/9165c892d0af475495c46bf000fb803d_th.jpg"></div>
        </div>
    </div>
    <div class="announce">
        <img src="/Public/images/laba.png">
        <div class="layui-carousel" id="test2">
            <div carousel-item>
                <?php if(!empty($announcelist)): if(is_array($announcelist)): $i = 0; $__LIST__ = $announcelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div onclick="javascript:;window.location.href='/index.php/Home/Index/announcedetail/id/<?php echo ($vo["id"]); ?>'"><?php echo (strlendeal($vo["title"])); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <div>暂无通知</div><?php endif; ?>
            </div>
        </div>
    </div>
    <div class="news">
        <ul>
            <?php if(!empty($newslist)): ?><p style="height: 45px;line-height: 45px;color: #1296db;box-sizing: border-box;padding-left: 15px;font-size: 16px;border-bottom: 1px solid #ddd;">小区新闻</p>
                <?php if(is_array($newslist)): $i = 0; $__LIST__ = $newslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li onclick="javascript:;window.location.href='/index.php/Home/Index/newsdetail/id/<?php echo ($vo["id"]); ?>'"><?php echo (newtitle($vo["title"])); ?><br/><span style="color: gray;"><?php echo ($vo["create_time"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
                <?php else: ?>
                <p>暂无新闻</p><?php endif; ?>
        </ul>
    </div>

    </div>
    <div class="nav_bot">
        <ul>
            <li onclick="javascript:;window.location.href='<?php echo U(index);?>'" class="h"><img src="/Public/images/h.png"><p>首页</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(complaint);?>'" class="c"><img src="/Public/images/c.png"><p>我的投诉</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(msg);?>'" class="m"><img src="/Public/images/m.png"><p>消息通知</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(device);?>'" class="f"><img src="/Public/images/f.png"><p>设备报修</p></li>
            <li onclick="javascript:;window.location.href='<?php echo U(my);?>'" class="myself"><img src="/Public/images/myself.png"><p>个人中心</p></li>
        </ul>
    </div>
    
    <script>
    layui.use('carousel', function() {
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#test1',
            width: '100%' //设置容器宽度
                ,
            arrow: 'always' //始终显示箭头
                //,anim: 'updown' //切换动画方式
                ,
            height: '180px'
        });

        //建造实例
        carousel.render({
            elem: '#test2',
            width: '100%' //设置容器宽度
                ,
            arrow: 'always' //始终显示箭头
                //,anim: 'updown' //切换动画方式
                ,
            height: '20px',
            indicator: 'none',
            arrow: 'none',
            anim: 'updown'
        });
    });
    </script>

</body>
<script type="text/javascript">

    $(".header_tip").hide();
    var option = "<?php echo ($option); ?>";
    var device = layui.device();
    console.log(option)
    console.log(device)
    if (device.android&&option!="index"&&option!="complaint"&&option!="msg"&&option!="device"&&option!="my") {
        $(".header_tip").show();
    }

    if (option!="index"&&option!="complaint"&&option!="msg"&&option!="device"&&option!="my") {
        $(".nav_bot").hide();
    }else{
        $(".content_box").css("height",$(window).height()-70)
    }

    switch (option) {
        case "index":
            $(".h img").attr("src","/Public/images/s-h.png");
            $(".h p").css("color","#d4237a");
            break;
        case "complaint":
            $(".c img").attr("src","/Public/images/s-c.png");
            $(".c p").css("color","#d4237a");
            break;
        case "msg":
            $(".m img").attr("src","/Public/images/s-m.png");
            $(".m p").css("color","#d4237a");
            break;
        case "device":
            $(".f img").attr("src","/Public/images/s-f.png");
            $(".f p").css("color","#d4237a");
            break;
        case "my":
            $(".myself img").attr("src","/Public/images/s-myself.png");
            $(".myself p").css("color","#d4237a");
            break;
        default:
            $(".h img").attr("src","/Public/images/s-h.png");
            $(".h p").css("color","#d4237a");
            break;
    }

</script>

</html>