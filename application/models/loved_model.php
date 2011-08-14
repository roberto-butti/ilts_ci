<?php
/**
 * @author rbutti
 *
 */
class Loved_model extends MY_Model {
  
  private $profile_id;
  private $title;
  private $thumb;
  private $videoid;
  
  private $result;
  
  function __construct() {
    parent::__construct();
  }
  
  
  public function getResult() {
    $this->result;
  }
  
  public function getProfileId() {
    return $this->profile_id;
  }
  
  public function setProfileId($profile_id) {
    $this->profile_id = $profile_id;
  }
  
  public function getTitle() {
    return $this->title;
  }
  
  public function setTitle($title) {
    $this->title = $title;
  }
  
  public function getThumb() {
    return $this->thumb;
  }
  
  public function setThumb($thumb) {
    $this->thumb = $thumb;
  }
  
  public function getVideoid() {
    return $this->videoid;
  }
  
  public function setVideoid($videoid) {
    $this->videoid = $videoid;
  }
  
  
  
  public function getLovedById($idloved) {
    $this->db->select('loved.*')
    ->from('loved')
    ->where('id',$idloved);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }
  
  
  /**
   * viene recuperato un record dalla tabella loved partendo da un identificatore
   * profilo e videoid
   * @param int $profileid identificatore profilo
   * @param string $videoid videoid di youtube
   * @return object $loved record loved. Se non trovato torna false
   */
  public function getLovedProfileidAndVideoid($profileid, $videoid) {
    log_message("info", __METHOD__." profileid:$profileid , videoid:$videoid");
    $this->db->select('loved.*')
    ->from('loved')
    ->where('loved.videoid',$videoid)
    ->where('loved.profile_id',$profileid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }
  
  
  private function popolateData() {
    $data=array(
      "profile_id" => $this->getProfileId(),
      "videoid"    => $this->getVideoid(),
      "title"      => $this->getTitle(),
      "thumb"      => $this->getThumb()
    );
    return $data;
  }
  
  /**
   * Crea un nuovo loved (idprofilo, videoid...)
   * Precondizione: devono essere impostati gli attributi profile_id e videoid
   * @return int idLoved l'identificatoe del loved inserito. 0 Se c'e' qualche errore
   */
  public function add() {
    $data = $this->popolateData();
    $idLoved = parent::add("loved", $data);
    return $idLoved;
  }
  
  /**
   * aggiorna il record con identificatore $id
   * @param $id
   * @return object $lovedRow
   */
  public function update($id) {
    $data = $this->popolateData();
    $loved = parent::update("loved", $data, $id);
    return $loved;
  }
  
  
  /**
   * 
   * Enter description here ...
   */
  public function save() {
    $lovedRow = $this->getLovedProfileidAndVideoid($this->getProfileId(), $this->getVideoid());
    $idLoved =0;
    if ( $lovedRow) {
      $idLoved = $lovedRow->id;
      $this->update($idLoved);
      log_message('info', __METHOD__.' loved exists with id:'.$idLoved);
    } else {
      $idLoved = $this->add();
      log_message('info', __METHOD__.' new loved created with id:'.$idLoved);
    }
    return $idLoved;
  }
  
}
