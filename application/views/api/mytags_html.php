<div id="list-playlist" class="list-playlist"><?php
echo "<p>Ecco le tue playlist</p>";
if ($query) {
  echo "<ul class'tag'>";
  foreach ($query->result() as $item) {
    echo "<li><a class='tag' href='#' onclick='loadPlaylist(".$item->id.")'>".$item->tag."</a></li>";
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
  url: 'index.php/api/tags/load/'+idPlaylist,
  success: function(data) {
    //alert(data);
    $('#tab-playing').html(data);
    
  }
});
}
</script>
</div>