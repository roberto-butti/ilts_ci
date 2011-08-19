<div id="list-playlist" class="list-playlist"><?php
echo "<p>Ecco le tue playlist</p>";
if ($query) {
  echo "<ul class'tag'>";
  foreach ($query->result() as $item) {
    echo "<li><a class='tag' href='#' onclick='loadPlaylist(".$item->id.")'>".$item->tag."</a> (".$item->quanti.")</li>";
  }
  echo "</ul>";
} else {
  echo "No Playlist!!!";
}
?>
<script>
function loadPlaylist(idPlaylist) {
//alert(idPlaylist);
$.ajax({
  url: '/api/tags/load/'+idPlaylist,
  success: function(data) {
  var entries = [];
  entries = videos.loadFromMyTags(data);
  //alert(entries);
  ilts.renderListVideos(entries);
    //alert(data);
    //$('#tab-playing').html(data);
    
  }
});
}
</script>
</div>