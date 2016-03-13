<!DOCTYPE HTML>
<html>

<head>
  <title>Pixr</title>
   
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
   <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
 <!-- modernizr enables HTML5 elements and feature detects -->
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dropdown.js"></script>
<script type="text/javascript" src="js/GroupProfile.js"></script>
<div id='1234'style="display:none;"><?php echo str_replace("'",'',$_REQUEST["email"]);?></div> 
<script type="text/javascript">

function uploadImageForm(){
$('#uploadedPics').empty();
var no_shared_image=0;
var total_shared_images=0;
$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getSharedAttrPictures", user: currentUser },async:false
}).done(function( data ) {
  data=JSON.parse(data);
  for(k=0;k<data.length;k++){
  total_shared_images++;
    var image=document.createElement("img");
image.id="uploadimg"+k;
image.alt="";
image.title="";
image.style.float="left";
image.src=data[k]['image_data'];
image.style.width="100px";
image.style.height="100px";
image.style.marginBottom="50px";
var checkBox = document.createElement("INPUT");
    checkBox.setAttribute("type", "checkbox");
	checkBox.id="upload"+k;
	checkBox.style.float="left";
	
$('#uploadedPics').append(image);
$('#uploadedPics').append(checkBox);
	}
	if(data.length==0){
	no_shared_image=1;
	}
  });
if(no_shared_image==1){
alert('No image found with shared access rights. Only image with shared access rights cn be uploaded to groups');
}
else{
$('#uploadpopup').dialog({
	title:"Upload Images",
	width:650,
	height:700,
	modal:true,
	buttons:{
		Upload:
		function(){
		var currentUser=sessionStorage.getItem("page1content");		
		var currentGroupAdmin=sessionStorage.getItem("currentGroupAdmin");
		var currentGroup=sessionStorage.getItem("currentGroup");

		var one_checked=0;
			for(k=0;k<total_shared_images;k++){
				if(document.getElementById('upload'+k).checked){
					var filePath = document.getElementById('uploadimg'+k).src;
					var fileName = filePath.substr(filePath.lastIndexOf("/") + 1);
					fileName=fileName.replace("%20", " ");
					$.ajax({
					  type: "POST",
					  url: "controller/UserController.php",
					  data: { action: "uploadImageToGroup", user: currentUser,group:currentGroup,image:document.getElementById('uploadimg'+k).src,image_name:fileName,Admin:currentGroupAdmin },async:false
					}).done(function(data){
					
					});
				one_checked=1;
				
				}
			}
			if(one_checked==0){
			alert('Please choose at least one image to upload');
			}
			else{
			alert('Images Uploaded to Group');
			$(this).dialog('close');
			}
		},
		Close:
		function(){
		$(this).dialog('close');
		}
	
	}
	
	});
	}
}
var currentUser=sessionStorage.getItem("page1content");
function loadGroup(id,group_name,members){

var currentUser=sessionStorage.getItem("page1content");
//loading cover and profile photo
var element2;
if(document.getElementById('profile_menu_container')==null){
element2 = document.createElement("div");
element2.id="profile_menu_container";
var para=document.createElement("P");
    var link1 = document.createElement("A");
	link1.style.backgroundColor="#404040";
	var text1=document.createTextNode("Photo Stream");
	link1.setAttribute("href","#");
	link1.id="GroupPhotoStream";
	link1.setAttribute("onclick", "redirect(\"" + id + "\",'GroupPhotoStream.php')");
	link1.appendChild(text1);
	var link2 = document.createElement("A");
	var text2=document.createTextNode("Albums");
	link2.style.backgroundColor="#404040";
	link2.setAttribute("href","#");
	link2.setAttribute("onclick", "redirect(\"" + id + "\",'GroupAlbum.php')");
	link2.appendChild(text2);
	
	var link3 = document.createElement("A");
	var text3=document.createTextNode("Upload Images");
	link3.style.backgroundColor="#404040";
	link3.setAttribute("href","#");
	link3.setAttribute("onclick", "uploadImageForm()");
	link3.appendChild(text3);
	
	para.appendChild(link1);
	para.appendChild(link2);
	para.appendChild(link3);
	
	element2.appendChild(para);
 

document.getElementById(id).appendChild(document.createElement("BR"));
document.getElementById(id).appendChild(document.createElement("BR"));
document.getElementById(id).appendChild(element2);

}
	
	document.getElementById('dropdown3').style.display="block";
		var sub_menu1=document.getElementById('sub_menu_id_3');
			  
			  for(i=0;i<members.length;i++){
				var li=document.createElement('Li');
				var link=document.createElement('A');
				link.setAttribute('href','#');
				link.id="members"+i;
				link.appendChild(document.createTextNode(members[i]));
				li.appendChild(link);
				sub_menu1.appendChild(li);
				}
				

}
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

$('#create_group').click(function() {


$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getAllUsers", user: currentUser },async:false
}).done(function( data ) {
$('#sub_menu_id').empty();
 var sub_menu=document.getElementById('sub_menu_id');
  data=JSON.parse(data);
  for(i=0;i<data.length;i++){
    var li=document.createElement('Li');
    var link=document.createElement('A');
	link.setAttribute('href','#');
	var checkbox = document.createElement('input');
	checkbox.type = "checkbox";
	checkbox.name = ""+i;
	checkbox.value = data[i]['Email'];
	checkbox.id = "form"+i;
	link.appendChild(checkbox);
	link.appendChild(document.createTextNode(data[i]['Email']));
	li.appendChild(link);
	sub_menu.appendChild(li);
	
	}
  });
$('#divpopup').dialog({
	title:"Add Group",
	width:700,
	height:700,
	modal:true,
	buttons:{
		Create:
		function(){
		var duplicate=0;
		var group_name=document.getElementById('title').value;
		 $.ajax({
			  type: "POST",
			  url: "controller/UserController.php",
			  data: { action: "checkDuplicateGroup", user: currentUser,group:group_name },async:false
			}).done(function( data ) {
				if(data.length>6){
				 duplicate=1;
				}
			  });
		var members=[];
		var at_least_one=0;
		for(j=0;j<$('#sub_menu_id').children().length;j++){
			if (document.getElementById("form"+j).checked) {
			at_least_one=1;
            members.push(document.getElementById("form"+j).value);
			}
		 }
		 if(at_least_one==0){
		 alert('Please Select at least one member');
		 }
		 else if(group_name.length==0){
		 alert('Please Enter group name as it is mandatory');
		 
		 }
		 else if(duplicate==1){
			 alert('Group name already used');
			 duplicate=0;
		 }
		 else{
		 	var group_members = JSON.stringify(members);
			   $.ajax({
			  type: "POST",
			  url: "controller/UserController.php",
			  data: { action: "createGroup", user: currentUser,group:group_name,grp_members:group_members,date:new Date() },async:false
			}).done(function( data ) {
			alert('Group Has Been Created');
			  });
				loadCreatedGroups('asd');

		 $(this).dialog('close');
		 }
		},
		Close:
		function(){
		$(this).dialog('close');
		}
	
	}
	
	});
});
});
function loadCreatedGroups(){
$.ajax({
			  type: "POST",
			  url: "controller/UserController.php",
			  data: { action: "getGroupsCreated", user: currentUser },async:false
			}).done(function( data ) {
			$('#sub_menu_id_1').empty();
			var sub_menu1=document.getElementById('sub_menu_id_1');
			  data=JSON.parse(data);
			  for(i=0;i<data.length;i++){
				var li=document.createElement('Li');
				var link=document.createElement('A');
				link.setAttribute('href','#');
				link.id="created"+i;
				link.appendChild(document.createTextNode(data[i]['group_name']));
				link.onclick=function(){
							$.ajax({
					  type: "POST",
					  url: "controller/UserController.php",
					  data: { action: "getGroupDetails", user:currentUser,group:$(this).text() },async:false
					}).done(function( data ) {
					 data=JSON.parse(data);
					 var Group = data[0]['group_name']; 
					sessionStorage.setItem("currentGroup", Group);
					sessionStorage.setItem("currentGroupAdmin",data[0]['Admin'] );

					 document.getElementById('group_name').innerHTML="Group: "+data[0]['group_name']+ " Admin: "+data[0]['Admin'];
					 document.getElementById('date_created').innerHTML=data[0]['date_created'];
					 document.getElementById('cover_photo').style.display="block";
					 document.getElementById('cover_photo').src=data[0]['cover_photo'];
					 var mem=[]
					 
						for(i=0;i<data.length;i++){
						mem.push(data[i]['member']);
						}
						//alert('asd');
						$('#sub_menu_id_3').empty();
						//$("#profile_menu_container").empty();
						
						loadGroup('content_id',data[0]['group_name'],mem);
						 $('#GroupPhotoStream').click();
					});
					
				};
				li.appendChild(link);
				sub_menu1.appendChild(li);
				
				
				}
			
			  });
}
function loadJoinedGroups(){
$.ajax({
			  type: "POST",
			  url: "controller/UserController.php",
			  data: { action: "getGroupsJoined", user: currentUser },async:false
			}).done(function( data ) {
			$('#sub_menu_id_2').empty();
			var sub_menu2=document.getElementById('sub_menu_id_2');
			  data=JSON.parse(data);
			  for(i=0;i<data.length;i++){
				var li=document.createElement('Li');
				var link=document.createElement('A');
				link.setAttribute('href','#');
				link.id="joined"+i;
				link.appendChild(document.createTextNode(data[i]['group_name']));
				link.onclick=function(){
							$.ajax({
					  type: "POST",
					  url: "controller/UserController.php",
					  data: { action: "getJoinedGroupDetails", user:currentUser,group:$(this).text() },async:false
					}).done(function( data ) {
					 data=JSON.parse(data);
					 var Group = data[0]['group_name']; 
					sessionStorage.setItem("currentGroup", Group);
					sessionStorage.setItem("currentGroupAdmin",data[0]['Admin'] );

					 document.getElementById('group_name').innerHTML="Group: "+data[0]['group_name']+ " Admin: "+data[0]['Admin'];
					 document.getElementById('date_created').innerHTML=data[0]['date_created'];
					 document.getElementById('cover_photo').style.display="block";
					 document.getElementById('cover_photo').src=data[0]['cover_photo'];
					 var mem=[]
					 
						for(i=0;i<data.length;i++){
						mem.push(data[i]['member']);
						}
						//alert('asd');
						$('#sub_menu_id_3').empty();
						//$("#profile_menu_container").empty();
						
						loadGroup('content_id',data[0]['group_name'],mem);
						 $('#GroupPhotoStream').click();
					});
					
				};
				li.appendChild(link);
				sub_menu2.appendChild(li);
				
				
				}
			
			  });

}
function loadGroups(){
loadCreatedGroups();
loadJoinedGroups();
}
</script>
 <style>
 @font-face { 
  font-family: Yanone Kaffeesatz; 
    src: url('../fonts/YanoneKaffeesatz-Regular.eot'); 
    src: local("Yanone Kaffeesatz"), url('../fonts/YanoneKaffeesatz-Regular.ttf'); 
} 

html { 
  height: 100%;
}

* { 
  margin: 0;
  padding: 0;
}

/* tell the browser to render HTML 5 elements as block */
article, aside, figure, footer, header, hgroup, nav, section { 
  display:block;
}

body { 
  font: normal .80em arial, sans-serif;
  background: #FFF url(images/back.jpg) no-repeat center fixed;
  color: #DDD;
}
p { 
  padding: 0 0 20px 0;
  line-height: 1.7em;
}

img { 
  border: 0;
}

h1, h2, h3, h4, h5, h6 { 
  color: #362C20;
  letter-spacing: 0em;
  padding: 0 0 5px 0;
}

h1, h2, h3 { 
  font: normal 140% arial, sans-serif;
  margin: 0 0 15px 0;
  padding: 15px 0 5px 0;
  color: #FFF;
}

h2 { 
  font-size: 160%;
  padding: 9px 0 5px 0;
  color: #F67F00;
}

h3 { 
  font-size: 140%;
  padding: 5px 0 0 0;
}

h4, h6 { 
  color: #F67F00;
  padding: 0 0 5px 0;
  font: normal 150% 'Yanone kaffeesatz', arial, sans-serif;
}
h4 a{


}

h5, h6 { 
  color: #888;
  font: italic 95% arial, sans-serif;
  letter-spacing: normal;
  padding: 0 0 15px 0;
}

a, a:hover { 
  outline: none;
  text-decoration: underline;
  color: #09D4FF;
}

a:hover { 
  text-decoration: none;
}
#main, nav, #container, #logo, #site_content, footer { 
  margin-left: auto; 
  margin-right: auto;
}

.form_settings { 
  margin: 15px 0 0 0;
}

.form_settings p { 
  padding: 0 0 4px 0;
}

.form_settings span { 
  float: left; 
  width: 200px; 
  text-align: left;
}
  
.form_settings input, .form_settings textarea { 
  padding: 5px; 
  width: 299px; 
  font: 100% arial; 
  border: 1px solid #C6E7F0; 
  background: #EFF8FB; 
  color: #47433F;
  border-radius: 7px 7px 7px 7px;
  -moz-border-radius: 7px 7px 7px 7px;
  -webkit-border: 7px 7px 7px 7px;  
}
  
.form_settings .submit { 
  font: 140% 'Yanone Kaffeesatz', arial, sans-serif; 
  border: 0; 
  width: 99px; 
  margin: 0 0 0 212px; 
  height: 33px;
  padding: 2px 0 3px 0;
  cursor: pointer; 
  
  -webkit-border-radius: .5em .5em .5em .5em ; 
  -moz-border-radius: .5em .5em .5em .5em ;
  border-radius: .5em .5em .5em .5em ;
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  box-shadow: 0 1px 2px rgba(0,0,0,.2);  
  color: #FFF;
  border: solid 1px #0D8AA9;
  background: #1EC9F4; 
  background: #46C4DD;
  background: -webkit-gradient(linear, left top, left bottom, from(#63CFDF), to(#17B2D9));
  background: -moz-linear-gradient(top,  #63CFDF,  #17B2D9);
  text-shadow: 1px 1px #178497;
}

.form_settings textarea, .form_settings select { 
  font: 100% arial; 
  width: 299px;
}

.form_settings select { 
  width: 310px;
}

.form_settings .checkbox { 
  margin: 4px 0; 
  padding: 0; 
  width: 14px;
  border: 0;
  background: none;
}


 
#menu_container							{ float: left;
  height: 44px;
  width: 1030px;
  margin: 0 auto 0 auto;
  color: #FFF;background: transparent url(images/transparent.png); } 
article, aside, figure, footer, header, hgroup, nav, section { 
  display:block;
}
#main {
  margin: 50px auto;
  width: 980px;
  padding-bottom: 30px;
}

header { 
  background: transparent;
  height: 225px;
}
#logo { 
  width: 330px;
  float: left;
  height: 100px;
  color: #888;
  padding: 20px;
  margin-bottom: 20px;
}

#logo h1, #logo h2 { 
  font: normal 320% 'News Cycle', arial, sans-serif;
  border-bottom: 0;
  text-transform: none;
  margin: 0;
}

#logo_text h1, #logo_text h1 a, #logo_text h1 a:hover { 
  padding: 0;
  color: #FFF;
  text-decoration: none;
}

#logo_text h1 a .logo_colour { 
  color: #09D4FF;
}

#logo_text a:hover .logo_colour { 
  color: #FFF;
}

#logo_text h2 { 
  font-size: 140%;
  padding: 0 0 0 0;
  color: #FFF;
}
nav { 
  float: left;
  height: 44px;
  width: 1030px;
  margin: 0 auto 0 auto;
  color: #FFF;
  background: transparent url(../images/transparent.png);
} 
#menu_container { 
  width: 1030px;
  margin: 0 auto 0 auto;
}
#site_content { 
  width: 980px;
  overflow: hidden;
  margin: 0px auto 0 auto;
  padding: 25px;
  background: transparent url(images/transparent.png);
}
#cover_photo{
 border-width:5px;	
    border-style:ridge;
	border-color:#E6E6E6;
 height: 200px;
 width: 930px;

 z-index:-1;
 position:reative;
} 
.content { 
  text-align: left;
  width: 900px;
  margin: 0 0 15px 0;
  float: left;
  font-size: 120%;
  padding: 50px 50px 50px 50px;
  height:auto;
}

.content ul { 
  margin: 2px 0 22px 0px;
}
.content #profile_menu_container a{
color:#FFF;
font:normal .100em arial, sans-serif;
font-size:20px;
text-decoration :none;
margin: 0 20px 0 0;
}
.content #profile_menu_container a:hover{
color: #09D4FF;
}
footer { 
  width: 1030px;
  font: 170% 'Yanone Kaffeesatz', arial, sans-serif;
  text-shadow: 1px 1px #000;
  height: 30px;
  padding: 5px 0 20px 0;
  text-align: center; 
  color: #FFF;
  margin-top: 25px;
  background: transparent url(images/transparent.png);
}

footer p { 
  line-height: 1.7em;
  padding: 0 0 10px 0;
}

footer a { 
  color: #FFF;
  text-decoration: none;
}

footer a:hover { 
  color: #FFF;
  text-decoration: underline;
}

/* 
	LEVEL ONE
*/
ul.dropdown                         { position:relative; width: 100%; }
ul.dropdown li                      { font-weight: bold; float: left;list-style: none; width: 180px; position: relative;float:right; }
ul.dropdown li:hover { 
  visibility: inherit; /* fixes IE7 'sticky bug' */ 
}
ul.dropdown a { 
  display: block;
  position: relative;
}

ul.dropdown a:hover		            { color: #000; }
ul.dropdown li a                    { font: normal 140% 'Yanone kaffeesatz', arial, sans-serif;display: block; padding: 10px 8px; text-decoration: none;
  color: #FFF; position: relative;z-index: 2; }
ul.dropdown li a:hover,
ul.dropdown li a.hover              { color:#000;background:#0DBBD5;
  text-shadow: none; position: relative; }


/* 
	LEVEL TWO
*/
ul.dropdown ul 						{ display: none; position: absolute; top: 0; left: 0; width: 180px;z-index: 1; }
ul.dropdown ul li 					{ font: normal 80% 'Yanone kaffeesatz', arial, sans-serif;font-weight: normal; background:#0DBBD5; color: #000; border-bottom: 1px solid #ccc; }
ul.dropdown ul li a					{ display: block; background:#0DBBD5 !important; } 
ul.dropdown ul li a:hover			{ display: block; background: #F3D673 !important; }  


 </style>
  
</head>
<body onload="loadGroups()">
 <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="Pixr.php"><span class="logo_colour">Pixr</span></a></h1>
          <h2>Welcome <?php echo str_replace("'",'',$_REQUEST["name"]);?></h2>
        </div>
      </div>
      <nav>
	<div id="menu_container">
        <ul class="dropdown">
        	<li><a href="#">Groups Created</a>
        		<ul class="sub_menu" id="sub_menu_id_1">
        			 
        		</ul>
        	</li>
        	<li><a href="#">Groups Joined</a>
        		<ul class="sub_menu"id="sub_menu_id_2">
        			 
        		</ul>
        	</li>
        	<li><a href="#" id="create_group">Create Group</a>
        	</li>
			<li><a href="Profile.php?name='<?php echo str_replace("'",'',$_REQUEST["name"]);?>''&email='<?php echo str_replace("'",'',$_REQUEST["email"]);?>'">Profile</a></li>
            
        </ul>
		
	</div>
  </nav>
    </header>
  
<div id="site_content">
      <div class="content"id="content_id">
	  <h2 id="group_name"></h2>
<label id="date_created"style="font: 80% 'Yanone Kaffeesatz', arial, sans-serif; color: #FFF;"></label>
	  
	  <ul class="dropdown" id="dropdown3" style="display:none;margin-left:-730px;">
        	<li><a href="#">Members</a>
        		<ul class="sub_menu" id="sub_menu_id_3">
        			 
        		</ul>
        	</li>
			</ul>
	  <a href="#" id="cover_link"><img src="" id="cover_photo" style="display:none;"></img></a>
		<div id="coverpopup" class="form_settings"style="display:none;">
			<img src="" id="dialogcover" width="930px" height="200px" /><br>
				Choose Photo from  Photo Stream to change Cover Photo.
		</div>
	  
	  <div id="divpopup" style="display:none;z-index:1000">
		<form action="" method="post">
		<div class="form_settings">
		<p><span>Group Name:</span><input maxlength="50" type="text" name="title" id="title" placeholder="Add Group Name within 50 letters"value="" /></p>
		</form>
		</div>
		<br>
		<ul class="dropdown"style="position:absolute;left:-310px;">
        	<li><a href="#"style="color:#000;">Add members</a>
        		<ul class="sub_menu" id="sub_menu_id">
        			 
        		</ul>
        	</li>
			</ul>
		
				
			</div>
	  
	  		</div>
			<div id="uploadpopup" style="display:none">
		<label id="Error"style="color:red;"></label>
		<form action="" method="post">
		<div id="uploadedPics"style="max-width = '600px';">Please Select From Following Images:<br><br></div>
		
		</form>
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
     <!-- $('ul.sf-menu').sooperfish();-->
    });
  </script>
  
</body>

</html>







