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
  
  /**
   * torna lo user id di facebook.
   * Se utente non autenticato o sessione non definita,
   * torna stringa vuota "".
   */
  protected function getUidSessionFacebook() {
    $uid = "";
    $user = $this->getFacebookSession();
    if ($user) {
      log_message("info", __METHOD__." user: ".$user);
      //if (key_exists("uid", $session)) {
      //  $uid = $session["uid"];
      //}
      $uid = $user;
    } else {
      log_message("info", __METHOD__." NO USER!!! user: ".$user);
    	
    	// errrore recupero uid facebook
    }
    return $uid;
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
    $uid = $this->getUidSessionFacebook();
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
  
  
  
  
  protected function getFacebookSession() {
    //Enter your Application Id and Application Secret keys
    $fb_config = array();
    $fb_config['appId'] = $this->config->item("ilts_fb_app_id");
    $fb_config['secret'] = $this->config->item("ilts_fb_secret");
    //Do you want cookies enabled?
    $fb_config['cookie'] = $this->config->item("ilts_fb_cookie");;
    //load Facebook php-sdk library with $config[] options
    $this->load->library('facebook', $fb_config);
    //Load Session class for saving access token later
    //$this->load->library('session');
    //Check to see if there is an active Facebook session.
    //We will not know if the session is valid until the call is made
    //$session = $this->facebook->getSession();
    $user = $this->facebook->getUser();
    //var_dump($user);
    
    //Check to see if the access_token is present in Facebook session data
    //if (!empty($session['access_token'])) {
      //Save token to Session data for later use
    //  $this->session->set_userdata('access_token', $session['access_token']);
    //}
    return $user ;
  }
}