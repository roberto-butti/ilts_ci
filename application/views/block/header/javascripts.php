<?php
$url_jquery = "https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js";
$url_jquery_ui = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js";
$wannaLocal = ENVIRONMENT == "development";
$wannaLocal = true;
if ($wannaLocal) {
  $url_jquery = "/assets/jquery/js/jquery-1.6.2.min.js";
  $url_jquery_ui = "/assets/jquery/js/jquery-ui-1.8.16.custom.min.js";
}
?>
<script
  src="<?php echo $url_jquery;?>"
  type="text/javascript"></script>
<script
  src="<?php echo $url_jquery_ui;?>"
  type="text/javascript"></script>
  
<!-- 
<script
  src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.16/webfont.js"
  type="text/javascript"></script>
 -->
<script
  src="assets/js/ilts.js"
  type="text/javascript"></script>
<script
  src="assets/js/videos.js"
  type="text/javascript"></script>
  
  
<script type="text/javascript" src="assets/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<!-- 
<script
  src="assets/js/jqueryautocomplete/jquery.autocomplete.pack.js"
  type="text/javascript"></script>
  -->

<!-- script src="assets/js/tagit/js/tag-it.js" type="text/javascript" charset="utf-8"></script> -->



