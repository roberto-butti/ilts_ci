var videos = {};
videos.VERSION = "1.0";
/**
 * Lista dei video
 */
videos.list = {};

videos.SELECTED_NONE = 0;
videos.SELECTED_SEARCH = 1;
videos.SELECTED_PLAYLIST = 2;
videos.lastSelected = videos.SELECTED_NONE;

videos.lastQuerySearch = "";

videos.currentPlaylist = {};
videos.currentPlaylistLoaded = false;

videos.lovedPlaylist = {}
videos.lovedLoaded = false
videos.lovedLastPlaylistSelected = -1;

/**
 * rappresenta il video corrente
 */
videos.current = {
    "videoid" : "",
    "thumb" : "",
    "title" : "",
    "description" : ""
};


videos.loadFromYoutube = function (feeddata) {
  var entries = new Array();
  for (var i = 0, entry; entry = feeddata.items[i]; i++) {
    var obj = new Object();
    obj.title = entry.title;
    obj.thumb = entry.thumbnail.sqDefault;
    obj.description = entry.description;
    obj.videoid = entry.id;
    //alert(i+" "+entry.title);
    entries[i] = obj;
  }
  
  videos.list = entries;
  return entries;
}


videos.loadMytags = function (idPlaylistselected) {
  $.ajax({
    url: '/api/mytags/htmltag',
    success: function(data) {
      $("#loved_playlist").html(data);
    }
  });
  
}

videos.loadPlaylist = function (idPlaylist) {
//alert(idPlaylist);
// api/loved/my/
  
$.ajax({
  url: '/api/tags/load/'+idPlaylist,
  success: function(data) {
  videos.lovedLastPlaylistSelected = idPlaylist;
  var entries = [];
  entries = videos.loadFromMyTags(data);
  var urlPlayAll = "<a href='/ilove/"+data.tag.slug+"'>LISTEN</a>";
  $("#loved_current_title").html(data.tag.pre_title+'&nbsp;<em>'+data.tag.tag+'</em> '+urlPlayAll);
  //alert(entries);
  ilts.renderListVideos(entries, "lovedResultsVideoListTable");
    //alert(data);
    //$('#tab-playing').html(data);
    
  }
});

}

videos.loadFromMyTags = function (data) {
  var entries = new Array();
  //alert(data);
  //alert(data.length);
  
  //return null;
  for (var i = 0, entry; entry = data.list[i]; i++) {
    var obj = new Object();
    obj.id = entry.id;
    obj.profileid = entry.profile_id;
    obj.title = entry.title;
    obj.thumb = entry.thumb;
    obj.description = entry.title;
    obj.videoid = entry.videoid;
    //alert(i+" "+entry.title);
    entries[i] = obj;
  }
  videos.list = new Array();
  videos.list = entries;
  return entries;
  
}

videos.loadLoved = function (data) {
  if ( ! videos.lovedLoaded) {
    $('#tab-playlist').html(data);
    videos.lovedLoaded = true;
  } else {
    videos.loadMytags(videos.lovedLastPlaylistSelected);
    if (videos.lovedLastPlaylistSelected >0) {
      videos.loadPlaylist(videos.lovedLastPlaylistSelected);
    }
  }
  
}
