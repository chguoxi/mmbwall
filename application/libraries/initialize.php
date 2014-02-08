<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class initialize {
    var $CI;
    var $initialize = array(
    		'init_config' => false, 
    		'init_autoload' => false, 
    		'init_user' => false, 
    		'init_access' => false
    		);
    var $autoload = array('language' => array());
    var $timezone = 'PRC';
    var $db;
    var $user;
    var $exclude = array('user/login', 'user/logout', 'cron');
    public function __construct() {
        $this->CI =& get_instance();
        date_default_timezone_set($this->timezone);
        foreach($this->initialize as $name => $value) {
            if ($value) {
                $this->$name();
            }
        }
    }

    function init_config() {
        $domainarray = explode('.', $_SERVER['HTTP_HOST']);
        for($i = 0; $i < 3; $i++) {
            $domain = $i <= 1 ? implode('.', array_slice($domainarray, $i)) : 'default';
            $config_path = APPPATH.'config/'.$domain.'/config.php';
            if (file_exists($config_path)) {
                $this->CI->config->load($domain.'/config');
                break;
            }
        }

    }

    function init_autoload() {
        foreach($this->autoload as $name => $array) {
            if ($name == 'language') {
                foreach($array as $value) {
                    $this->CI->lang->load($value);
                }
            }
        }
    }

    function init_user() {
        $this->db = isset($this->CI->db) ? $this->CI->db : $this->CI->load->database('default', TRUE);
        $this->db->where('s.session_id', $this->CI->session->userdata('session_id'));
        $query = $this->db->get('shared_sessions s, shared_users u');
        if ($query->num_rows() > 0) {
            $item = current($query->result());
        } else {
            $item = new stdClass();
            $item->uid = 0;
        }
        $this->user = $item;
    }

    function init_access() {
        if ($this->user->uid == 0) {
            if (!$this->url_access()) {
                if (!function_exists('redirect')) {
                    $this->CI->load->helper('url');
                }
                if ($this->CI->uri->rsegments[1] == 'user') {
                    redirect('user/login');
                } else {
                    redirect('user/login?destination='.$this->CI->uri->uri_string);
                }
            }
        }
    }

    function url_access() {
        $access = false;
        foreach($this->exclude as $url) {
            if($this->url_compare($url, $this->CI->uri->rsegments)) {
                $access = true;
            }
        }
        return $access;
    }

    function url_compare($needle, $uriarray) {
        if (preg_match_all('/\w+/', $needle, $needlearray)) {
            $access = true;
            foreach($needlearray[0] as $key => $value) {
                if ($value != $uriarray[++$key]) {
                    $access = false;
                }
            }
            return $access;
        }
        return false;
    }

    function item($name) {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
        return false;
    }
}