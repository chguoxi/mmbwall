<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class extframe extends frame {
    function load_head($index = 0) {
        $data = $this->CI->config->config;
        switch($index) {
            case 0:
                $viewname = $this->CI->config->item('language').'/block/header';
                break;
        }
        $this->data['header'] = $this->CI->load->view($viewname, $data, TRUE);
    }

    public function load_left($index = 0) {
        $data = $this->CI->config->config;
        switch($index) {
            case 0:
                $viewname = $this->CI->config->item('language').'/block/left';
                break;
        }
        $this->data['left'] = $this->CI->load->view($viewname, $data, TRUE);
    }

    public function load_foot($index = 0) {
        $data = $this->CI->config->config;
        switch($index) {
            case 0:
                $viewname = $this->CI->config->item('language').'/block/footer';
                break;
        }
        $this->data['footer'] = $this->CI->load->view($viewname, $data, TRUE);
    }
}