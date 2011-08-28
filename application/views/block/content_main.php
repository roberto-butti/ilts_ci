<div id="tabs">
<?php echo lang('ilts_whatyou')?>...
  <ul>
    <li><a href="#tab-video"><span><?php
      echo img(array("src"=>"/assets/images/icons/search.png", "width"=>"24", "border"=>"0")) ?>
      &nbsp;...<?php echo lang('ilts_whatyousearch')?></span></a>
    </li>
    <li><a href="#tab-playing"><span><?php
      echo img(array("src"=>"/assets/images/icons/audio_notification.png", "width"=>"24", "border"=>"0"))?>
      &nbsp;...<?php echo lang('ilts_whatyouplaying')?></span></a>
    </li>
    <li><a title="tab-playlist" href="<?php echo generate_url_from_routing("api/mytags");?>"><span><?php
      echo img(array("src"=>"/assets/images/icons/heart_full.png", "width"=>"24", "border"=>"0"))?>
      &nbsp;...<?php echo lang('ilts_whatyoulove')?></span></a>
    </li>
  </ul>

  <div id="tab-video">
    <?php $this->load->view("block/search_form")?>
    <?php $this->load->view("block/search_result")?>
  </div>
  <div id="tab-playing">
  PLAYING
  </div>
  <div id="tab-playlist">
  <?php //$this->load->view("block/playlist")?>
  </div>
</div>
