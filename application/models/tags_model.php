<?php
class Tags_model extends MY_Model {
  function __construct() {
    parent::__construct();
  }

  
  /**
   * converte in tag in formato stringa tag1, tag2, tag3
   * in un array di tag ripulito da spazi iniziali e finali e da
   * tag non validi (tag vuoti).
   * @param $tagString
   * @return array $tags
   */
  public function explodeTags($tagString) {
    $tags = array();
    $tags = explode(",", $tagString, 15);
    for ($i=0; $i< sizeof($tags); $i++) {
      $tag = $tags[$i];
      $tag = trim($tag);
      if ($tag == "") {
        unset($tags[$i]);
      } else {
        $tags[$i] = $tag;
      }
    }
    //$tags = array_slice($tags);
    return $tags;
  }
  
  /**
   * torna l'elenco dei tag relativi ad un identificatore profilo
   * @param $profileid identificatore profilo del db
   * 
   */
  public function queryTagsOfUser($profileid, $query_tag = false) {
    $this->db->select('mytag.*')
    ->from('mytag')
    ->where('profile_id',$profileid)
    ->order_by("tag", "ASC")
    ;
    if ($query_tag) {
      $this->db->like("tag", $query_tag);
    }
    return $this->db->get();
  }

  public function queryTagOfProfileId($profileid, $tag) {
    $this->db->select('mytag.*')
    ->from('mytag')
    ->where('mytag.tag',$tag)
    ->where('mytag.profile_id',$profileid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }


  public function queryLoved($profileid, $videoid) {
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

  public function queryLovedByUid($uid, $videoid) {
    $this->db->select('loved.*, mytag.*')
    ->from('loved')
    ->join('profile', 'loved.profile_id = profile.id')
    ->join('mytag_loved', 'loved.id = mytag_loved.loved_id')
    ->join('mytag', 'mytag.id = mytag_loved.mytag_id')
    ->where('loved.videoid',$videoid)
    ->where('profile.identifier',$uid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return false;
    }
  }

  
  /**
   * recupera i loved relativi al tag id $tagid
   * @param int $tagid
   * 
   */
  public function queryLovedFromTagId($tagid) {
    $this->db->select('loved.*')
    ->from('mytag_loved')
    ->join('loved', 'mytag_loved.loved_id = loved.id')
    ->where('mytag_loved.mytag_id',$tagid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {
      return false;
    }
  }

  public function queryLovedTag($lovedid, $tagid) {
    $this->db->select('mytag_loved.*')
    ->from('mytag_loved')
    ->where('mytag_loved.loved_id',$lovedid)
    ->where('mytag_loved.mytag_id',$tagid);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }




  public function createTag($profileid, $tag) {
    $data=array("profile_id" => $profileid, "tag"=>$tag);
    $mytag = $this->db->insert("mytag", $data);
    $idTag=0;
    if ($mytag) {
      $idTag = $this->db->insert_id();
    } else {
      $idTag =0;
    }
    return $idTag;
  }

  public function createLoved($profileid, $videoid, $videotitle = "", $videothumb="") {
    $data=array("profile_id" => $profileid, "videoid"=>$videoid, "title" => $videotitle, "thumb" => $videothumb);
    $loved = $this->db->insert("loved", $data);
    $idLoved=0;
    if ($loved) {
      $idLoved = $this->db->insert_id();
      log_message("info", __METHOD__." created loved with id:".$idLoved." DATA:".print_r($data, true));
    } else {
      $idLoved =0;
    }
    return $idLoved;
  }

  public function createLovedTag($lovedid, $tagid) {
    $data=array("loved_id" => $lovedid, "mytag_id"=>$tagid);
    $lovedTag = $this->db->insert("mytag_loved", $data);
    $idLovedTag=0;
    if ($lovedTag) {
      $idLovedTag = $this->db->insert_id();
    } else {
      $idLovedTag =0;
    }
    return $idLovedTag;
  }


  public function saveTagsForLoved($tags, Loved_model $lovedModel, $idLoved) {
    log_message('info', __METHOD__.' id profile: '.$lovedModel->getProfileId());
    $profileid = $lovedModel->getProfileId();
    if (is_array($tags) && count($tags> 0)) {
      foreach ($tags as $tag) {
        if ($tag != "") {
          log_message('info', __METHOD__.' input tag: '.$tag);
          $tagRow = $this->queryTagOfProfileId($profileid, $tag);
          $idTag =0;
          if ( $tagRow) {
            $idTag = $tagRow->id;
            log_message('info', __METHOD__.' tag exists with id: '.$idTag);
  
          } else {
            $idTag = $this->createTag($profileid, $tag);
            log_message('info', __METHOD__.' new tag created with id: '.$idTag);
          }
          /*
          log_message('info', __METHOD__.' looking for loved, profile: '.$profileid.' videoid '.$videoid);
          $lovedRow = $this->queryLoved($profileid, $videoid);
          $idLoved =0;
          if ( $lovedRow) {
            $idLoved = $lovedRow->id;
            log_message('info', __METHOD__.' loved exists with id:'.$idLoved);
          } else {
            $idLoved = $lovedModel->add();// $this->createLoved($profileid, $videoid, $videotitle, $videothumb);
            log_message('info', __METHOD__.' new loved created with id:'.$idLoved);
          }
          */
  
          $lovedTagRow = $this->queryLovedTag($idLoved, $idTag);
          $idLovedTag =0;
          if ( $lovedTagRow) {
            $idLovedTag = $lovedTagRow->id;
            log_message('info', __METHOD__.' mytag_loved exists:'.$idLovedTag);
          } else {
            $idLovedTag = $this->createLovedTag($idLoved, $idTag);
            log_message('info', __METHOD__.' new mytag_loved created:'.$idLovedTag);
          }
        } else {
          log_message('info', __METHOD__." tag empty");
        }


      }
    }
  }
}