<?php
/**
 * @property CI_DB_active_record $db
 * @author rbutti
 */
class MY_Model extends CI_Model {
  
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
}