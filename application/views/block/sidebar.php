  <div id="sidebar" class="grid_4 sidebar boxed">
	<div class="sidebar_video_info">
    <div id="videoPlayer" class="video_player">
    <?php $this->load->view("block/howtouse")?>
    </div>
    <div id="videoInfo" class="video_info">
<?php
if ($videoid == "") { 
?>
    <img src="/assets/images/icons/audio_notification.png" width="64" border="0" align="left" />
Cerca un video e poi clicca sull'icona relativa al video per ascoltarlo
<?php
} else {
  echo "Comment:".$title;
   
?>
<iframe title="<?php echo $title?>" width="240" height="195" src="http://www.youtube.com/embed/<?php echo $videoid?>" frameborder="0" allowfullscreen></iframe>
<?php
}
?>
    </div>
   </div>

  </div>
