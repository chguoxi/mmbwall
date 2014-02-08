<?php
/**
 * 判断用户是否已登录
 */
function is_login(){
	$ci = &get_instance();
	return $ci->session->userdata('uid')?true:false;
}

/**
 * 過濾html寬度和高度
 * @param string $str
 */
function rm_style($str){
	$pattern[1] = '/style=".*?"/i';
	$pattern[2] = '/style=\s*\'.*?\'/i';
	$pattern[3] = '/width="[\d]+"/i';
	$pattern[4] = '/height=\s*"[\d]+"/i';
	$pattern[5] = '/width=\s*\'[\d]+\'"/i';
	$pattern[6] = '/height=\s*\'[\d]+\'/i';
	$pattern[7] = '/width=\s*[\d]+/i';
	$pattern[8] = '/height=\s[\d]+/i';
	return preg_replace($pattern, '', $str);
}