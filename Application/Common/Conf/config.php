<?php
return array(
	//'配置项'=>'配置值'
	//开启路由并配置
	'URL_ROUTER_ON'   => true, 
	'URL_ROUTE_RULES'=>array(
	    // 'login' => "Login/index",
	),
	// 'SHOW_PAGE_TRACE'   =>  true,
	'HTML_CACHE_ON'		=>true,
	'HTML_CACHE_TIME'   =>    3600,
	'HTML_FILE_SUFFIX'  =>    '.html',

	/* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'property', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 's13166956607',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'pro_', // 数据库表前缀
);