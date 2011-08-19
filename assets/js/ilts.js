var ilts = {};

ilts.MAX_RESULTS_LIST = 10;
ilts.VIDEO_FEED_URL = 'http://gdata.youtube.com/feeds/api/videos';
ilts.VIDEO_LIST_TABLE_CONTAINER_DIV = 'searchResultsVideoList';
ilts.VIDEO_LIST_CSS_CLASS = 'videoList';
ilts.THUMBNAIL_WIDTH = 80;
ilts.THUMBNAIL_HEIGHT = 72;
ilts.VIDEO_PLAYER_WIDTH = 225;
ilts.VIDEO_PLAYER_HEIGHT = 185;
ilts.jsonFeed_ = null;
ilts.FLASH_MIME_TYPE = 'application/x-shockwave-flash';
ilts.VIDEO_PLAYER_DIV = 'videoPlayer';
ilts.PREVIOUS_PAGE_BUTTON = 'previousPageButton';
ilts.NEXT_PAGE_BUTTON = 'nextPageButton';
ilts.VIDEO_DESCRIPTION_CSS_CLASS = 'video_description';
ilts.nextPage = 2;
ilts.previousPage = 0;
ilts.previousSearchTerm = '';

ilts.autocompleteSearch = function(request, response) {
  var termSearch = request.term;
  var url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20music.artist.search%20where%20keyword%3D'" + termSearch + "'&format=json";
  $.ajax({
    url: url,
    dataType: 'jsonp',
    success: function(data ) {
      if (response.query != 'undefined' && data.query.results != null) {
      response($.map(data.query.results.Artist, function(item ) {
        return {
          label: item.name,
          value: item.name
        };
      }));
      }
    }
  });
};

/**
 * fa il render dei video elencati nell'array entries
 * Ciascuna posizione dell'array  definita come object:
 * entry.title
 * entry.thumb
 * entry.description
 * entry.videoid
 */
ilts.renderListVideos = function(entries, updateDiv) {
  updateDiv = typeof(updateDiv) != 'undefined' ? updateDiv : 'searchResultsVideoListTable';
  var resultsTableContainer = document.getElementById(updateDiv);
  while (resultsTableContainer.childNodes.length >= 1) {
    resultsTableContainer.removeChild(resultsTableContainer.firstChild);
  }
  var resultsTable = document.createElement('table');
  resultsTable.setAttribute('class', ilts.VIDEO_LIST_CSS_CLASS);
  var tbody = document.createElement('tbody');
  resultsTable.setAttribute('width', '100%');
  resultsTableContainer.appendChild(resultsTable);
  //$.each(feed.data.items, function (i, item) {
  $.each(entries, function(i, item) {
    //alert(item.title);
    ilts.appendVideoDataToTable(tbody, item, i);
  }); // FINE DEL EACH
  resultsTable.appendChild(tbody);

  $('a.links_add_video').fancybox({
    'width' : '75%',
    'height' : '75%',
    'autoScale' : false,

  'transitionIn' : 'elastic',
  'transitionOut' : 'elastic',
  'speedIn' : 600,
  'speedOut' : 200
  });
};

ilts.listVideos = function(searchTerm, page) {
  ilts.previousSearchTerm = searchTerm;
  var queryUrl = ilts.VIDEO_FEED_URL;
  if (queryUrl) {
    queryUrl += '?max-results=' + ilts.MAX_RESULTS_LIST +
        '&start-index=' + (((page - 1) * ilts.MAX_RESULTS_LIST) + 1);
    if (searchTerm != '') {
      queryUrl += '&q=' + searchTerm;
    }
    queryUrl += '&v=2&format=5&alt=jsonc';
    //alert(queryUrl);
    $.getJSON(queryUrl, function(feed) {
      ilts.jsonFeed_ = feed.data;

      var entries = [];
      entries = videos.loadFromYoutube(feed.data);
      /*
      var entries = new Array();
      //alert("here");
      for (var i = 0, entry; entry = feed.data.items[i]; i++) {
        var obj = new Object();
        obj.title = entry.title;
        obj.thumb = entry.thumbnail.sqDefault;
        obj.description = entry.description;
        obj.videoid = entry.id;
        //alert(i+" "+entry.title);
        entries[i] = obj;
      }
      */


      ilts.renderListVideos(entries);
      ilts.updateNavigation(page);

    });
  } else {
    alert('Unknown feed type specified');
  }

};



/**
 * Creates a script tag for retrieving a Google data JSON feed and and
 * adds it into the html head.
 * @param {String} scriptSrc The URL for the script, assumed to already have at
 *     least one query parameter, so the '?' is not added to the URL.
 * @param {String} scriptId The id to use for the script tag added to the head.
 * @param {String} scriptCallback  The callback function to be used after the
 *     JSON is retrieved.  The JSON is passed as the first argument to the
 *     callback function.
 */
ilts.appendScriptTag = function(scriptSrc, scriptId, scriptCallback) {
  // Remove any old existance of a script tag by the same name
  var oldScriptTag = document.getElementById(scriptId);
  if (oldScriptTag) {
    oldScriptTag.parentNode.removeChild(oldScriptTag);
  }
  // Create new script tag
  var script = document.createElement('script');
  script.setAttribute('src',
      scriptSrc + '&alt=json-in-script&callback=' + scriptCallback);
  script.setAttribute('id', scriptId);
  script.setAttribute('type', 'text/javascript');
  // Append the script tag to the head to retrieve a JSON feed of videos
  // NOTE: This requires that a head tag already exists in the DOM at the
  // time this function is executed.
  document.getElementsByTagName('head')[0].appendChild(script);
};

/**
 * fa il render dei pulsanti di navigazione
 */
ilts.updateNavigation = function(page) {
  ilts.nextPage = page + 1;
  ilts.previousPage = page - 1;
  document.getElementById(ilts.NEXT_PAGE_BUTTON).style.display = 'inline';
  document.getElementById(ilts.PREVIOUS_PAGE_BUTTON).style.display = 'inline';
  if (ilts.previousPage < 1) {
    document.getElementById(ilts.PREVIOUS_PAGE_BUTTON).disabled = true;
  } else {
    document.getElementById(ilts.PREVIOUS_PAGE_BUTTON).disabled = false;
  }
  document.getElementById(ilts.NEXT_PAGE_BUTTON).disabled = false;
};


/**
 * fa il render dell singolo item video:
 * entry.title
 * entry.description
 * entry.thumb
 * entry.videoid
 */
ilts.appendVideoDataToTable = function(tbody, entry, entryIndex) {
  var tr = document.createElement('tr');

  var thumbnailTd = document.createElement('td');
  thumbnailTd.setAttribute('width', ilts.THUMBNAIL_WIDTH);
  var thumbnailImage = document.createElement('img');
  thumbnailImage.setAttribute('src', entry.thumb);
  thumbnailImage.setAttribute('width', ilts.THUMBNAIL_WIDTH);
  thumbnailImage.setAttribute('height', ilts.THUMBNAIL_HEIGHT);
  thumbnailTd.appendChild(thumbnailImage);

  var metadataTd = document.createElement('td');
  metadataTd.setAttribute('class', 'video_descr');
  metadataTd.setAttribute('width', '350');
  var titlePara = document.createElement('p');
  titlePara.setAttribute('class', 'video_title');
  titlePara.innerHTML = entry.title;

  var descPara = document.createElement('p');
  descPara.innerHTML = (entry.description).substring(0, 100);
  descPara.setAttribute('class', ilts.VIDEO_DESCRIPTION_CSS_CLASS);
  metadataTd.appendChild(titlePara);
  metadataTd.appendChild(descPara);
  var operationTd = document.createElement('td');
  operationTd.setAttribute('class', 'video_operation');
  operationTd.setAttribute('width', '100');
  var videoId = entry.videoid;
  //var videoId=entry.yt$videoid.$t;
  //ilts.showMessage(videoId);
  //operationTd.innerHTML = "<a class=\"links_add_video\" href=\"#\" id=\"add_video_"+videoId+"\"><img src=\"assets/icons/button_pink_heart.png\"></a>"+
  //"<a class=\"links_play_video\" href=\"#\" id=\"play_video_"+videoId+"\"><img src=\"assets/icons/audio_notification.png\"></a>";

  /*
  var buttonAddVideo = document.createElement('a');
  buttonAddVideo.setAttribute('href', '#data');
  buttonAddVideo.setAttribute('class', 'links_add_video');
  buttonAddVideo.setAttribute('id', 'add_video_' + videoId);
  buttonAddVideo.innerHTML = '<img src=\"/assets/images/icons/button_pink_heart.png\">';
  buttonAddVideo.onclick = ilts.generateAddVideoLinkOnclick(entry, entryIndex,
      ilts.REFERRING_FEED_TYPE_MAIN
      //ilts.currentReferringFeedType
  );
  */
  var buttonAddVideo = ilts.renderAddVideoLink(videoId, entry, entryIndex);

  var buttonPlayVideo = document.createElement('a');
  buttonPlayVideo.setAttribute('href', '#');
  buttonPlayVideo.setAttribute('class', 'links_play_video');
  buttonPlayVideo.setAttribute('id', 'play_video_' + videoId);
  buttonPlayVideo.innerHTML = '<img src=\"/assets/images/icons/audio_notification.png\">';
  buttonPlayVideo.onclick = ilts.generatePlayVideoLinkOnclick(entry.videoid, entryIndex,
		  ilts.REFERRING_FEED_TYPE_MAIN
		  //ilts.currentReferringFeedType
  );

  operationTd.appendChild(buttonAddVideo);
  operationTd.appendChild(buttonPlayVideo);

  tr.appendChild(thumbnailTd);
  tr.appendChild(metadataTd);
  tr.appendChild(operationTd);
  tbody.appendChild(tr);

  $('a#add_video_' + videoId).fancybox({
    'width' : '75%',
    'height' : '75%',
    'autoScale' : false,
    'transitionIn' : 'none',
    'transitionOut' : 'none',
  'transitionIn' : 'elastic',
  'transitionOut' : 'elastic',
  'speedIn' : 600,
  'speedOut' : 200
  });
};


ilts.showMessage = function(message) {
  alert(message);
};
/*
ilts.openFormAddSong = function() {
  $(".links_add_video").dialog();
}
*/

ilts.renderAddVideoLink = function(videoId, entry, entryIndex) {
  var buttonAddVideo = document.createElement('a');
  buttonAddVideo.setAttribute('href', '#data');
  buttonAddVideo.setAttribute('class', 'links_add_video');
  buttonAddVideo.setAttribute('id', 'add_video_' + videoId);
  buttonAddVideo.innerHTML = '<img src=\"/assets/images/icons/button_pink_heart.png\">';
  buttonAddVideo.onclick = ilts.generateAddVideoLinkOnclick(entry, entryIndex,
      ilts.REFERRING_FEED_TYPE_MAIN
      //ilts.currentReferringFeedType
  );
  return buttonAddVideo;
}

/**
 * Returns a function that can be added as an event handler for playing
 * a video upon the firing of the event.
 * @param {String} videoUrl The URL of the video to play
 * @param {Number} entryIndex The index of the entry in the referring feed
 * @param {String} referringFeed The referring feed
 * @return {Function} The video playing function
 */
ilts.generatePlayVideoLinkOnclick = function(videoId, 
                                             entryIndex, 
                                             referringFeed) {
  return function() {
    $('#videoInfo').html("Loading video...");
    ilts.playVideo(entryIndex, referringFeed);
    var likeSocialPlugin = '<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D' + videoId + '&amp;layout=box_count&amp;show_faces=true&amp;width=300&amp;action=like&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>';
    
    
    $('#videoInfo').html(likeSocialPlugin);
    return false;
  };
};

ilts.generateAddVideoLinkOnclick = function(entry, entryIndex, referringFeed) {
  return function() {
    //entry = ilts.jsonFeed_.items[entryIndex];
    $('#savetag_videoid').val(entry.videoid);
    $('#savetag_title').html(entry.title);
    $('#savetag_videotitle').val(entry.title);
    $('#savetag_videothumb').val(entry.thumb);
    var img = "<img src='" + entry.thumb + "'>";
    $('#savetag_thumb').html(img);
    return false;
  };
};

ilts.findMediaContentHref = function(entry, type) {
  for (var i = 0, content; content = entry.media$group.media$content[i]; i++) {
    if (content.type == type) {
      return content.url;
    }
  }
  // a media:content element with the specified MIME type was not found
  return null;
};


/**
 * Adds the object and embed tags to play the specified video
 * @param {Number} entryIndex The index of the video in the referring feed.
 * @param {String} referringFeed Name of the referring feed.
 */
ilts.playVideo = function(entryIndex, referringFeed) {
  var entry;
  try {
    //entry = ilts.jsonFeed_.items[entryIndex];
    entry = videos.list[entryIndex];
    //videoHref = entry.content[5];
    //http://www.youtube.com/v/1CydZtP_XlA?f=videos&app=youtube_gdata
    videoHref = "http://www.youtube.com/v/"+entry.videoid+"?f=videos&app=youtube_gdata";
    
    var videoPlayerDiv = document.getElementById(ilts.VIDEO_PLAYER_DIV);
    var html = [];
    html.push('<b>');
    html.push(entry.title);
    html.push('</b><br />');
    html.push('<object width="' + ilts.VIDEO_PLAYER_WIDTH + '" height="' + ilts.VIDEO_PLAYER_HEIGHT + '"><param name="movie" value="');
    html.push(videoHref);
    html.push('&autoplay=1"></param><param name="wmode" value="transparent">');
    html.push('</param><embed src="');
    html.push(videoHref);
    html.push('&autoplay=1" type="application/x-shockwave-flash" ');
    html.push('wmode="transparent" width="' + ilts.VIDEO_PLAYER_WIDTH + '" height="' + ilts.VIDEO_PLAYER_HEIGHT + '"></embed></object>');
    videoPlayerDiv.innerHTML = html.join('');
  } catch (err) {
    alert(err);
  }
};

/**
 * Callback function used for processing the results of ytvb.listVideos.
 * This function calls appendVideoData to list each of the videos in the UI
 * @param {Object} data The object obtained by evaluating the JSON text
 *     returned by the YouTube data API.
 */
ilts.listVideosCallback = function(data) {
  // Stores the json data returned for later lookup by entry index value
  ilts.jsonFeed_ = data.feed;
  ilts.currentReferringFeedType = ilts.REFERRING_FEED_TYPE_MAIN;
  ilts.renderTableResults(ilts.VIDEO_LIST_TABLE_CONTAINER_DIV, data.feed);

  $('.links_add_video').fancybox({
      'width' : '75%',
      'height' : '75%',
      'autoScale' : false,
      'transitionIn' : 'none',
      'transitionOut' : 'none',
      'type': 'iframe'
    });
};

