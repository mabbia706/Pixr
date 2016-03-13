<html>
<head>
<title>Pixr</title>

<meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<!-------Including jQuery from Google ------>

<script type="text/javascript" src="../js/modernizr-1.5.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!------- Including CSS File ------>
<link rel="stylesheet" type="text/css" href="uploadstyle.css">

<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="script.js"></script>
<script>

</script>
</head>
<body>

 <div id="main">
	<header>
		<div id="logo">
			<div id="logo_text">
				<h1><a href="../Pixr.php"><span class="logo_colour">Pixr</span></a></h1>
				 <h2 >Welcome <?php echo str_replace("'",'',$_REQUEST["name"]);?></h2>
				 <div id="user"style="display:none;"><?php echo str_replace("'",'',$_REQUEST["email"]);?></div>
				  </div>
      </div>
	  <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="nav">
		   <li><input name="file[]" type="file" id="file" multiple style="display:none;" /><a href="#" id="upload_link">Add File</a></li>
		   <li><a href="#" id="upload">Upload</a></li>
		   <li><a href="../Profile.php?name=<?php echo str_replace("'",'',$_REQUEST["name"]);?>&email=<?php echo str_replace("'",'',$_REQUEST["email"]);?>">Profile</a></li>
		    </ul>
        </div>
      </nav>
    </header>
	 <div id="site_content">
	 <div id="sidebar_container">
        <div class="sidebar">
            <!--	<a href="#">Add Caption</a><br>
			<a href="#">Add Description</a><br>
			<a href="#">Add Tags</a><br>-->
		    </div>
      </div>
	  <!--content-->
      <div class="uploadcontent">
	  <h2>Image Upload Form</h2>
		<div id="divpopup" style="display:none">
		<label id="current"></label>
		<form action="" method="post">
		<div class="form_settings">
		<p><span>Title:</span><input maxlength="50" type="text" name="title" id="title" placeholder="add short title within 50 letters"value="" /></p>
		<p><span>Description:</span><textarea maxlength="600" rows="4"  cols="50" name="description" id="description" placeholder="Add Decription within 600 letters"value="" ></textarea></p>
		<p><span>Tags:</span><input maxlength="600" type="text" name="tags" id="tags" placeholder="separate tags with a space limit 600 letters"value="" /></p>
		<p><span>
		Access Rights:</span><select name="accessrights" id="accessrights">
		<option value="1">Private</option>
		<option value="2">Public</option>
		<option value="3">Shared</option>
		</select></p>
		</div>
        
		</form>
		</div>

				<form enctype="multipart/form-data" action="" method="post">
					First Field is Compulsory.Multiple Images with same name will only be uploaded once.Click on the Image to specify attributes.Add access rights shared if you want to upload it in group and public for saring to all users. Only jpeg,png,jpg Type Image Uploaded. 
						<br><br>
						<div id="browsedfiles"></div>
							<!--<input type="button" id="add_more" class="upload" value="Add More Files"/>
							<input type="submit" value="Upload File" name="submit" id="upload" class="upload"/>-->
				</form>
				<!------- Including PHP Script here ------>
				<div id='result'></div>
				
			  <!--<h3 id="status"></h3>
			  <p id="loaded_n_total"></p>-->
			  <div id="progresscircle">
			  	<canvas id="my_canvas" width="300" height="300" style="margin-left:350px;" ></canvas>
				</div>

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
var ctx = document.getElementById('my_canvas').getContext('2d');
var al = 0;
var start = 4.72;
var cw = ctx.canvas.width;
var ch = ctx.canvas.height; 
var diff;
//function progressSim(){
//}
//var sim = setInterval(progressSim, 50);
	
  </script>
</body>


</html>