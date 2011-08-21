<div id="login_box" class="grid_3 login">
  <div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init(
    	    {
        	    appId: '<?php echo $this->config->item("ilts_fb_app_id");?>',
        	    status: true,
        	    cookie: <?php echo $this->config->item("ilts_fb_cookie");?>,
        	    channelUrl  : '<?php echo $this->config->item("ilts_fb_app_channel_url");?>', 
                xfbml: true,
                oauth : true
             }
    );
    FB.Event.subscribe('auth.login', function(response) {
      // do something with response
      login();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      // do something with response
      logout();
    });
    FB.getLoginStatus(function(response) {
      if (response.authResponse) {
        login();
        // logged in and connected user, someone you know
      } else {
        logout();
        // no user session available, someone you dont know
      }
    });

    

    
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
  


  function login(){
    FB.api('/me', function(response) {
      //document.getElementById('login').style.display = "block";
      //dobbiamo fare il redirect
      $('#facebook_login_status').html("Ciao, "+response.name+"!<br />")
    });
    var query= $('#txtSearch').val();
    //alert(query);
    if (query == "") {
      FB.api('/me/music?limit=10', function(response) {
        var rispostaMusicFb = "";
        $.each(response.data, function(key, value) { 
          rispostaMusicFb = rispostaMusicFb+ "<div class='music_suggestion_fb'>"+value.name+"</div>";
        });
        $('#searchResultsVideoListTable').html(rispostaMusicFb);
        $('.music_suggestion_fb').bind('click', function() {
          //alert('User clicked on "foo."');
          //alert(this.innerHTML);
          $('#txtSearch').val(this.innerHTML);
          // Bound handler called.
        });
        /*
        $('#music_suggestion_fb').click(function() {
          alert(this.val());
          $('#txtSearch').val(this.html());
          // Bound handler called.
        });
        */
      });
      
        
    }
  }
  function logout(){
    $('#facebook_login_status').html("Effettua la connessione a Facebook!")
  }
</script>
<div id="facebook_login_status">
    Log in :)
    </div>
<fb:login-button autologoutlink="true" ></fb:login-button>
  </div>