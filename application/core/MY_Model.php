<?php
/**
 * @property CI_DB_active_record $db
 * @author rbutti
 */
class MY_Model extends CI_Model {
  
  const RESULT_OBJECT = 1;
  const RESULT_ARRAY = 2;
  const RESULT_QUERY = 3;
  
  const RESULT_DEFAULT = self::RESULT_OBJECT;
  
  
  function __construct() {
    parent::__construct();
  }
  
  public function add($table, $data) {
    $object = $this->db->insert($table, $data);
    $id=0;
    if ($object) {
      $id = $this->db->insert_id();
    } else {
      $id=0;
    }
    return $id;
  }
  
  public function update($table, $data, $id, $idFieldName="id") {
    $where = array($idFieldName => $id);
    return $this->db->update($table, $data, $where);
  }
  
  /**
   * torna un result vuoto a seconda del tipo di risultato.
   * Un result può essere un object oppure un array.
   * Nel caso di object torna false, nel caso di array torna un array vuoto
   * @param integer $format: può valere self::RESULT_OBJECT oppure self::RESULT_ARRAY
   */
  private function getResultEmpty($format = self::RESULT_DEFAULT) {
    $retVal = false;
    if ($format == self::RESULT_ARRAY) {
      $retVal = array();
    }
    return $retVal;
  }
  
  
  public function getResultOne($query, $format = self::RESULT_DEFAULT) {
    $retVal = $this->getResultEmpty($format);
    if ($query->num_rows() > 0) {
      if ($format == self::RESULT_ARRAY) {
        $retVal = $query->row_array();
      } elseif ($format == self::RESULT_QUERY) {
        $retVal = $query;
      } else {
        $retVal = $query->row();
      }
    }
    return $retVal;
  }
  
  public function getResults($query,  $format = self::RESULT_DEFAULT) {
    $retVal = $this->getResultEmpty($format);
    if ($query->num_rows() > 0) {
      if ($format == self::RESULT_ARRAY) {
        $retVal = $query->result_array();
      } elseif ($format == self::RESULT_QUERY) {
        $retVal = $query;
      } else {
        $retVal = $query->result();
      }
    }
    return $retVal;
  }
  
}