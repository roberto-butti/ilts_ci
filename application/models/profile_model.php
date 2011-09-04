<?php
class Profile_model extends MY_Model {
  
  const DEFAULT_PROVIDER = "facebook";
  
  function __construct() {
    parent::__construct();
  }
  
  /**
   * Torna l'id utente partendo dall'identificatore utente
   * di terze parti (facebook...)
   * @param string $uid
   * @return int $id id profilo
   */
  public function getProfileIdFromUid($uid, $provider = self::DEFAULT_PROVIDER) {
    $this->db->select('*')
    ->from('profile')
    ->where('identifier',$uid)
    ->where('provider',$provider);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $row = $query->row();
      return $row->id;
    } else {
      return -1;
    }
  }
  
  public function createProfile($uid, $provider = self::DEFAULT_PROVIDER) {
    $data = array(
              "identifier" => $uid,
              "provider"=>$provider
            );
    $myprofile = $this->db->insert("profile", $data);
    $idProfile=0;
    if ($myprofile) {
      
      $idProfile = $this->db->insert_id();
      log_message("info", __METHOD__." created new profile with id:".$idProfile." for uid:".$uid." provider:".$provider);
    } else {
      log_message("info", __METHOD__." FAILED TO create new profile for uid:".$uid." provider:".$provider);
      $idProfile =0;
    }
    return $idProfile;
  }
  
}