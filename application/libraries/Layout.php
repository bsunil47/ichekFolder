<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Layout {

    var $obj;
    var $layout;
    var $layout_folder = "layouts/";

    function __construct() {
        $this->obj = & get_instance();
        $this->layout = 'main';
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

    function view($view, $data = null, $return = false) {
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->obj->load->view($view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout_folder . $this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout_folder . $this->layout, $loadedData, false);
        }
    }

}

?>