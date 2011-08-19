<div id="tabs">
  <ul>
    <li><a href="#tab-video"><span><?php
    echo img(array("src"=>"/assets/images/icons/search.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Cerca brani</span></a></li>
    <li><a href="#tab-playing"><span><?php
    echo img(array("src"=>"/assets/images/icons/audio_notification.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Playing</span></a></li>
    <li><a href="/api/mytags"><span><?php
    echo img(array("src"=>"/assets/images/icons/star.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Playlist</span></a></li>
    
  </ul>

  <div id="tab-video">
    <?php $this->load->view("block/search_form")?>

  </div>
  <div id="tab-playing">
  </div>
  <div id="tab-playlist">
  <?php //$this->load->view("block/playlist")?>
  </div>
    <?php $this->load->view("block/search_result")?>
</div>
