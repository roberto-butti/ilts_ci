<div id="searchBox"> 
  <form id="searchForm" onsubmit="ilts.listVideos( this.searchTerm.value, 1); return false;"> 
    <input class="txtSearch" id="txtSearch" name="searchTerm" type="text" value="<?php echo $q;?>">
<script>
$(function() {
  $("#txtSearch").focus();
});
</script>
    <input class="cmdFormSearch" type="submit" id="cmdSearch" value="<?php echo $this->lang->line('ilts_search');?>">
    <br />
    <!-- 
    <input class="cmdFormSearch" type="button" id="cmdShareSearch" value="<?php echo $this->lang->line('ilts_share');?>"> 
    <input class="cmdFormSearch" type="button" id="cmdSuggestMe" value="<?php echo $this->lang->line('ilts_hint');?>">
     --> 
  </form> 
</div>