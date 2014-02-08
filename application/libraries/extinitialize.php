<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class extinitialize extends initialize {
    var $initialize = array('init_config' => true, 'init_autoload' => true, 'init_user' => false, 'init_access' => false);
    var $autoload = array('language' => array( 'common', 'error'));

}