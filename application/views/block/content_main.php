<div id="tabs">
  <ul>
    <li><a href="#tab-video"><span><?php
    echo img(array("src"=>"assets/images/icons/search.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Cerca brani</span></a></li>
    <li><a href="#tab-playing"><span><?php
    echo img(array("src"=>"assets/images/icons/audio_notification.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Playing</span></a></li>
    <li><a href="index.php/api/mytags"><span><?php
    echo img(array("src"=>"assets/images/icons/star.png", "width"=>"24", "border"=>"0"))
    ?>
    &nbsp;Playlist</span></a></li>
    
  </ul>

  <div id="tab-video">
    <?php $this->load->view("block/search_form")?>
    <div id="searchResultsVideoColumn"> 
    </div>
    <div id="searchResults"> 
    <div id="searchResultsListColumn"> 
      <div id="searchResultsVideoList"> 
        <div id="searchResultsVideoListTable"> 
        </div> 
      </div> 
      <div id="searchResultsNavigation"> 
        <form id="navigationForm"> 
          <input type="button" id="previousPageButton" onclick="ilts.listVideos(ilts.previousSearchTerm, ilts.previousPage);" value="Back" style="display: none;"></input> 
          <input type="button" id="nextPageButton" onclick="ilts.listVideos(ilts.previousSearchTerm, ilts.nextPage);" value="Next" style="display: none;"></input> 
        </form> 
      </div> 
    </div> 
    
  </div>
  <div style="display:none">
  <?php $this->load->view("block/form_add_to_playlist")?>
  </div>
  </div>
  <div id="tab-playing">
  </div>
  <div id="tab-playlist">
  <?php //$this->load->view("block/playlist")?>
  </div>
</div>
