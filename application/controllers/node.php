<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Node extends CI_Controller {
	/**
	 * 市场研究频道对应的文章分类
	 * var array
	 */
	public $marketanalyze = array('research','outlook','intelligence');
	
	/**
	 * 所有欄目
	 * @var array
	 */
	public $typelists = array('skin','elderly','food','relationship','sick','times','issues');
	
	/**
	 * 栏目名称
	 * @var array
	 */
	public $catename = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->library('apiproxy');
		$this->lang->load('node');
		$this->associate_cate();
	}
	
	public function index(){
		$nodes = array();
		$page = 1;
		$per_page = 10;
		foreach ($this->typelists as $key=>$cat_slug){
			$url = $this->config->item('api_get_posts').'/'.$cat_slug.'/'.$page.'/'.$per_page;
			$response = $this->apiproxy->get($url);
			$nodes[$cat_slug] = $response->data;
		}
		$data['category_nodes'] = $nodes;
		$data['catetype'] = 'home';
		$data['categories'] = $this->catename;
		$data['page_title'] = $this->lang->line('index_title');
		$data['head']['meta']['keywords'] = $this->lang->line('index_meta_keywords');
		$data['head']['meta']['description'] = $this->lang->line('index_meta_description');
		$this->extframe->load($data);
		$this->extframe->load_foot();
		$this->extframe->view($this->config->item('language').'/page/node_index');
	}
	
	public function page( $cat_slug, $pindex=1 ){
		$catetype = $cat_slug;
		$cat_slug = $cat_slug=='news'?'issues':$cat_slug;
		//文章接口地址
		$url = $this->config->item('api_get_posts').'/'.$cat_slug.'/'.$pindex;
		$response = $this->apiproxy->get($url);
		if ( isset($response->error_code) && $response->error_code ===0 ){
			foreach ($response->data as $key=>$node){
				$response->data[$key]->post_summary = rm_style($node->post_summary);
			}
			$data['page_title'] = $this->catename[$cat_slug];
			$data['nodes']      = $response->data;
			$data['catetype']   = $catetype;
			$data['catename']   = $this->catename[$cat_slug];
			$data['pindex']     = $pindex;
			
			$this->extframe->load($data);
			$this->extframe->load_foot();
			$this->extframe->view($this->config->item('language').'/page/node_page');
		}
		else{
			exit;
		}
	}
	
	public function more( $cat_slug, $pindex=1 ){
		$cat_slug = $cat_slug=='news'?'issues':$cat_slug;
		$html = '';
		$url = $this->config->item('api_get_posts')."/$cat_slug/".$pindex;
		$response = $this->apiproxy->get($url);
		if ( isset($response->error_code) && $response->error_code ===0 ){
			if (!count($response->data)){
				$response->error_code = 1404;
				$response->error_msg  = $this->lang->line('error_no_more_data');
			}
			$data['nodes']      = $response->data;
			$html = $this->load->view($this->config->item('language').'/page/node_list',$data,true);
			$html = rm_style($html);
			$response->data = $html;
		}
		elseif (isset($response->error_code) && $response->error_code !=0){
			//do nothing
		}
		else{
			$response = new stdClass();
			$response->error_code = 1020;
			$response->error_msg = $this->lang->line('error_connect_failure');
		}
		echo json_encode($response);exit;
	}
	
	public function view($post_id){
		$url = $this->config->item('api_get_post_detail').'/'.$post_id;
		$response = $this->apiproxy->get($url);
		
		if ( isset($response->error_code) && $response->error_code ===0 ){
			$node = $response->data->post;
			$node->post_content = rm_style($node->post_content);
			$parent_cate = $this->apiproxy->get($this->config->item('api_get_cat_parent').'/'.$node->category_id);
			$recommend_type = $node->category_slug == 'issues' ? 'news' : 'article';
			$recommend_url = $this->config->item('api_get_recommend_posts').'/'. $recommend_type;
			
			$recommend_nodes = $this->apiproxy->get($recommend_url);
			$data['keywords'] = $response->data->keywords;
			$data['page_title'] = $node->post_title;
			$data['node']      = $node;
			$data['recommend'] = $recommend_nodes->error_code==0 ? $recommend_nodes->data : array();
			$data['catetype'] = $parent_cate->data->category_slug;
			$data['catename'] = isset($parent_cate->data->category_name)?$parent_cate->data->category_name:'';
			$this->extframe->load($data);
			$this->extframe->view($this->config->item('language').'/page/node_view',$data);
		}
		else{
			
		}
	}
	
	private function associate_cate(){
		$url = $this->config->item('api_get_categories');
		$response = $this->apiproxy->get($url);
		if ( isset($response->error_code) && $response->error_code ===0 ){
			$categories = $response->data;
			foreach ($categories as $key=>$category){
				if ($category->category_slug=='issues'){
					$this->catename['issues'] = '醫訊情報';
				}
				else{
					$this->catename[$category->category_slug] = $category->category_name;
				}
				
			}
		}
	}

}