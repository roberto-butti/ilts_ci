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