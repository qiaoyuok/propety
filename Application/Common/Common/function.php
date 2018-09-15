<?php

/**
 * 字符串长度处理
 * @param  string $str [待处理字符串]
 * @return [type]      [description]
 */
function strdeal($str=''){
	
	if (empty($str)) {
		return "无";
	}
	
	if(mb_strlen($str)>15){
		$str = mb_substr($str,0,15,"utf-8");
		return $str."...";
	}else{
		return $str;
	}
	
}

/**
 * 字符串长度处理
 * @param  string $str [待处理字符串]
 * @return [type]      [description]
 */
function strlendeal($str=''){
	
	if (empty($str)) {
		return "无";
	}
	
	if(mb_strlen($str,"utf-8")>25){
		$str = mb_substr($str,0,25,"utf-8");
		return $str."...";
	}else{
		return $str;
	}
	
}

/**
 * 字符串长度处理
 * @param  string $str [待处理字符串]
 * @return [type]      [description]
 */
function newtitle($str=''){
	
	if (empty($str)) {
		return "无";
	}
	
	if(mb_strlen($str,"utf-8")>20){
		$str = mb_substr($str,0,20,"utf-8");
		return $str."...";
	}else{
		return $str;
	}
	
}

/**
 * 字符串长度处理
 * @param  string $str [待处理字符串]
 * @return [type]      [description]
 */
function strtime($str=''){
	
	return substr($str,0,10);
}
?>
