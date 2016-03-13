<!DOCTYPE HTML>
<?php session_start()?>
<html>

<head>
  <title>Pixr</title>
   
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
   <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
 <!-- modernizr enables HTML5 elements and feature detects -->
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dropdown.js"></script>
<script type="text/javascript" src="js/Profile.js"></script>

<div id='1234'style="display:none;"><?php if (isset($_SESSION["user"])||isset($_SESSION["Flickr"])||isset($_SESSION["name"])){
echo str_replace("'",'',$_REQUEST["email"]);

}

?></div> 
<script type="text/javascript">

var user = document.getElementById("1234");
var pageContent = user.innerHTML; 
sessionStorage.setItem("page1content", pageContent);

$(document).ready(function() { 

$('#cover_link').click(function(e){
document.getElementById('dialogcover').src=document.getElementById('cover_photo').src;
$("#coverpopup").dialog({
	title:"Cover Photo",
	width:960,
	height:400,
	modal:true,
	buttons:{
		
		Close:
		function(){
		$(this).dialog('close');
		}
	
	}
	
	});


});

$('#profile_photo_link').click(function(e){

document.getElementById('dialogpropic').src=document.getElementById('profile_photo').src;
$("#propicpopup").dialog({
	title:"Profile Photo",
	width:550,
	height:660,
	modal:true,
	buttons:{
		Close:
		function(){
		$(this).dialog('close');
		}
	
	}
	
	});


});

});


</script>
 
  
</head>
<body onload="loadProfile('content_id')">
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="Pixr.php"><span class="logo_colour">Pixr</span></a></h1>
          <h2><?php 
		  if (isset($_SESSION["user"])||isset($_SESSION["Flickr"])||isset($_SESSION["name"])){
		  echo "Welcome ".str_replace("'",'',$_REQUEST["name"]);
		  }
		  else{
		  echo "logged out";
		  }
		  ?></h2>
        </div>
      </div>
      <nav>
        <div id="menu_container">
		  <ul class="sf-menu" id="nav">
            <li><a href="Profile.php?name='<?php echo str_replace("'",'',$_REQUEST["name"]);?>''&email='<?php echo str_replace("'",'',$_REQUEST["email"]);?>'">Profile</a></li>
            <!--<li><a href="">Explore</a></li>-->
            
			<li><a href="Groups.php?name='<?php echo str_replace("'",'',$_REQUEST["name"]);?>''&email='<?php echo str_replace("'",'',$_REQUEST["email"]);?>'">Groups</a>
              <!--<ul>
                <li><a href="#">Create Group</a></li>
                <li><a href="#">Groups Created</a>
                  <ul>
                    <li><a href="#">Sub Drop Down One</a></li>
                    <li><a href="#">Sub Drop Down Two</a></li>
                    <li><a href="#">Sub Drop Down Three</a></li>
                    <li><a href="#">Sub Drop Down Four</a></li>
                  </ul>
                </li>
                <li><a href="#">Groups Joined</a></li>
              </ul>-->
            </li>
            <!--<li><a href="contact.php">Contact Us</a></li>-->
			
            <li><a href="demo_upload/multiupload.php?name='<?php echo str_replace("'",'',$_REQUEST["name"]);?>'&email='<?php echo str_replace("'",'',$_REQUEST["email"]);?>'">Upload Images</a></li>
			<li><a href="controller/UserController.php?action=logout">Sign Out</a></li> 
		  </ul>
		  
		  
        </div>
      </nav>
    </header>
    <div id="site_content">
      <div class="content"id="content_id">
		<div id="coverPhoto">
		<a href="#" id="cover_link"><img src="" id="cover_photo"></img></a>
		<a href="#" id="profile_photo_link"><img src="" id="profile_photo"></img></a>
		</div>
		
		<div id="coverpopup" class="form_settings"style="display:none;">
			<img src="" id="dialogcover" width="930px" height="200px" /><br>
				Choose Photo from  Photo Stream to change Cover Photo.
		</div>
		<div id="propicpopup" class="form_settings"style="display:none;">
			<img src="" id="dialogpropic" width="500px" height="500px" /><br>
			Choose Phooto from Photo Stream to change Profile Photo.
		</div>
		
		</div>
    	
		</div>
	

    <footer>
    <p>Share Your Experience | <a href="Pixr.php">Pixr</a></p>
   
	</footer>
  </div>
  <p>&nbsp;</p>
  <!-- javascript at the bottom for fast page loading 
  <script type="text/javascript" src="js/jquery.js"></script>-->
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>






