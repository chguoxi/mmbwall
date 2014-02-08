<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frame {
    public $CI;
    public $data = array();
    private $cachename;
    private $framekeys = array();
    private $default_token_index;
    private $cacheon = FALSE;
    private $cacheengine = 'mp_cache';
    public function __construct() {
        $this->CI =& get_instance();
        $this->framekeys = $this->CI->config->item('framekeys');
        $this->default_token_index = $this->CI->config->item('default_token_index');
    }
    
    public function cache_get() {
        if ($this->cacheon === false) return false;
        switch($this->cacheengine) {
            case 'mp_cache':
                $data = $this->mp_cache->get($this->cachename);
                if ($data === false) {
                    return false;
                } else {
                    $this->data = $data;
                    return ture;
                }
                break;
        }
    }

    public function cache_set() {
        if ($this->cacheon === false) return;
        switch($this->cacheengine) {
            case 'mp_cache':
                if ($this->CI->config->item('cache_expiretime') > 0) {
                    $this->mp_cache->write($this->data, $this->cachename, 
                    		$this->CI->config->item('cache_expiretime'));
                } else {
                    $this->mp_cache->write($this->data, $this->cachename);
                }
                break;
        }
    }

    public function is_cached($urilevel = 0, $extendparas = array()) {
        $this->format_name($urilevel, $extendparas);
        if ($this->cache_get()) {
            return false;
        } else {
            return false;
        }
    }

    public function format_name($urilevel = 0, $extendparas = array()) {
        $stdnamearray = array_slice($this->CI->uri->rsegments, 0, $urilevel + 2);
        if (!is_array($extendparas) && count($extendparas) == 0) {
            $this->cachename = implode('_', $stdnamearray);
        } else {
            $this->cachename = implode('_', array_merge($stdnamearray, $extendparas));
        }

    }

    public function load($data = array(), $framework = array()) {
        $this->format_data($data);
        $this->load_framework($framework);
        $this->cache_set();
    }

    public function format_data($data = array()) {
        //Data initialize
        $this->data = $this->CI->config->config;
        if (isset($this->data['shortcut_icon'])) {
            $this->data['shortcut_icon'] = $this->data['base_url'] 
            . $this->data['shortcut_icon'];
        }
        $this->data['site_title'] = $this->CI->lang->line('site_title');
        $this->data['site_slogan'] = $this->CI->lang->line('site_slogan');

        //Data integrate
        foreach(array('integrate_head_title', 'integrate_styles'
        		,  'integrate_scripts', 'integrate_head', 'integrate_help'
        		, 'integrate_surplus') as $funcname) {
            $this->$funcname($data);
        }
    }

    function integrate_head_title(&$data) {
        if (isset($data['page_title'])) {
            $this->data['head_title'] = $data['page_title'] . $this->data['site_title'];
        } else {
            $this->data['page_title'] = '';
            $this->data['head_title'] = !empty($this->data['site_slogan']) 
            	? $this->data['site_title'].' | '.$this->data['site_slogan'] 
            	: $this->data['site_title'];
        }
    }

    function integrate_styles(&$data) {
        if (isset($data['styleformat']) && $data['styleformat'] == TRUE) {
            $this->data['stylesheets'] = array();
        }
        if (isset($data['stylesheets'])) {
            if (is_array($data['stylesheets'])) {
                foreach($data['stylesheets'] as $stylesheet) {
                    $this->data['stylesheets'][] = $this->data['style_path'] . $stylesheet;
                }

            }
            unset($data['stylesheets']);
        }

        $styles = array();
        if (isset($this->data['stylesheets'])) {
            foreach($this->data['stylesheets'] as $stylesheet) {
                $styles[] = '<link type="text/css" rel="stylesheet" media="all" href="'.$this->data['base_url'].$stylesheet.'" />';
            }
        }
        $this->data['styles'] = (count($styles) > 0) ? implode("\r", $styles)."\r" : '';
        unset($this->data['stylesheets']);
    }

    function integrate_scripts(&$data) {
        if (isset($data['scriptformat']) && $data['scriptformat'] == TRUE) {
            $this->data['scriptsheets'] = array();
        }
        if (isset($data['scriptsheets'])) {
            if (is_array($data['scriptsheets'])) {
                foreach($data['scriptsheets'] as $scriptsheet) {
                    $this->data['scriptsheets'][] = $this->data['script_path'] . $scriptsheet;
                }
            }
            unset($data['scriptsheets']);
        }

        $scripts = array();
        if (isset($this->data['scriptsheets'])) {
            foreach($this->data['scriptsheets'] as $scriptsheet) {
                $scripts[] = '<script type="text/javascript" src="'.$this->data['base_url'].$scriptsheet.'"></script>';
            }
        }
        $this->data['scripts'] = (count($scripts) > 0) ? implode("\r", $scripts)."\r" : '';
        unset($this->data['scriptsheets']);
    }

    function integrate_head(&$data) {
        $head = array();
        if (isset($data['head'])) {
            if (!array_key_exists('meta', $data['head'])) {
                $meta = $this->Mmeta->meta();
                if (!is_null($meta)) {
                    $data['head']['meta'] = $meta;
                }
            }
            foreach($data['head'] as $key => $item) {
                switch($key) {
                    case 'rss':
                        $head[] = '<link rel="alternate" type="application/rss+xml" title="'.$item['title'].'" href="'.$item['link'].'" />';
                        break;
                    case 'meta':
                        foreach($item as $name => $value) {
                            $head[] = '<meta name="'.$name.'" content="'.$value.'">';
                        }
                        break;
                }
            }
            unset($data['head']);
        }
        $this->data['head'] = (count($head) > 0) ? implode("\r", $head)."\r" : '';
    }

    function integrate_help(&$data) {
        if (function_exists('validation_errors')) {
            $error_message = validation_errors('<li>', '</li>');
            if (trim($error_message)) {
                $this->data['help'] = '<div class="error-wrapper clear-block"><div class="error"><ul>'.$error_message.'</ul></div></div>';
            } else {
                $this->data['help'] = '';
            }
        }

        if (isset($data['info'])) {
            $info_message = $data['info'];
            if (trim($info_message)) {
                $this->data['help'] .= '<div class="info-wrapper clear-block"><div class="info"><ul><li>'.$info_message.'</li></ul></div></div>';
            } else {
                $this->data['help'] .= '';
            }
        }
    }

    function integrate_surplus(&$data) {
        if (count($data) > 0) {
            foreach($data as $key => $value) {
                if (array_key_exists($key, $this->data)) {
                    $this->data[$key] += $value;
                } else {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    public function load_framework($framework = array()) {
        if (is_array($framework)) {
            foreach($this->framekeys as $name => $value) {
                $framework[$name] = array_key_exists($name, $framework) ? $framework[$name] : $value;
            }
        }

        foreach($framework as $name => $value) {
            if ($value !== false) {
                $funcname = 'load_'.$name;
                $this->$funcname($value);
            }
        }
    }

    public function load_head($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }

    public function load_left($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }

    public function load_body($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }

    public function load_right($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }

    public function load_foot($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }

    public function view($pagename = NULL, $token_index = false) {
        $arg_num = func_num_args();
        if ($arg_num < 2) {
            $token_index = $this->default_token_index;
        }
        if ($token_index !== false) {
            $this->load_token($token_index);
        }
        $this->data['pagename'] = $pagename;
        $this->CI->load->view('default/mainpage', $this->data);
    }

    public function load_token($index = 0) {
        switch($index) {
            case 0:
                break;
        }
    }
}