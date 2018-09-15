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
    
</head>

<body>
    <!-- 内容区 -->
    <div class="content">
        <h3 class="header_tip"><img onclick="javascript:;window.history.go(-1)" src="/Public/images/back.png"><span><?php echo ($meta_title); ?></span><img src="/Public/images/la.png"></h3>
        
    <div class="addcom_box dplaceholder" contenteditable="true">
    </div>
    <div class="submit">提交设备报修</div>

    </div>
    
    <script>
    layui.use("layer", function() {
        var layer = layui.layer;
        var length = 0;
        var content = '';
        var content1 = '';
        $(".addcom_box").keydown(function(event) {
            content = $(".addcom_box").text();
            content1 = $(".addcom_box").html();
            length = content.length;
            // console.log(length)
            if (length != 0) {
                $(".addcom_box").attr("class", "addcom_box")
            } else {
                $(".addcom_box").attr("class", "addcom_box dplaceholder")
            }
        });

        $(".submit").click(function() {

            if (length < 5) {
                layer.msg("报修内容长度不低于5个字符");
                return false;
            }

            console.log(content)
            console.log(content1)

            $.post("/index.php/Home/Index/adddevice","content="+content,function (res) {
                console.log(res)
                if (res.status == 1) {
                    $(".addcom_box").text("");
                    layer.msg(res.info, { icon: 1, offset: '70px' });
                    setTimeout(()=>{
                        // window.history.go(-1);
                    },1000)
                } else {
                    layer.msg(res.info, { icon: 2, offset: '70px' });
                }
            })
        })
    })
    </script>

</body>
<script type="text/javascript">

        $(".header_tip").hide();
        var option = "<?php echo ($option); ?>";
        var device = layui.device();
        console.log(device)
        if (device.android&&option!="index") {
            $(".header_tip").show();
        }
</script>

</html>