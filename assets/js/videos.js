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

/**
 * rappresenta il video corrente
 */
videos.current = {
    "videoid" : "",
    "thumb" : "",
    "title" : "",
    "description" : ""
};

videos.loadPlaylist = function () {
  return "0";
}

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

videos.loadFromMyTags = function (data) {
  var entries = new Array();
  //alert(data);
  //alert(data.length);
  
  //return null;
  for (var i = 0, entry; entry = data[i]; i++) {
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
