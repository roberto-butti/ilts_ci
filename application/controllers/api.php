<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("base/iltscontroller.php");
/**
* @property Loved_model $Loved_model
* @property Tags_model $Tags_model
*/
class Api extends IltsController {
  
  /**
   * 
   */
  function __construct() {
    parent::__construct();
    $this->load->model('Tags_model');
    $this->load->model('Loved_model');
    log_message("info", __METHOD__." init OK");
    
  }
  
  function mylovedbyvideoid($videoid) {
    log_message("info", __METHOD__." videoid:".$videoid);
    $uid = $this->getFacebookUser();
    if ($uid != "") {
      log_message("info", __METHOD__." user from session= ".$uid);
      $loved= $this->Tags_model->queryLovedByUid($uid, $videoid);
      if ($loved) {
        var_dump($loved);
      } else {
        echo "no video";
      }
    } else {
      log_message("info", __METHOD__." uid empty, session not valid");
    }
  }

  function loadtag($idtag) {
    $data = array();
    log_message("info", __METHOD__." load loved form tag id:".$idtag);
    $data["query"] = $this->Tags_model->queryLovedFromTagId($idtag);
    var_dump($data["query"]);
  }

  /**
   * aggiunge i tags nel formato tag1, tag2,tag3... identificato nel POST mytags
   * I Tag vengono associati al videoid (yt) identificato nel POST videoid
   * Il video viene associato all'utente loggato (uid in sessione)
   */
  function addtags() {
    $idProfile = $this->getProfiloId();
    if ($idProfile != 0) {
      $tags = array();
      $mytagsString = $this->input->post("mytags");
      $this->Loved_model->setProfileId($idProfile);
      $this->Loved_model->setVideoid($this->input->post("videoid"));
      $this->Loved_model->setTitle($this->input->post("videotitle"));
      $this->Loved_model->setThumb($this->input->post("videothumb"));
      $idLoved = $this->Loved_model->save();
      $mytags = $this->Tags_model->explodeTags($mytagsString);
      $this->Tags_model->saveTagsForLoved($mytags, $this->Loved_model, $idLoved);
    } else {
      log_message("info", __METHOD__." profilo non impostato");
      echo "User not logged";
    }
  }
  
  
  /**
   * recupera l'elenco dei tag associati ad un utente.
   * Il parametro format (html, json) permette di specificare il formato di output.
   * Il default html
   */
  function mytags($format="html") {
    
    $query_tag = $this->input->get("term");
    
    log_message("info", __METHOD__." start");
    $idProfile = $this->getProfiloId();
    log_message("info", __METHOD__." id profile:".$idProfile);
    if ($idProfile != 0) {
      $data = array();
      $data["query"] = $this->Tags_model->queryTagsOfUser($idProfile, $query_tag);
      log_message("info", __METHOD__." query:".$data["query"]->num_rows());
      log_message("info", __METHOD__." format:".$format);
      switch ($format) {
        case "json":
          $this->output->set_header('Content-type: application/json');
          $this->output->set_output(json_encode($data["query"]->result_array()));
          break;
        case "autocomplete":
          $string = "";
          $q = $data["query"]->result();
          $return_arr = array();
          foreach ($q as $item) {
            $row_array= array();
            $row_array['id'] = $item->id;
            $row_array['value'] = $item->tag;
            $row_array['abbrev'] = $item->tag;
            array_push($return_arr,$row_array);
          }
          $string = json_encode($return_arr);
          /*
          foreach ($q as $item) {
            $string = $string."".$item->tag."|".$item->id."\n";
          }
          */
          $this->output->set_output($string);
          break;
        default:
          $this->load->view('api/mytags_'.$format, $data);
          break;
      }
    } else {
      echo "user not auth";
    }
  }
}

/* End of file api.php */
/* Location: ./application/controllers/api.php */