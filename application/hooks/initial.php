<?php
/**
 * 初始化APP
 * 初始化数据库,语系
 */
class Initial {
	public $css_path;
	public $script_path;
	public $image_path;
	public $lang;
	public $database;
	public $config;

	public function init(){
		$domain = str_replace('.tf', '', $_SERVER['HTTP_HOST']);
		//var_dump(preg_match('/ledinside(\.com){0,1}\.tw$/i', $domain));
		if ( preg_match('/healthworld\.cn$/i', $domain) ) {
			define('SITE_LANG','zh-cn');
		}
		elseif (preg_match('/healthworld(\.com){0,1}\.tw$/i', $domain)){
			define('SITE_LANG','zh-tw');
		}
		else{
			define('SITE_LANG','english');
		}
		//导入语系配置
		$this->config = new CI_Config();
		$this->config->load(SITE_LANG.'/config');
		$this->config->load(SITE_LANG.'/api');
		
	}
}