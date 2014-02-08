<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//set timezone
date_default_timezone_set('Asia/Shanghai');
$config['base_url']	= '';
$config['pc_site_url'] = '/';
$config['site_title'] = '';
$config['lang_id'] = 'cn';
$config['view_path'] = 'zh-cn/';
$config['pc_site_register_url'] = $config['pc_site_url'].'';
$config['pc_site_findpassword_url'] = $config['pc_site_url'].'';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'zh-tw';

