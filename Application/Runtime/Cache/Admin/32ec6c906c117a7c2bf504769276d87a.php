<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>用户登录</title>
    <link href="/Public/images/ico.png" type="image/x-icon" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="/Public/login.css">
	<script type="text/javascript" src="/Public/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css">
	<script type="text/javascript" src="/Public/layui/layui.js"></script>
	<style type="text/css">
		input:-webkit-autofill {
		 -webkit-box-shadow: 0 0 0px 1000px #fff inset;
		 -webkit-text-fill-color: #515151;
		}
	</style>
</head>
<body style="background: url('/Public/images/b.jpg') no-repeat;background-size: 100%;">
	<form class="login" id="form">
		<h3>用户登陆</h3>
		<div class="item">
			<label>用户名：</label>
			<input type="text" name="username" autocomplete="off" id="username">
		</div>
		<div class="item">
			<label>密　码：</label>
			<input type="password" name="password" autocomplete="off" id="password">
		</div>
		<div class="item">
			<label>验证码：</label>
			<input type="text" name="code" id="code">
		</div>
		<div class="code">
			<img class="img_code" src="/index.php/Admin/Login/getCode" onclick="this.src='/index.php/Admin/Login/getCode/a/'+Math.random();"> 	
		</div>
		<div class="controls">
			<p id="confirm">登录</p>
		</div>
	</form>
	<p class="into">小区物业管理系统 2018-2018 Rights</p>
</body>
<script type="text/javascript">
	var username;
	var password;
	var code;
	layui.use('layer', function(){
	  	var layer = layui.layer;
		$("#confirm").click(function(){
			username = $("#username").val();
			password = $("#password").val();
			code = $("#code").val();

	  		if(username==""){
	  			layer.tips('用户名不能为空', '#username', {});
	  			return false;
	  		}
	  		if(password==""){
	  			layer.tips('密码不能为空', '#password', {});
	  			return false;
	  		}
	  		if(code==""){
	  			layer.tips('验证码不能为空', '#code', {});
	  			return false;
	  		}

			$.post("/index.php/Admin/Login/index",$("#form").serialize(),function(res){
				console.log(res)
				if(res.status == 0){
					layer.msg(res.info,{icon:2,offset: '70px'});
					if(res.info == '密码错误' || res.info == '用户不存在或被禁用'){
						$(".img_code").attr({
							src: '/index.php/Admin/Login/getCode/a/'+Math.random(),
						});
					}
				}else if(res.status == 1){
					window.location.href="/index.php/Admin/Login/../Index";
				}
			})
		})			
	  
	  //回车搜索
	$(document).keypress(function(e){
		if(e.keyCode === 13){
			$("#confirm").click();
			return false;
		}
	});
	});              
</script>
</html>