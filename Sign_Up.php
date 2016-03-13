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
          <ul class="sf-menu" id="nav">
            <li><a href="Pixr.php">Home</a></li>
            <li><a href="Sign_In.php">Sign In</a></li>
            <li><a href="Sign_up.php">Sign Up</a></li>
           <!--        <li><a href="another_page.php">Another Page</a></li>

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
        <h2>Sign Up Form</h2>
        <form action="controller/UserController.php?action=signup" method="post">
          <div class="form_settings">
            <p><span>Name:</span><input type="text" name="name" id="name" value="" /></p>
			<p><span>E-mail:</span><input type="text"maxlength="25" name="username" id="username" value="<?php if(isset($_REQUEST[
			 'username'])){
			 echo $b = str_replace( "'", '', $_REQUEST['username'] );
			 }?>" placeholder="example@example.com" /></p>
			<p><span>Password:</span><input type="password" maxlength="25" name="password" id="password" value=""placeholder="minimum length is 8" /></p>
			<p><span>Confirm Password:</span><input type="password" maxlength="25"name="confirmpassword" id="confirmpassword" value="" /></p>
			<label for="username" style="color:red;margin-left:210px;"><?php if(isset($_REQUEST[
			 'error'])){
			 echo $b = str_replace( "'", '', $_REQUEST['error'] );
			 }
			 ?></label>
			<!--
            <p><span>Textarea example</span><textarea rows="8" cols="50" name="name"></textarea></p>
            <p><span>Checkbox example</span><input class="checkbox" type="checkbox" name="name" value="" /></p>
            <p><span>Dropdown list example</span><select id="id" name="name"><option value="1">Example 1</option><option value="2">Example 2</option></select></p>-->
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="signin" value="Let Me join" /></p>
          </div>
        </form>
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
