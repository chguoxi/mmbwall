<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 扩展控制器
 */
class LED_Controller extends CI_Controller {
	/**
	 * 视图文件路径
	 * @var string
	 */
	public $view_path;
	
	/**
	 * 静态文件路径
	 * @var string
	 */
	public $theme_path;
	
	/**
	 * 公共静态文件路径
	 * 静态文件是分语系存放的,公共静态文件路径存放所有语系共用的静态文件
	 * @var string
	 */
	public $common_theme_path;
	
	/**
	 * 页面标题
	 * @var string
	 */
	public $pagename='';
	
	/**
	 * 网页meta
	 * @var arra
	 */
	public $meta = array();
	
	/**
	 * 页面变量
	 * @var array
	 */
	public $data = array();
	
	/**
	 * 页面css文件
	 * @var array
	 */
	public $stylesheet = array();
	
	/**
	 * 页面js文件
	 * @var array
	 */
	public $script = array();
	
	public function __construct(){
		parent::__construct();
		$this->view_path          = $this->config->item('view_path');
		$this->theme_path         = $this->config->item('theme_path');
		$this->common_theme_path  = $this->config->item('common_theme_path');
		$this->data['view_path']         = $this->view_path;
		$this->data['theme_path']        = $this->theme_path;
		$this->data['common_theme_path'] = $this->common_theme_path;
		//自动加载语言文件
		if (is_file(str_replace(
				'\\', '/', APPPATH.'language/'.SITE_LANG.'/'
				.strtolower(get_class($this)).'_lang.php'))) {
			$this->lang->load(strtolower(get_class($this)));
		}
	}
	
	/**
	 * 设置视图文件路径
	 * @param string $view_path
	 */	
	public function set_view_path($view_path){
		$this->view_path = $view_path;
	}
	
	/**
	 * 添加css文件
	 * @param string $key 给css起一个唯一标识，方便删除
	 * @param string $file css路径
	 * @param string $base_path 重新定义开始检索目录
	 */
	public function add_stylesheet($key,$file,$base_path=NULL){
		if ($base_path==NULL){
			$this->common_theme_path.'/css';
		}
		if ($key==''){
			$key = NULL;
		}
		if ( is_file($base_path.'/'.$file)){
			$this->stylesheet[$key] = $base_path.'/'.$file;
		}
	}
	
	/**
	 * 添加js文件
	 * @param string $key 给js起一个唯一标识，方便删除
	 * @param string $file 相对路径和文件名
	 * @param string $base_path 重新定义开始检索目录
	 */	
	public function add_script($key,$file,$base_path=NULL){
		if ($base_path==NULL){
			$this->common_theme_path.'/js';
		}
		if ($key==''){
			$key = NULL;
		}
		if ( is_file($base_path.'/'.$file)){
			$this->stylesheet[$key] = $base_path.'/'.$file;
		}
	}
	
	/**
	 * 移除指定的js文件
	 * @param integer $key 文件标识
	 */
	public function remove_script($key){
		if (isset($this->script[$key])){
			unset($this->script[$key]);
		}
	}
	
	/**
	 * 移除指定的css文件
	 * @param integer $key 文件标识
	 */
	public function remove_stylesheet($key){
		if (isset($this->stylesheet[$key])){
			unset($this->stylesheet[$key]);
		}
	}
	
	/**
	 * 设置页面标题
	 * @param string $pagename
	 */
	public function set_pagename($pagename=''){
		$this->pagename = $pagename;
	}
	
	/**
	 * 设置页面keyword
	 * @param unknown_type $keyword
	 */
	public function add_meta( $value, $content, $type='name'){
		$this->meta[$type][$value] = $content;
	}
	
	/**
	 * 移除指定的meta
	 */
	public function remove_meta($value,$type='name'){
		if (isset($this->meta[$type][$value])){
			unset($this->meta[$type][$value]);
		}
	}
	
	/**
	 * 注册变量到页面
	 * 这个函数的参数可以是可以提供两个参数或一个参数
	 *
	 * 如果提供两个参数,参数是一个数组,注册一个或多个变量如:array($key1=>$value1,$key2=>$value2);
	 * 如果提供一个参数,参数是$key,$value 的形式
	 * @example assign('aticle',$article); assign(array('aticle'=>$article,'author'=>$author));
	 */
	public function assign(){
		$params = func_get_args();
		$params_num = func_num_args();
		if ($params_num ==2){
			list($key,$value) = $params;
			$this->data[$key] = $value;
		}
		elseif ($params_num==1){
			foreach ($params as $key=>$value){
				$this->data[$key] = $value;
			}
		}
	}
	
	/**
	 * 输出页面
	 * @param string $file文件名(带路径)
	 * @param array $data
	 */
	public function display($file,$data=array()){
		if (count($data)){
			foreach ($data as $key=>$val){
				if (!empty($key)){
					$this->data[$key] = $val;
				}
			}
		}
		$this->load->view($this->view_path.$file,$this->data);
	}
}