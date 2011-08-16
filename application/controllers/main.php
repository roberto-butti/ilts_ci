<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->config->load('facebook');
    $this->load->helper('url');
  }

  function index()
  {
    $data = array();
    $param = $this->input->get("q");
    $data["q"] = "";
    if ($param) {
      $data["q"] = $param;
    }
    $param = $this->input->get("loved");
    $data["videoid"] = "";
    $data["title"] = "";
    if ($param) {
      $this->load->model('Loved_model');
      $lovedObject = $this->Loved_model->getLovedById($param);
      $data["videoid"] = $lovedObject->videoid;
      $data["title"] = $lovedObject->title;
    }
    $this->load->view('main', $data);
  }
  
  
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */