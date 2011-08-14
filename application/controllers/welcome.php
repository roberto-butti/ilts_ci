<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->config->load('facebook');
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
    $this->load->view('welcome_message', $data);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */