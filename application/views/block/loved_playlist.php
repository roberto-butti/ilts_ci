<?php
if ($query) {
  echo "<ul class='tag' >";
  foreach ($query->result() as $item) {
    echo "<li >
      <a class='tag' href='#' onclick='videos.loadPlaylist(".$item->id."); return false;'>".$item->tag."</a> (".$item->quanti.")
      
    </li>";
  }
  echo "</ul>";
?>
<script>
/*
  $(function() {
    $( "#selectable" ).selectable();
  });
  */
  </script>
<?php 
} else {
  echo "No Playlist!!!";
}