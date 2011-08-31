<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @property Loved_model $Loved_model
* @property Tags_model $Tags_model
*/
class Test extends CI_Controller {
  
  
  function __construct() {
    parent::__construct();
    $this->config->set_item('language', 'english');
    
    $this->load->library('unit_test');
  }
  
  function index() {
    $test = 1 + 1;
    $expected_result = 2;
    $test_name = 'Adds one plus one';
    $this->unit->run($test, $expected_result, $test_name);

    $test = 1 + 1;
    $expected_result = 2;
    $test_name = 'Altro';
    $this->unit->run($test, $expected_result, $test_name);
    
    echo $this->unit->report();
  }
}