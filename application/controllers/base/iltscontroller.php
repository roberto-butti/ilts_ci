<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Profile_model $profile
 * @author rbutti
 *
 */
class IltsController extends CI_Controller {

  function __construct()
  {
    
    parent::__construct();
    $this->config->load('facebook');
    $this->load->model('Profile_model',"profile");
  }
  
  
  protected function initData () {
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
      if ($lovedObject) {
        $data["videoid"] = $lovedObject->videoid;
        $data["title"] = $lovedObject->title;
      }
    }
    return $data;
  }
  /**
   *  torna l'id profilo associato all'utente loggato su sistema
   *  terze parti.
   *  Per esempio: viene recuperato l'identifcatore utente terze parti
   *  (uid di facebook) e con quello viene recuperato l'id profilo
   *  dalla tabella profilo
   */
  protected function getProfiloId() {
    $idProfilo =0;
    $uid = $this->getFacebookUser();
    if ($uid != "") {
      $idProfilo=$this->profile->getProfileIdFromUid($uid);
      if ($idProfilo == 0) {
        //profilo non censito nell'applicazione
        $idProfilo=$this->profile->createProfile($uid);
      }
      log_message("info", __METHOD__." user profile from uid:".$idProfilo);
    } else {
      log_message("info", __METHOD__." user from session NO UID");
    }
    return $idProfilo;
  }
  
  
  
  
  /**
   * Torna l'uid utente di facebook con la modalitˆ introdotta in php sdk 3.1.1 e
   * modalitˆ oauth 2.0. Prima si chiamava il metodo getSession() ora getUser()
   */
  protected function getFacebookUser() {
    $fb_config = array();
    $fb_config['appId'] = $this->config->item("ilts_fb_app_id");
    $fb_config['secret'] = $this->config->item("ilts_fb_secret");
    $fb_config['cookie'] = $this->config->item("ilts_fb_cookie");;
    $this->load->library('facebook', $fb_config);
    $user = $this->facebook->getUser();
    $uid = "";
    if ($user) {
      log_message("info", __METHOD__." user: ".$user);
      $uid = $user;
    } else {
      log_message("info", __METHOD__." NO USER!!! user: ".$user);
    }
    return $uid;
  }
}