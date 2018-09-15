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
                <label class="layui-form-label">选择类型</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="1" title="幢" checked="">
                    <input type="radio" name="sex" value="2" title="单元">
                    <input type="radio" name="sex" value="3" title="室">
                    <input type="text" id="parent_id" name="parent_id" value="0" hidden>
                    <input type="text" id="flag" name="flag" value="1" hidden>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属小区</label>
                <div class="layui-input-block">
                    <select name="village_id" required lay-verify="required" lay-filter='villageselect' class="village">
                        <?php if(!empty($villagelists)): if(is_array($villagelists)): $i = 0; $__LIST__ = $villagelists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" style="display: none;" id="build">
                <label class="layui-form-label">所属第几幢</label>
                <div class="layui-input-block">
                    <select required lay-verify="required" lay-filter='buildselect' class="build">
                        <!--  <?php if(!empty($roomlists)): if(is_array($roomlists)): $i = 0; $__LIST__ = $roomlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["parent_id"]) == "0"): ?>-->
                        <option value="<?php echo ($vo["id"]); ?>">第<?php echo ($vo["room"]); ?>幢</option>
                        <!--<?php endif; endforeach; endif; else: echo "" ;endif; endif; ?> -->
                    </select>
                </div>
            </div>
            <div class="layui-form-item" style="display: none;" id="unit">
                <label class="layui-form-label">所属单元</label>
                <div class="layui-input-block">
                    <select required lay-verify="required" lay-filter='unitselect' class="unit">
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" id='labeltext'>第几幢</label>
                <div class="layui-input-inline">
                    <input type="text" name="room" required id="inputplacehoder" lay-verify="required" placeholder="请输入第几幢" autocomplete="off" class="layui-input">
                </div>
                <!-- <div class="layui-form-mid layui-word-aux">降序显示</div> -->
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
    var flag = 1;
    var village_id = $(".village").val();
    var roomlists = <?php echo !empty($roomlists)?json_encode($roomlists):"null"?>;
    // //console.log(roomlists);
    //监听提交
    form.on('submit(submit)', function(data) {
        console.log(data.field);
        // return false;
        $.post("/index.php/admin/system/addroom", data.field, function(res) {
            //console.log(res);
            if (res.status == 1) {
                layer.msg(res.info, { icon: 1, offset: '70px' });
                setTimeout(() => {
                    parent.window.location.href = "/index.php/admin/system/house"
                }, 1000)
            } else {
                layer.msg(res.info, { icon: 2, offset: '70px' });
            }
        })
        return false;
    });

    form.on('radio', function(e) {
        flag = Number(e.value);
        switch (flag) {
            case 1:
                $("#build").hide();
                $("#unit").hide();
                $("#labeltext").html("第几幢");
                $("#inputplacehoder").attr("placeholder", "请输入第几幢");
                $("#flag").attr("value", 1);
                village_id = $(".village").val();
                $("#parent_id").attr("value", village_id);
                console.log("当前的父级是小区,id号是：",village_id)
                break;
            case 2:
                $("#build").show();
                $("#unit").hide();
                $("#labeltext").html("第几单元")
                $("#inputplacehoder").attr("placeholder", "请输入第几单元");
                $("#flag").attr("value", 2);
                village_id = $(".village").val();
                console.log("当前小区：",village_id)
                getbuild(village_id)
                //console.log($(".build").children())
                if ($(".build").children().length != 0) {
                    parent_id = $(".build").val()
                    console.log("当前的父级是楼幢,id号是：",parent_id,"所属小区ID号是：",village_id)
                    $("#parent_id").attr("value", parent_id);
                }
                break;
            case 3:
                $("#build").show();
                $("#unit").show();
                $("#labeltext").html("房间号")
                $("#inputplacehoder").attr("placeholder", "请输入房间号");
                $("#flag").attr("value", 3);
                village_id = $(".village").val();
                getbuild(village_id)
                if ($(".build").children().length != 0) {
                    var build_id = $(".build").val();
                    //console.log("当前小区ID号", village_id)
                    //console.log("当前小幢ID号", parent_id)
                    select(build_id, village_id);
                    // //console.log("此时的单元族元素",$(".unit").children())
                }
                break;
            default:
                $("#build").hide();
                $("#unit").hide();
                $("#labeltext").html("第几幢")
                $("#flag").attr("value", 1);
                break;
        }
    });

    // 选择了小区，显示出该小区下的幢及该第一幢的所有单元
    form.on('select(villageselect)', function(data) {
        //console.log("选择了", data)
        clearbuild();
        clearunit();
        village_id = data.value;
        getbuild(village_id)
        parent_id = $(".build").val()
        switch (flag) {
            case 1:
                $("#parent_id").attr("value", 0);
                console.log("当前的父级是小区,id号是：",village_id)
                break;
            case 2:
                $("#parent_id").attr("value", parent_id);
                console.log("当前的父级是楼幢,id号是：",parent_id,"所属小区ID号是：",village_id)
                break;
            
            default:
                // statements_def
                break;
        }
        
    });

    function clearbuild() {
        
        var children = $(".build").children();
        if (children.length > 0) {
            for (var i = children.length - 1; i >= 0; i--) {
                children[i].remove();
            }
        }

    }

    function clearunit() {
        
        var children = $(".unit").children();
        if (children.length > 0) {
            for (var i = children.length - 1; i >= 0; i--) {
                children[i].remove();
            }
        }

    }

    // 选择了幢
    form.on('select(buildselect)', function(data) {
        //console.log("选择了", data)
        clearunit();
        var parent_id = data.value;
        $("#parent_id").attr("value", parent_id);
        // 当改变幢的时候获取当前小区
        village_id = $(".village").val();
        //console.log(village_id)
        select(parent_id, village_id);
    });

    // 选择了单元
    form.on('select(unitselect)', function(data) {
        //console.log("选择了", data)
        $("#parent_id").attr("value", data.value);
    });

    // 显示该幢楼下的所有单元
    function select(build_id = '', village_id = '') {
        
        // //console.log("请过之后",$(".unit").children());
        $.each(roomlists, function(index, element) {
            if (element.parent_id == build_id && village_id == element.village_id) {
                $(".unit").append('<option value="' + element.id + '">第' + element.room + '单元</option>')
            }
        })
        form.render('select');
        if (flag == 3) {
            if ($(".unit").children().length > 0) {
                var value = $(".unit").val()
                $("#parent_id").attr("value", value);
            }
        }
    }

    // 显示该小区下的所有幢楼
    function getbuild(village_id = '') {
        
        // //console.log("请过之后",$(".unit").children());
        var num = 1;
        $.each(roomlists, function(index, element) {
            //console.log(index)
            if (element.village_id == village_id && element.parent_id == 0) {
                $(".build").append('<option value="' + element.id + '">第' + element.room + '幢</option>')
                if (num == 1) {
                    //console.log("走了吗")
                    select(element.id, village_id);
                }
                num++;
            }
        })
        form.render('select');
    }
});
</script>

</html>