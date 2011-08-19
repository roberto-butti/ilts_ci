<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access  public
 * @param string
 * @return  string
 */
if ( ! function_exists('generate_url_from_routing'))
{
  function generate_url_from_routing($uri = '') {
    /*
    $CI =& get_instance();
    return $CI->config->site_url($uri);
    */
    return "/".$uri;
  }
}
