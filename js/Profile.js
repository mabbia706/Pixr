	
	

function Picture(){
this.path=arguments[0];
  this.getPath=function(){
  return this.path;
  }
  this.name=arguments[1];
  this.title=arguments[2];
  this.description=arguments[3];
  this.tags=arguments[4];
  this.rights=arguments[5];
  this.uploader=arguments[6];
  this.date_created=arguments[7];
  this.getName=function(){
  return this.name;
  }
  this.getTitle=function(){
  return this.title;
  }
  this.getTags=function(){
  return this.tags;
  }
  this.getDescription=function(){
  return this.description;
  }
  this.getUploader=function(){
  return this.uploader;
  }
  this.comments=new Array();
  this.getComments=function(){
  return this.comments;
  }
  this.addComment=function(){
  this.comments.push(arguments[0]);
  //alert(this.comments.length);
  }
  this.getNoOfComments=function(){
  return this.comments.length;
  }
  this.getDate=function(){
  return this.date_created;
  }
  
}
  
var pictures = new Array();
var publicPictures=new Array();
var albums=new Array();
/*for(i=1;i<=2;i++){
var index=""+i;
pictures.push(new Picture("images/"+index+".jpg","image "+i,"Infuse your life with action. Don't wait for it to happen. Make it happen. Make your own future. Make your own hope. Make your own love. And whatever your beliefs, honor your creator, not by passively waiting for grace to come down from upon high, but by doing what you can to make grace happen... yourself, right now, right down here on Earth."));
}
*/
function loadPicture(image_name,image_data,title,description, tags,access_rights,uploader,date){
pictures.push(new Picture(image_data,image_name,title,description,tags,access_rights,uploader,date));
}
function loadPublicPicture(image_name,image_data,title,description, tags,access_rights,uploader,date){
publicPictures.push(new Picture(image_data,image_name,title,description,tags,access_rights,uploader,date));
}

var count_checked=0;
function createAlbum(){
/*albums.push(new Album(document.getElementById('AlbumName').value));

for( i=0;i<pictures.length;i++){
if(document.getElementById( pictures[i].getPath()).checked){
count_checked++;
albums[albums.length-1].addPicture(pictures[i].getPath());
}
}
alert('Album'+document.getElementById('AlbumName').value+ ' is created');*/
}

function loadAlbum(){
document.getElementById('Function').innerHTML='<object type="text/html" style="width:1300px ;height:1500px;"; data="Album.php"></object>'
}
function loadPhotoStream(){
document.getElementById('Function').innerHTML='<object type="text/html" style="width:1300px ;height:1500px;"; data="PhotoStream.php"></object>'
}
var photoStreamHeight='300px';

function redirect(id,page){

var element3;
if(document.getElementById('Page')==null){
 element3 = document.createElement("div");
element3.id="Page";
}
else{
element3=document.getElementById('Page');

}
var object;
if(document.getElementById('object')==null){
object=document.createElement("object");
object.id="object";
object.setAttribute("type","text/html");
object.setAttribute("data",page);
object.style.width='930px';
var val=parseFloat(pictures.length/7);
val=Math.ceil(val);
val*=230;
val+='px';
object.style.height='1500px';
element3.appendChild(object);
//element3.innerHTML='<object type="text/html" style="width:930px;height:h;" data="PhotoStream.php"></object>';
document.getElementById(id).appendChild(element3);
}
else{
object=document.getElementById('object');
object.setAttribute("type","text/html");
object.setAttribute("data",page);
object.style.height=val;
}
}


function loadProfile(id){
var currentUser=sessionStorage.getItem("page1content");
//loading cover and profile photo
$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getProfileAndCoverPhoto", user: currentUser },async:false,
  error:function(jqXHR, textStatus, errorThrown){
14
                alert(textStatus + errorThrown);
15
            }

})
  .done(function( data ) {
  data=JSON.parse(data);
  for(i=0;i<data.length;i++){
  
   document.getElementById('cover_photo').src=data[i]['cover_picture'];
   document.getElementById('profile_photo').src=data[i]['profile_picture'];
	}
  });
/*var element1 = document.createElement("div");
element1.id='coverPhoto';

var cover_photo = document.createElement("img");
cover_photo.id = "cover_photo";
cover_photo.className = "";
cover_photo.src ="images/DefaultCoverPhoto.jpg";
//cover_photo.height = 200;
//cover_photo.width = 1320;
cover_photo.alt='cover_photo';
cover_photo_link=document.createElement('A');
cover_photo_link.setAttribute('href','#');
//cover_photo_link.setAttribute('onclick','displayCoverPic()');
cover_photo_link.appendChild(cover_photo);
element1.appendChild(cover_photo_link);
var profile_photo = document.createElement("img");
profile_photo.id = "profile_photo";
profile_photo.className = "";
profile_photo.alt='profile_photo';
profile_photo.src ="images/DefaultProfilePhoto.jpg";

profile_photo_link=document.createElement('A');
profile_photo_link.setAttribute('href','#');
//profile_photo_link.setAttribute('onclick','displayProfilePic()');
profile_photo_link.id="prof_photo_link";

profile_photo_link.appendChild(profile_photo);
element1.appendChild(profile_photo_link);*/

var element2 = document.createElement("div");
element2.id="profile_menu_container";
var para=document.createElement("P");
    var link1 = document.createElement("A");
	link1.style.backgroundColor="#404040";
	var text1=document.createTextNode("Photo Stream");
	link1.setAttribute("href","#");
	link1.setAttribute("onclick", "redirect(\"" + id + "\",'PhotoStream.php')");
	link1.appendChild(text1);
	var link2 = document.createElement("A");
	var text2=document.createTextNode("Albums");
	link2.style.backgroundColor="#404040";
	link2.setAttribute("href","#");
	link2.setAttribute("onclick", "redirect(\"" + id + "\",'Album.php')");
	link2.appendChild(text2);
	
		var link3 = document.createElement("A");
	var text3=document.createTextNode("Explore");
	link3.style.backgroundColor="#404040";
	
	link3.setAttribute("href","#");
	link3.setAttribute("onclick", "redirect(\"" + id + "\",'Explore.php')");
	link3.appendChild(text3);

	para.appendChild(link1);
		para.appendChild(link2);
	para.appendChild(link3);
	 element2.appendChild(para);
 

//document.getElementById(id).appendChild(element1);
document.getElementById(id).appendChild(document.createElement("BR"));
document.getElementById(id).appendChild(document.createElement("BR"));
document.getElementById(id).appendChild(element2);

/*var temp1=document.getElementById('sub_page');
	if (temp1 == null)
	{ 
	var element2 = document.createElement("div");
	element2.id='sub_page';
	document.getElementById('page').appendChild(element2);
	document.getElementById('sub_page').innerHTML='<object type="text/html" style="width:1300px ;height:1500px;"; data="Profile.php"></object>';
 
	}*/

}



