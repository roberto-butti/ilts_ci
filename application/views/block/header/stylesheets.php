<?php 
echo link_tag('assets/css/grid.css');
echo link_tag('assets/css/main.css');
echo link_tag('assets/css/colors.css');
$url_css = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css';
if (ENVIRONMENT == "development") {
  $url_css = '/assets/jquery/css/smoothness/jquery-ui-1.8.16.custom.css';
}
echo link_tag($url_css);
echo link_tag('http://fonts.googleapis.com/css?family=Lobster|Nobile');
echo link_tag('assets/js/fancybox/jquery.fancybox-1.3.4.css');
//echo link_tag('assets/js/tagit/css/reset.css');
//echo link_tag('assets/js/tagit/css/master.css');
//echo link_tag('assets/js/tagit/css/jquery-ui/jquery.ui.autocomplete.custom.css');
echo link_tag('assets/js/jqueryautocomplete/jquery.autocomplete.css');


?>
