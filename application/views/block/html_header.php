<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->load->view("block/header/stylesheets");?>
<?php $this->load->view("block/header/javascripts");?>
<?php echo link_tag('/assets/favicon.ico', 'shortcut icon', 'image/ico'); ?>
<title>I Love These Songs!!!</title>
<script type="text/javascript">
WebFont.load({
    google: {
      families: ['Nobile']
    }
  });
</script>
<style type="text/css">

</style>
<script>
  $(document).ready(function() {
    $("#tabs").tabs({ selected: 0 });
    $("#cmdSearch").button();
    $("#cmdShareSearch").button();
    $("#cmdSuggestMe").button();
    /*
    $("#txtSearch").autocomplete({
        source: function( request, response ) {
          return ilts.autocompleteSearch(request, response);
        },
        minLength: 2
      });
    */
    
  });
  </script>
  
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20260866-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
