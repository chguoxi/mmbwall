<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 使用代理访问远程接口
 * 由于Ajax 不支持跨域调用,如果需要使用Ajax访问接口，则通过本代理
 *
 */
class Apiproxy {
	private $ci;
	private $cache_time = 600;
	private $cacheon = FALSE;
	
	public function __construct(){
		$this->ci = &get_instance();
		$this->ci->load->library('curl');
		$this->ci->load->driver('cache', array('adapter' => 'file'));
	}
	
	public function get($url,$params=array()){
		if (DEBUG){
			$this->cacheon = false;
		}
		//从缓存中查找
		$url_info = parse_url($url);
		$cache_name = str_replace('/', '_', $url_info['path']);
		
		if ( $this->cacheon && $this->ci->cache->get($cache_name) ){
			$response = $this->ci->cache->get($cache_name);
		}
		else{
			$response = $this->ci->curl->simple_get($url,$params);
			$obj = json_decode($response);
			//处理不能从远程获取数据的情况
			if ( is_null($obj) ){
				$response = new stdClass();
				$response->error_code = 1013;
				$response->error_msg = '网络错误,请检查网络连接';
				$response->data = array();
				$response = json_encode($response);
			}
			if (isset($obj->error_code)&&$obj->error_code==0){
				$this->ci->cache->save($cache_name,$response,$this->cache_time);
			}
		}
		return json_decode($response);
	}
	
	public function post($url,$data=array()){
		$response = $this->ci->curl->simple_post($url,$data);
		if ( is_null(json_decode($response)) ){
			$response = new stdClass();
			$response->error_code = 1013;
			$response->error_msg = '网络错误,请检查网络连接';
			$response->data = array();
			$response = json_encode($response);
		}
		return json_decode($response);
	}
}