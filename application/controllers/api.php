<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("base/iltscontroller.php");
/**
* @property Loved_model $Loved_model
* @property Tags_model $Tags_model
*/
class Api extends IltsController {
  
  const LABEL_STATUS = "status";
  const LABEL_STATUS_STATUS = "status";
  const LABEL_STATUS_CODE = "code";
  const LABEL_STATUS_MESSAGE = "message";
  
  /**
   * 
   */
  function __construct() {
    parent::__construct();
    $this->load->model('Tags_model');
    $this->load->model('Loved_model');
    $this->load->helper('language');
    log_message("info", __METHOD__." init OK");
    
  }
  
  private function convertArrayIntoString($array)  {
    $string = "";
    if (is_array($array)) {
      foreach ($array as $k => $v) {
        $string = $string. " / $k: $v";
      }
    }
    return $string;
  }
  
  private function prepareArrayMessage($status = "OK", $code = "000", $message = "") {
    $data = array();
    $data[self::LABEL_STATUS_STATUS] = $status;
    $data[self::LABEL_STATUS_CODE] = $code;
    $data[self::LABEL_STATUS_MESSAGE] = $message;
    log_message("info", __METHOD__." preparing : ".$this->convertArrayIntoString($data));
    return $data;
  }
  
  function mockup() {
    $data = array();
    $random = rand(1, 3);
    $this->output->set_header('Content-type: application/json');
    $this->load->view('api/mockup_'.$random.'_json', $data);
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

  /**
   * espone in formato json i video appartenenti ad un certo tag
   * Secondo le regole di routing:
   * api/tags/load/$idtag
   * Esempio:
   * /api/tags/load/1
   * @param $idtag idetinficatore del tag
   */
  function loadtag($idtag) {
    
    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    
    $data = array();
    $key_cache = 'tag_'.$idtag;
    //$this->cache->delete($key_cache);
    if ( ! $cached_tag = $this->cache->get($key_cache)) {
      log_message("info", __METHOD__." load loved form tag id:".$idtag);
      $data["query"] = array();
      $data["query"]["list"] = $this->Tags_model->queryLovedFromTagId($idtag, MY_Model::RESULT_ARRAY);
      $data["query"]["tag"] = $this->Tags_model->queryTagById($idtag, MY_Model::RESULT_ARRAY);
      $data["query"]["tag"]["pre_title"] =lang('ilts_yourselectedplaylist');
      $status = array();
      if (sizeof($data["query"]["list"] ) ==0 ) {
        $status = $this->prepareArrayMessage("EMPTY", "404", "No tags found");
      } else {
        $status = $this->prepareArrayMessage();
      }
      $data["query"][self::LABEL_STATUS] = $status;
      $this->cache->save($key_cache, $data["query"], 5);
    } else {
      $cached_tag[self::LABEL_STATUS][self::LABEL_STATUS_MESSAGE] = "result cached!";
      log_message("info", __METHOD__." result from cache ".$this->prepareArrayMessage($cached_tag));
      $data["query"] = $cached_tag;
    }
    $this->output->set_header('Content-type: application/json');
    $this->output->set_output(json_encode($data["query"]));
    //var_dump($data["query"]->result_array());
  }

  
  /**
   * Recupera in formato json l'elenco dfei video appartenenti ad un certo tag
   * identificato dallo slug definito in input
   * @param $slug slug relativo alla playlist di cui recuperare l'elenco dei video
   * 
   */
  function loadtagbyslug($slug) {
    $data = array();
    log_message("info", __METHOD__." load loved form tag slug:".$slug);
    $tagObject = $this->Tags_model->queryTagBySlug($slug);
    $idTag =0;
    if ($tagObject) {
      $idTag = $tagObject->id;
    }
    log_message("info", __METHOD__." load loved form tag id:".$idTag);
    $this->loadtag($idTag);
  }
  
  /**
   * aggiunge i tags nel formato tag1, tag2,tag3... identificato nel POST mytags
   * I Tag vengono associati al videoid (yt) identificato nel POST videoid
   * Il video viene associato all'utente loggato (uid in sessione)
   */
  function addtags() {
    $idProfile = $this->getProfiloId();
    if ($idProfile != 0) {
      log_message("info", __METHOD__." for id profile:".$idProfile);
      $tags = array();
      $mytagsString = $this->input->post("mytags");
      $this->Loved_model->setProfileId($idProfile);
      $this->Loved_model->setVideoid($this->input->post("videoid"));
      $this->Loved_model->setTitle($this->input->post("videotitle"));
      $this->Loved_model->setThumb($this->input->post("videothumb"));
      $idLoved = $this->Loved_model->save();
      log_message("info", __METHOD__." saved loved:".$idLoved);
      
      $mytags = $this->Tags_model->explodeTags($mytagsString);
      $this->Tags_model->saveTagsForLoved($mytags, $this->Loved_model, $idLoved);
    } else {
      log_message("info", __METHOD__." profilo non impostato");
      echo "User not logged";
    }
  }
  
  function edittags($idtag) {
    
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('tag', 'Tag', 'required');
    $data = array();
    if ($this->form_validation->run() == FALSE) {
      //errore
      log_message("info", __METHOD__." errore durante la validazione");
    } else {
      $data["tag"] = $this->input->post("tag");
      $this->Tags_model->update("tags", $data, $idtag);
      log_message("info", __METHOD__." modificato tag id: $idtag");
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
        case "htmltag":
          $this->load->view('block/loved_playlist', $data);
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