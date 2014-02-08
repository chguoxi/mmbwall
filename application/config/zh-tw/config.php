<?php
//set timezone
date_default_timezone_set('Asia/Taipei');

$config['base_url']  	= 'http://m.healthworld.tw.tf';
$config['lang_id']      = 'tw';
$config['view_path'] = 'zh-tw/';
$config['pc_site_url'] = 'http://healthworld.tw/';
$config['pc_site_register_url'] = $config['pc_site_url'].'register';
$config['pc_site_findpassword_url'] = $config['pc_site_url'].'forgetpasswd';
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

/*
 |--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = APPPATH.'cache/zh-tw/';

/*
|--------------------------------------------------------------------------
| Theme Path
|--------------------------------------------------------------------------
*/
$config['theme_path'] = '/theme/';

/*
|--------------------------------------------------------------------------
| Style Path
|--------------------------------------------------------------------------
*/
$config['style_path'] = $config['theme_path'].'zh-tw/css/';

/*
|--------------------------------------------------------------------------
| Script Path
|--------------------------------------------------------------------------
*/
$config['script_path'] = $config['theme_path'].'zh-tw/js/';


/*
|--------------------------------------------------------------------------
| Image Path
|--------------------------------------------------------------------------
*/
$config['image_path'] = $config['theme_path'].'zh-tw/images/';

/*
|--------------------------------------------------------------------------
| Shortcut Icon
|--------------------------------------------------------------------------
*/
$config['shortcut_icon'] = '';

/*
|--------------------------------------------------------------------------
| Style Sheets
|--------------------------------------------------------------------------
*/
$config['stylesheets'][] = $config['style_path'].'style.css';

/*
|--------------------------------------------------------------------------
| Script Sheets
|--------------------------------------------------------------------------
*/
$config['scriptsheets'][] = $config['script_path'].'zepto.min.js';
$config['scriptsheets'][] = $config['script_path'].'google.js';

/*
|--------------------------------------------------------------------------
| Cache Expiretime
|--------------------------------------------------------------------------
*/
$config['cache_expiretime'] = 1200;


/* End of file config.php */
/* Location: ./application/config/config.php */