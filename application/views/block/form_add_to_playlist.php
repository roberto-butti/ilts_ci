
<div id="data" align="center"> 
Ehi! Do you love this Song? 
<div id="savetag_thumb"></div>
<div id="savetag_title"></div>
    <form id="formsavetag" action="<?php echo generate_url_from_routing("api/tags/add");?>" method="post"  class="myform" accept-charset="utf-8">
    <label for="tags">Playlist</label>
    <br />
    <input type="text" id="tagsauto" name="mytags" />
    <ul id="mytags"></ul>
    <input name="videoid" type="hidden" value="" id="savetag_videoid" />
    <input name="videothumb" type="hidden" value="" id="savetag_videothumb" />
    <input name="videotitle" type="text" value="" id="savetag_videotitle" />
    <br />
    <input type="submit" value="I love this song!!!" id="buttonsavetag" />
    </form>
    

</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
  $("#tagsauto").autocomplete({
    source: "<?php echo generate_url_from_routing("api/mytags/autocomplete");?>",
    width: 320,
    max: 10,
    minLength: 1,
    multiple: false,
    //multipleSeparator: ",",
    scroll: true,
    scrollHeight: 300
  });
});

$('#formsavetag').submit(function(event) {
  // stop form from submitting normally
  event.preventDefault();
  // get some values from elements on the page:
  var form = $( this );
  var url = form.attr( 'action' );
  //alert($("input#savetag_videoid").val());
  // Send the data using post and put the results in a div
  $.post( url, form.serialize() ,
    function( data ) {
    //alert(data);
    $.fancybox.close();
    }
  );
});
</script>  