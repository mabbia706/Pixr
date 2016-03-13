<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/Album.css">
<link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/Album1.css" />
        <link rel="stylesheet" type="text/css" href="css/Album2.css" />
        <link rel="stylesheet" type="text/css" href="css/Album3.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/AlbumSlideShow.css">

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



<script type="text/javascript">
albumPool=new Array();
function Album(){
this.Name=arguments[0];
this.date_created=arguments[1];
this.albumPictures=new Array();
albumPool[0]=this;
this.CoverId=0;
}
Album.prototype.incrementCoverId=function(){
if(this.CoverId<this.albumPictures.length-1){
this.CoverId+=1;
}
else{
this.CoverId=0;

}
}
Album.prototype.getPictures=function(){
return this.albumPictures;
}
Album.prototype.addPicture=function(image_name,image_data,title,description, tags,access_rights,uploader){
this.albumPictures.push(new Picture(image_data,image_name,title,description,tags,access_rights,uploader));

}
Album.prototype.getName=function(){
return this.Name;
}
Album.prototype.getDate=function(){
return this.date_created;
}
function Comment(){
this.com=arguments[0];

}

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
  this.comments=new Array();
  
  this.getName=function(){
  return this.name;
  }
  
  this.getTitle=function(){
  return this.title;
  }
  this.getUploader=function(){
  return this.uploader;
  }
  
  this.getTags=function(){
  return this.tags;
  }
  this.getDescription=function(){
  return this.description;
  }
  this.addComment=function(){
  this.comments.push(arguments[0]);
  //alert(this.comments.length);
  }
  this.getNoOfComments=function(){
  return this.comments.length;
  }
  
  

}
 
var pictures = new Array();
var albums=new Array();
function loadPicture(image_name,image_data,title,description, tags,access_rights,uploader){
pictures.push(new Picture(image_data,image_name,title,description,tags,access_rights,uploader));
}
function loadAlbum(album_title,date){
albums.push(new Album(album_title,date));

}

</script>

<!--gallery for pagination-->
<script type="text/javascript">
var galleryPool=new Array();
var display_count=0;
var starting_cover=0;
function Gallery(){
this.id=arguments[0];
this.rows=5;//this should be not more than 5
this.cols=5;//this should be not more than 5
this.max_no_of_albums_per_page=0;
this.no_of_pages=0;

this.gallery_images=new Array();
galleryPool[0]=this;

}
Gallery.prototype.setNoOfPages=function(){

this.max_no_of_albums_per_page=this.rows*this.cols;
this.no_of_pages=parseFloat(albums.length/this.max_no_of_albums_per_page);
this.no_of_pages=Math.ceil(this.no_of_pages);
}
var searchFlag=0;
Gallery.prototype.display=function(){

if(albums.length==0){
if(searchFlag==0){
alert('Currently there are no albums ');
}
if(searchFlag==1){
	alert('No Album Found in current gallery');
	location.reload();
	}

}
else{
var width=this.cols*200;
var height=this.rows*200;

var Album_Cover;
for(i=arguments[0];i<this.rows*this.cols;i++){
if(i==albums.length){
break;
}
var view=document.createElement("div");
view.id=albums[i].getName();
view.className="view view-first";
Album_Cover=document.createElement("img");
  Album_Cover.src = albums[i].getPictures()[0].getPath();
  Album_Cover.id=""+i;
    // Code for Chrome, Safari, Opera
    Album_Cover.style.WebkitTransform = "translateX(0px)"; 
    // Code for IE9
    Album_Cover.style.msTransform = "translateX(0px)"; 
    // Standard syntax
     Album_Cover.style.transform=" translateX(0px)";
  Album_Cover.width = 150;
    Album_Cover.height = 150;
    Album_Cover.alt = "Album_Cover";
	//Album_Cover.hspace=5;
	album_link = document.createElement('a');
	//album_link.appendChild(Album_Cover);
	album_link.setAttribute('href', '#');
	album_link.id="album_link"+i;
	album_link.onclick=function(){
	//alert(this.id[this.id.length-1]);
	document.getElementById('slideshow').style.display='block';
	document.getElementById('albumContents').style.display='none';
	var param=this.id.replace( /^\D+/g, '');
	
	var obj=new AlbumSlideShow(parseInt(param),0);
	//alert('asdasd');
	obj.performAlbumSlideShow();
	
	//var comment=new Comment();

	}
	view.appendChild(Album_Cover);
	
	var mask=document.createElement("div");
	mask.className="mask";
	
	var h2=document.createElement("h2");
	
	var text=document.createTextNode(albums[i].getName());
	album_link.appendChild(text);
	h2.appendChild(album_link);
	mask.appendChild(h2);
	view.appendChild(mask);
if(document.getElementById(albums[i].getName())==null){	
document.getElementById('albumContents').style.width=width+"px";
document.getElementById('albumContents').style.height=height+"px";

document.getElementById('albumGallery').appendChild(view);
}

}
setInterval(function() {
 // Code for Chrome, Safari, Opera
for( i=0;i<galleryPool[0].rows*galleryPool[0].cols;i++){
if(i==albums.length){
break;
}

  document.getElementById(""+i).style.WebkitTransform = "translateX(0px)"; 
    // Code for IE9
    document.getElementById(""+i).style.msTransform = "translateX(0px)"; 
    // Standard syntax
document.getElementById(""+i).style.transform=" translateX(0px)";
}
for( i=0,k=starting_cover;i<galleryPool[0].rows*galleryPool[0].cols;i++,k++){
if(k==albums.length){
break;
}
albums[k].incrementCoverId();  
document.getElementById(""+i).src=albums[k].getPictures()[albums[k].CoverId].getPath();

}
setTimeout(function(){
 // Code for Chrome, Safari, Opera
 for( i=0;i<galleryPool[0].rows*galleryPool[0].cols;i++){
  if(i==albums.length){
break;
}
  document.getElementById(""+i).style.WebkitTransform = "translateX(0px)"; 
    // Code for IE9
    document.getElementById(""+i).style.msTransform = "translateX(0px)"; 
    // Standard syntax
document.getElementById(""+i).style.transform=" translateX(0px)";
}
}, 2000);
 

 }, 2500);

}

}

function showNewPage(){

var index=arguments[0].replace(/\D/g,'');

index=index-1;
var starting_id=0;

starting_id=index*galleryPool[0].rows*galleryPool[0].cols;
var count=starting_id;
for(j=0;j<galleryPool[0].rows*galleryPool[0].cols;j++){
if(count<albums.length){
if(document.getElementById(albums[j].getName()).style.visibility="hidden"){
document.getElementById(albums[j].getName()).style.visibility="visible";
}
starting_cover=starting_id;
document.getElementById(""+j).src=albums[count].getPictures()[albums[count].CoverId].getPath();

//document.getElementById("pic_link"+j).setAttribute('href','SlideShow.php?'+starting_id);
document.getElementById("album_link"+j).text=albums[count].getName();
document.getElementById("album_link"+j).onclick=function(){
//alert(this.id[this.id.length-1]);
document.getElementById('slideshow').style.display='block';
	document.getElementById('albumContents').style.display='none';
var param=this.id.replace( /^\D+/g, '');
param=parseInt(param);

var param=index*galleryPool[0].rows*galleryPool[0].cols+param;

var obj=new AlbumSlideShow(parseInt(param),0);
	obj.performAlbumSlideShow();
	
	var comment=new Comment();

};
//starting_id++;
count++;
}
else{
document.getElementById(albums[j].getName()).style.visibility="hidden";
}
}



}


</script>

<!--album slideshow-->
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
    if(event.keyCode == 37) {
    albumSlideShowPool[0].decrementPictureId();
	   albumSlideShowPool[0].performAlbumSlideShow();
   
    }
    else if(event.keyCode == 39) {
    albumSlideShowPool[0].incrementPictureId();
	   albumSlideShowPool[0].performAlbumSlideShow();
   
   
    }
});
var albumSlideShowPool=new Array();

function AlbumSlideShow(currentId,id){

this.id=id;
this.currentId=currentId;
albumSlideShowPool[id]=this;
this.pictureId=0;
}
AlbumSlideShow.prototype.decrementPictureId=function(){
if(this.pictureId>0){
this.pictureId=this.pictureId-1;
//alert(this.pitureId);
}
else{
this.pictureId=albums[this.currentId].getPictures().length-1;

}
}
AlbumSlideShow.prototype.incrementPictureId=function(){
if(this.pictureId<albums[this.currentId].getPictures().length-1){
this.pictureId=this.pictureId+1;
}
else{
this.pictureId=0;

}

}
AlbumSlideShow.prototype.performAlbumSlideShow=function(){

if(	document.getElementById('prev')==null){
	 var previous = document.createElement("a");
    //Assign different attributes to the next. 
    //previous.type = 'button';
	text_prev=document.createTextNode('<');	
text_prev.id="t_prev";
    previous.appendChild(text_prev);
	//previous.value = '<'; // Really? You want the default value to be the type string?
    //previous.name = 'prev';  // And the name too?
	previous.id='prev';
	previous.className="navigator";
	var id=this.id;
	previous.setAttribute('href','#');
    previous.onclick = function() { // Note this is a function
       albumSlideShowPool[id].decrementPictureId();
	   albumSlideShowPool[id].performAlbumSlideShow();
    };
	document.getElementById('slideshow').appendChild(previous);
}
var slider=document.getElementById('image');
if(slider==null){
var view=document.createElement("div");
//view.id=albums[i].getName();
view.className="album album-first";

var img = document.createElement("img");
    img.src = albums[this.currentId].getPictures()[this.pictureId].getPath();
	document.getElementById('uploader').innerHTML=albums[this.currentId].getPictures()[this.pictureId].getUploader();
	document.getElementById('date_created').innerHTML=albums[this.currentId].getDate();
	
	var comment=new Comment(this.currentId,this.pictureId);
	
    img.alt = "flickr";
	img.hspace=5;
	img.id='image';
		view.appendChild(img);
	
		var mask=document.createElement("div");
	mask.className="mask";
	
	var h2=document.createElement("h2");
	h2.id="h2";
var title=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getTitle());
	h2.appendChild(title);
	var p=document.createElement("p");
	p.id="para";
	p.style.maxWidth = "700px";
	p.style.wordWrap = "break-word";
	
	var description=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getDescription());
p.appendChild(description);
p.appendChild(document.createElement("BR"));
p.appendChild(document.createElement("BR"));
p.appendChild(document.createElement("BR"));
var tags=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getTags().replace(/\s/g, "#") );
p.appendChild(tags);

	mask.appendChild(h2);
	mask.appendChild(p);
	view.appendChild(mask);

 document.getElementById('slideshow').appendChild(view);
 }
 else{
 
	document.getElementById('uploader').innerHTML=albums[this.currentId].getPictures()[this.pictureId].getUploader();
	document.getElementById('date_created').innerHTML=albums[this.currentId].getDate();
 slider.src=albums[this.currentId].getPictures()[this.pictureId].getPath();
 Comment(this.currentId,this.pictureId);

  var myNode = document.getElementById("para");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
myNode = document.getElementById("h2");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
var t=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getTitle());
	document.getElementById("h2").appendChild(t);

 	var desc=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getDescription());
document.getElementById("para").appendChild(desc);
	document.getElementById("para").style.maxWidth = "700px";
	document.getElementById("para").style.wordWrap = "break-word";
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
var tg=document.createTextNode(albums[this.currentId].getPictures()[this.pictureId].getTags().replace(/\s/g, "#") );
document.getElementById("para").appendChild(tg);


 }
 if(document.getElementById('next')==null){
var next = document.createElement("a");
    //Assign different attributes to the next. 
    //next.type = 'button';
    //next.value = '>'; // Really? You want the default value to be the type string?
    //next.name = 'next';  // And the name too?
    next.id='next';
text_next=document.createTextNode('>');	
text_next.id="t_next";
 next.appendChild(text_next);	
	next.className="navigator";
	
	next.setAttribute('href','#');
    next.onclick = function() { // Note this is a function
       albumSlideShowPool[id].incrementPictureId();
	   albumSlideShowPool[id].performAlbumSlideShow();
    };
	document.getElementById('slideshow').appendChild(next);
  }
  var timer;
  if(document.getElementById('stop')==null){
var stop = document.createElement("a");
stop.id='stop';
stop_text=document.createTextNode('Stop Slide');	
 stop.appendChild(stop_text);
stop.style.visibility="hidden";

	stop.setAttribute('href','#'); 
stop.onclick = function() { // Note this is a function
clearInterval(timer);
document.getElementById('prev').style.visibility="visible";
document.getElementById('next').style.visibility="visible";
document.getElementById('auto').style.visibility="visible";
document.getElementById('commentBox').style.visibility="visible";

albumSlideShowPool[id].decrementPictureId();
document.getElementById('image').src=albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getPath();
stop.style.visibility="hidden"; 

};
	document.getElementById('slideshow').appendChild(stop);
}
if(document.getElementById('auto')==null){
var auto = document.createElement("a");
auto.id='auto';
auto_text=document.createTextNode('Auto Slide');	
 auto.appendChild(auto_text);	
 
	auto.setAttribute('href','#');
auto.onclick = function() { // Note this is a function

 stop.style.visibility="visible";
document.getElementById('prev').style.visibility="hidden";
document.getElementById('next').style.visibility="hidden";
document.getElementById('auto').style.visibility="hidden";
document.getElementById('commentBox').style.visibility="hidden";

timer=setInterval(function() {
document.getElementById('image').className += "fadeOut";
setTimeout(function() {

	document.getElementById('uploader').innerHTML=albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getUploader();
	document.getElementById('date_created').innerHTML=albums[albumSlideShowPool[id].currentId].getDate();
document.getElementById('image').src=albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getPath();
 document.getElementById('image').className = "";
},1000);
var myNode = document.getElementById("para");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
myNode = document.getElementById("h2");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
var t=document.createTextNode(albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getTitle());
	document.getElementById("h2").appendChild(t);

 	var desc=document.createTextNode(albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getDescription());
document.getElementById("para").appendChild(desc);
document.getElementById("para").style.maxWidth = "700px";
document.getElementById("para").style.wordWrap = "break-word";
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
var tag=document.createTextNode(albums[albumSlideShowPool[id].currentId].getPictures()[albumSlideShowPool[id].pictureId].getTags().replace(/\s/g, "#") );
document.getElementById("para").appendChild(tag);

albumSlideShowPool[id].incrementPictureId();

 }, 4000); 
   };
	document.getElementById('slideshow').appendChild(auto);
  }
  }
function getParam(){
var query = window.location.search;
  // Skip the leading ?, which should always be there, 
  // but be careful anyway
  if (query.substring(0, 1) == '?') {
    query = query.substring(1);
  }
  var data = query.split(','); 
  for (i = 0; (i < data.length); i++) {
    data[i] = unescape(data[i]);
  }
return data;  
}
function Comment(currentAlbum,currentPic){

var currentUser=sessionStorage.getItem("page1content");
$('#commentBox').empty();
if(document.getElementById('commentBox')==null){
var commentBox=document.createElement("div");
commentBox.id="commentBox";
document.getElementById('slideshow').appendChild(commentBox);
}

var inputField= document.createElement("TEXTAREA");;
inputField.id="comment";
//inputField.type="text";
//inputField.style.width="400px";
inputField.rows="4";
inputField.cols="60";
inputField.placeholder="Write Your Comment Here";
document.getElementById('commentBox').appendChild(inputField);
var submit=document.createElement("button");
submit.id="addComment";
submit.style.fontSize="12px";
submit.appendChild(document.createTextNode("Add Comment"));
document.getElementById('commentBox').appendChild(submit);
//var prev_noc=pictures[currentPic].getNoOfComments()+ " Comments";

$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getComments", user: currentUser,picture:albums[currentAlbum].getPictures()[currentPic].getName() },async:false
})
  .done(function( data ) {
  data=JSON.parse(data);
	  var no_com=document.createElement("h2");
	  no_com.id="no_of_com";
	  var prev_noc=data.length+ " Comments";
  no_com.appendChild(document.createTextNode(prev_noc));
  document.getElementById('commentBox').appendChild(no_com);

  for(i=0;i<data.length;i++){
		var user=document.createElement("a");
		var com=document.createElement("p");
		com.style.maxWidth="400px";
		com.style.wordWrap="break-word";

		user.setAttribute('href','');
		user.appendChild(document.createTextNode(data[i]['Email_Commentator']));
		com.appendChild(document.createTextNode(data[i]['comment']));
		albums[currentAlbum].getPictures()[currentPic].addComment(data[i]['comment']);
		document.getElementById('commentBox').appendChild(user);
		document.getElementById('commentBox').appendChild(com);
	}
  });
//no_com.innerHTML =prev_noc;
submit.onclick=function(){
var currentUser=sessionStorage.getItem("page1content");

var newcom=document.getElementById('comment').value;
albums[currentAlbum].getPictures()[currentPic].addComment(newcom);
var noc=albums[currentAlbum].getPictures()[currentPic].getNoOfComments()+ " Comments";
 document.getElementById('no_of_com').innerHTML =noc;
var user1=document.createElement("a");
var com1=document.createElement("p");
com1.style.maxWidth="400px";
com1.style.wordWrap="break-word";

user1.setAttribute('href','');
user1.appendChild(document.createTextNode(currentUser));
com1.appendChild(document.createTextNode(newcom));

document.getElementById('commentBox').appendChild(user1);
document.getElementById('commentBox').appendChild(com1);
//location.reload();
$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "insertComments", user:currentUser,picture:albums[currentAlbum].getPictures()[currentPic].getName(),comment:document.getElementById('comment').value,uploader:albums[currentAlbum].getPictures()[currentPic].getUploader() },async:false
})
  .done(function( data ) {
	//alert(data.length);
  });
document.getElementById('comment').value="";

}

}

</script>


<script type="text/javascript">



function showCreateAlbumForm(){

var group_name=sessionStorage.getItem("currentGroup");
var currentUser=sessionStorage.getItem("page1content");
var currentAdmin=sessionStorage.getItem("currentGroupAdmin");

$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getGroupPictures",Admin: currentAdmin,group:group_name }, error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus+errorThrown);
    },async:false
})
  .done(function( data ) {
  data=JSON.parse(data);
	
  for(i=0;i<data.length;i++){
 // alert(data[i]['image_name']);
 
    loadPicture(data[i]['image_name'],data[i]['image_data'],data[i]['title'],data[i]['description'],data[i]['tags'],data[i]['access_rights'],data[i]['Email']);
	
	}
  });
  
  if(pictures.length==0){
	alert('No uploaded image found. Pleas upload some image to create album');
	}
	
else{
$('#uploadedPics').empty();
for(k=0;k<pictures.length;k++){
var image=document.createElement("img");
image.id="img"+k;
image.alt="";
image.title="";
image.style.float="left";
image.src=pictures[k].getPath();
image.style.width="100px";
image.style.height="100px";
image.style.marginBottom="50px";
var checkBox = document.createElement("INPUT");
    checkBox.setAttribute("type", "checkbox");
	checkBox.id="check"+k;
	checkBox.style.float="left";
	
$('#uploadedPics').append(image);
$('#uploadedPics').append(checkBox);

}
$('#divpopup').dialog({
	title:"Album Form",
	width:700,
	height:700,
	modal:true,
	buttons:{
		Create:
		function(){
		var group_name=sessionStorage.getItem("currentGroup");
			var flag=0;
			var duplicate=0;
			var temp_arr=[];
			var title=$('#title').val();
			$.ajax({
						  type: "POST",
						  url: "controller/UserController.php",
						  data: { action: "checkGroupAlbumName", Admin: currentAdmin,album_title:title,group:group_name },async:false
						})
						  .done(function( data ) {
						  if(data.length==12){
						  duplicate=1;
						  }
						  });
				
			if(title.length>0&&duplicate==0){
				for(l=0;l<pictures.length;l++){
				if(document.getElementById("check"+l).checked){
						temp_arr.push(pictures[l]);
					flag=1;
					
					}
				
			}
			if(flag==0){
				$('#Error').html('Please Select at least one image to create album');
				}
				else{
						  images_name=[];
						  for(k=0;k<temp_arr.length;k++){
						  
						  images_name.push(temp_arr[k].getName());
						  }
						  var images = JSON.stringify(images_name);
						 $.ajax({
						  type: "POST",
						  url: "controller/UserController.php",
						  data: { action: "Add Pictures To Group Album", user: currentUser,album_title:title,pics:images,group:group_name,Admin:currentAdmin,date:new Date() },async:false
						})
						  .done(function( data ) {
						  alert('Album has been created reload album to see update');
						  }); 
				
				$(this).dialog('close');
				
				}
				
			}
			else{
			if(duplicate==1)
					$('#Error').html('This Album Title Already Used');
			else
				$('#Error').html('Please enter title it is mandatory');
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


</script>
<script type="text/javascript">

function showAlbumForm(){
var html="<p>Enter Name of Album:</p><br><input type='text' id='AlbumName'></input><br><br><p>Select Pictures you want to add to album</p><br>";
html+="<label for='img1'><img class='thumbnail'  src=\"" + pictures[0].getPath() + "\" /></label>";
html+="<input type='checkbox' class='chk'  id=\"" + pictures[0].getPath() + "\"  value='0' />";
for(i=1;i<pictures.length;i++){
html+="<label for='img1'><img class='thumbnail'  src=\"" + pictures[i].getPath() + "\" /></label>";
html+="<input type='checkbox' class='chk'  id=\"" + pictures[i].getPath() + "\" value='0' />";
}
html+="<br><input type='button' id='create' value='Create' onclick='createAlbum()'></input>";
document.getElementById('b1').style.visibility="hidden";
document.getElementById('albumContents').innerHTML=html;

}
var currentUser=sessionStorage.getItem("page1content");
function checkAlbum(){
var group_name=sessionStorage.getItem("currentGroup");
var currentAdmin=sessionStorage.getItem("currentGroupAdmin");
document.getElementById('albumContents').style.display='block';
document.getElementById('slideshow').style.display='none';
if(arguments[0]=='all'){

$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getGroupAlbums", Admin: currentAdmin,group:group_name },async:false
}).done(function( data ) {
  data=JSON.parse(data);
  
  for(i=0;i<data.length;i++){
    loadAlbum(data[i]['album_title'],data[i]['date_created']);
	}
  });
}
else{

searchFlag=1;
	if(albums.length==0){
	alert('no album available to be searched');
	}
	else if(document.getElementById('search').value.length==0){
	alert('Please write something in search field to search  ');
	}
	else{
	for(i=albums.length-1;i>=0;i--){
		if(albums[i].getName().toLowerCase()==document.getElementById('search').value.toLowerCase()){
		 //album found
		 }
		 else{
		 //remove others
		 albums.splice(i,1);
		 }
		}
	 }
	 
	
$('#albumGallery').empty();


}
  for(t=0;t<albums.length;t++){
	
	var title=albums[t].getName();
	$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getPicturesFromGroupAlbum", Admin: currentAdmin,album_title:title,group:group_name },async:false
	}).done(function( data ) {
	temp_names=[];
	var duplicate=0;
	  data=JSON.parse(data);
	  for(i=0;i<data.length;i++){
				for(l=0;l<temp_names.length;l++){
				if(data[i]['image_name']==temp_names[l]){
					duplicate=1;
					break;
				}
			   }
		 if(duplicate==0){
			temp_names.push(data[i]['image_name']);
		  albums[t].addPicture(data[i]['image_name'],data[i]['image_data'],data[i]['title'],data[i]['description'],data[i]['tags'],data[i]['access_rights'],data[i]['creator']);
			}
			duplicate=0;
		}
  });
}  
/*<div class="main"> 
                <!-- FOURTH EXAMPLE -->
                <div class="view view-fourth">
                    <img src="images/13.jpg" />
                    <div class="mask">
                        <h2>Hover Style #4</h2>
                        <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                        <a href="#" class="info">Read More</a>
                    </div>
                </div>
</div>*/
var gallery=new Gallery("Gallery1");
gallery.setNoOfPages();
gallery.display(0);
//by default 0 index for picture
//alert(gallery.no_of_pages);
if(document.getElementById('page_no_div')==null){
 page_no_div=document.createElement("div");
 
page_no_div.id="page_no_div_id";
page_no_div.className="page_no_div";
}

page_no_div.style.position="absolute";
var temp_h=gallery.rows*200+100;
page_no_div.style.top=temp_h+"px";
page_no_div.style.left="20px";
page_no_div.style.width="760px";
//page_no_div.style.height="150px";
page_no_div.style.overflow="auto";
page_no_div.style.display="block";

for(i=1;i<=gallery.no_of_pages;i++){

var li=document.createElement("li");
li.style.listStyle="none";
var page=document.createElement("button");
page.id="page"+i;
var id=""+i;
page.style.float="left";
page.style.marginRight="10px";
page.setAttribute("onclick","showNewPage(id)");



var page_no=document.createTextNode(""+i);
page.appendChild(page_no);
li.appendChild(page);
page_no_div.appendChild(li);

}

document.getElementById('albumGallery').appendChild(page_no_div);

}

</script>
<style>
#createAlbum{
background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 10px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}
#createAlbum:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
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

</style>

<!---->
<body onload="checkAlbum('all')">

<div id='albumContents'>
<div class="form_settings"id="searchForm" >
<p><span></span><input maxlength="100"   type="text" name="search" id="search" placeholder="Search Album based on title" style="width:600px;" value="" /></p>
<p><button style="margin-left:0px;"type="button" class="submit"  name="searchPhoto" onclick="checkAlbum('search')">Search</button></p>					
</div>

<button id="createAlbum" name="createAlbum"onclick='showCreateAlbumForm()'>Create Album</button>

<br>
<br>
<div id="albumGallery"></div>

</div>
<div id="divpopup" style="display:none">
		<label id="Error"style="color:red;"></label>
		<form action="" method="post">
		<div class="form_settings">
		<p><span>Title:</span><input maxlength="50" type="text" name="title" id="title" placeholder="add short title within 50 letters"value="" /></p>
		</div>
        <div id="uploadedPics"style="max-width = '600px';">Add Images in Album:<br><br></div>
		
		</form>
		</div>
<div id="slideshow">
<a href="#" id="uploader"style="font: 170% 'Yanone Kaffeesatz', arial, sans-serif; color: #09D4FF;"></a>
<label id="date_created"style="font: 80% 'Yanone Kaffeesatz', arial, sans-serif; color: #FFF;"></label>

<br>
</div>
</body>


</html>