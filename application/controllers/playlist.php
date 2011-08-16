<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("base/iltscontroller.php");
/**
* @property Loved_model $Loved_model
* @property Tags_model $Tags_model
*/
class Playlist extends IltsController {
  
  /**
   * 
   */
  function __construct() {
    parent::__construct();
    $this->load->model('Tags_model');
    $this->load->model('Loved_model');
    log_message("info", __METHOD__." init OK");
  }
  
  
  function ilove($slug) {
    $data= array();
    $data["q"] = "";
    $data["videoid"] = "";
    $data["title"] = "";
    $data["slug"] = $slug;
    
    $this->load->view('main', $data);
    //echo "aa";
    //die($slug);
  }
  
}

/* End of file playlist.php */
/* Location: ./application/controllers/playlist.php */