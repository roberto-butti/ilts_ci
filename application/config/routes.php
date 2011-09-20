<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['api/mytags'] = "api/mytags/html";
$route['api/mytags/(json|htmltag)'] = "api/mytags/$1";

$route['api/tags/add'] = "api/addtags";
// carica le canzoni relative al TAG con ID specificato
$route['api/tags/load/(:any)'] = "api/loadtag/$1";

$route['api/loved/my/(:any)'] = "api/mylovedbyvideoid/$1";

// api che ritorna l'elenco delle canzoni di una playlist con slug in input
// torna un json
$route['api/playlist/(:any)'] = "api/loadtagbyslug/$1";

$route['ilove/(:any)'] = "playlist/ilove/$1";
$route['default_controller'] = "main";

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */