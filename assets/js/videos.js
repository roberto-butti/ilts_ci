var videos = {};
videos.VERSION = "1.0";
/**
 * Lista dei video
 */
videos.list = {};

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
    obj.description = entry.description;
    obj.videoid = entry.videoid;
    //alert(i+" "+entry.title);
    entries[i] = obj;
  }
  
  videos.list = entries;
  return entries;
  
}
