<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['api_base_url']        = 'http://healthworld.tw.tf/api';
$config['api_user_login']      = $config['api_base_url'].'/login';
$config['api_get_posts']       = $config['api_base_url'].'/get_posts';
$config['api_get_post_detail'] = $config['api_base_url'].'/get_post_detail';
$config['api_get_new_posts']   = $config['api_base_url'].'/get_new_posts';
$config['api_get_hot_news']    = $config['api_base_url'].'/get_hot_news';
$config['api_get_hot_posts']   = $config['api_base_url'].'/get_hot_posts';
$config['api_get_categories']  = $config['api_base_url'].'/get_categories';
$config['api_get_cat_parent']  = $config['api_base_url'].'/get_cat_parent';
$config['api_get_recommend_posts'] = $config['api_base_url'].'/get_recommend_posts';