<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("base/iltscontroller.php");

class Main extends IltsController {

  function __construct()
  {
    parent::__construct();
    $this->config->load('facebook');
    $this->load->helper('iltsfrontend');
    $this->load->helper('language');
  }

  function index()
  {
    
    $data = array();
    $data = $this->initData();
    
    $this->load->view('main', $data);
  }
  
  
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */