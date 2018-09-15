//dom加载完成后执行的js
;
$(function() {
    //ajax get请求
    $('.ajax-get').click(function(e) {
        // console.log(e);return false;
        var href = e.target.href?e.target.href:e.target.dataset.href;
        console.log(href)
        layer.confirm('确定执行该操作吗？', function(index) {
            //do something
            $.get(href, "", function(res) {
                console.log(res)
                if (res.status == 1) {
                    layer.msg(res.info, { icon: 1, offset: '70px' });
                    setTimeout(() => {
                        location.reload()
                    }, 1000)
                } else {
                    layer.msg(res.info, { icon: 2, offset: '70px' });
                }
            })
            layer.close(index);
        });
        return false;
    });

    // 列表批量操作
    $(".batch").click(function(e) {
        var ids = $(".ids");
        var href = e.currentTarget.dataset.href;
        var id = new Array();
        $.each(ids, function(index, element) {
            if (element.checked) {
                id.push(element.value)
            }
        })
        switch (controller) {
            case "System":
                var field = "id=";
                break;
            case "User":
                var field = "uid=";
                break;
            default:
                var field = "id=";
                break;
        }
        // console.log(id.toString());return false;
        if (id.length > 0) {
            layer.confirm('确定执行该操作吗？', function(index) {
                $.post(href, field + id.toString(), function(res) {
                    if (res.status == 1) {
                        layer.msg(res.info, { icon: 1, offset: '70px' });
                        setTimeout(() => {
                            location.reload()
                        }, 1000)
                    } else {
                        layer.msg(res.info, { icon: 2, offset: '70px' });
                    }
                });
            });
        } else {
            layer.msg("请先选择需要操作的数据", { icon: 2, offset: '70px' });
        }
    })

    $(".edit_option").click(function(e) {
        // console.log(e);return false;
        var href = e.target.dataset.href?e.target.dataset.href:e.currentTarget.dataset.href;
        var title = e.target.dataset.title?e.target.dataset.title:e.currentTarget.dataset.title;
        // console.log(href);return false;
        layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: [0.5, '#393D49'],
            maxmin: false, //开启最大化最小化按钮
            area: ['550px', '600px'],
            // content: '{:U("add")}'
            content: href
        });
        return false;
    })

    //全选的实现
    $(".check-all").click(function() {
        $(".ids").prop("checked", this.checked);
    });
    $(".ids").click(function() {
        var option = $(".ids");
        option.each(function(i) {
            if (!this.checked) {
                $(".check-all").prop("checked", false);
                return false;
            } else {
                $(".check-all").prop("checked", true);
            }
        });
    });

    // 试图查看内容过长而隐藏的内容
    $(".view_content").click(function(e) {
        // console.log(e.target.dataset.content)
        var title = e.target.dataset.title;
        var content = e.target.dataset.content;
        var html = '<div style="min-width:300px;min-height:200px;padding: 10px;border-radius:25px;max-width:500px;max-height:500px;"><h3 style= "width:100%;height:45px;line-height:45px;text-align:center;border-bottom:1px solid #ddd;margin-bottom:10px;"">'+title+'</h3>'+content+'</div>';
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            skin: 'yourclass',
            content: html
        });
    })
    
    // 搜索
    $("#search").click(function(e) {
        var href = e.currentTarget.dataset.href;
        var name = e.currentTarget.dataset.name;
        var keyword = $(".search-input").val();
        
        window.location.href=href+"?"+name+"="+keyword;
    })
})