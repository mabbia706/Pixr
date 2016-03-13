<?php session_start();?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Pixr</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script type="text/javascript" src="./fbapp/fb.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="Pixr.php"><span class="logo_colour">Pixr</span></a></h1>
          <h2>An Amazing Experience of Photo Sharing</h2>
        </div>
      </div>
      <nav>
        <div id="menu_container">
	  <!--<p>?></p>-->
          <ul class="sf-menu" id="nav">
            <li><a href="Pixr.php">Home</a></li>
            <li><a href="Sign_In.php">Sign In</a></li>
            <li><a href="Sign_Up.php">Sign Up</a></li>
			<li><a href="phpflickr-master/flickr_auth.php">Sign_In With Flickr</a></li>
	
			<li><a href=""><div class="fb-login-button" data-scope="public_profile,email"onlogin="checkLoginState();"></div></a>&nbsp; &nbsp;</li>
            <!--
			<li><a href="#">Example Drop Down</a>
              <ul>
                <li><a href="#">Drop Down One</a></li>
                <li><a href="#">Drop Down Two</a>
                  <ul>
                    <li><a href="#">Sub Drop Down One</a></li>
                    <li><a href="#">Sub Drop Down Two</a></li>
                    <li><a href="#">Sub Drop Down Three</a></li>
                    <li><a href="#">Sub Drop Down Four</a></li>
                    <li><a href="#">Sub Drop Down Five</a></li>
                  </ul>
                </li>
                <li><a href="#">Drop Down Three</a></li>
                <li><a href="#">Drop Down Four</a></li>
                <li><a href="#">Drop Down Five</a></li>
              </ul>
            </li>
            <li><a href="contact.php">Contact Us</a></li>-->
          </ul>
        </div>
      </nav>
    </header>
    <div id="site_content">
      <div id="sidebar_container">
        <div class="sidebar">
          <!--<h3>Latest News</h3>
          <h4>New Website Launched</h4>
          <h5>January 1st, 2012</h5>
          <p>2012 sees the redesign of our website. Take a look around and let us know what you think.<br /><a href="#">Read more</a></p>
        </div>
        <div class="sidebar">
          <h3>Useful Links</h3>
          <ul>
            <li><a href="#">First Link</a></li>
            <li><a href="#">Another Link</a></li>
            <li><a href="#">And Another</a></li>
            <li><a href="#">One More</a></li>
            <li><a href="#">Last One</a></li>
          </ul>-->
        </div>
      </div>
      <div class="content">
        <h1>Welcome to the world of photo sharing</h1>
        <p><strong>Where User can create and join groups.</strong></p>
		<p><strong>Users and Groups can produce albums</strong></p>
		<p><strong>Photo can be part of multiple albums</strong></p>
        <p><strong>Users can view slideshow of photos in an album</strong></p>
        <p><strong>Users can search photos based upon tags and label</strong></p>
       <p><strong>Users can comment on a photo</strong></p>
	   </div>
    </div>
    <footer>
      <p>Share Your Experience | <a href="Pixr.php">Pixr</a></p>
    </footer>
  </div>
  <p>&nbsp;</p>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>



