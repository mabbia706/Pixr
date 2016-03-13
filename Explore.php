<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/SlideShow.css">

<link rel="stylesheet" type="text/css" href="css/PhotoStream.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/Profile.js"></script>
<!--slideshow view-->
<script type="text/javascript">

document.addEventListener('keydown', function(event) {
//setInterval(function() {
	
//}, 1000);
var textarea = document.getElementById("comment");
    
 if (document.activeElement === textarea) {
 
 }
else{		
if(event.keyCode == 37) {
				slideShowPool[0].decrementCurrentId();
		   slideShowPool[0].performSlideShow();
	   
		}
		else if(event.keyCode == 39) {
			slideShowPool[0].incrementCurrentId();
		   slideShowPool[0].performSlideShow();
	   
	   
		}
}
    
});
var slideShowPool=new Array();
function SlideShow(currentId,id){
this.currentId=currentId;
this.id=id;
slideShowPool[id]=this;

}
SlideShow.prototype.decrementCurrentId=function(){
if(this.currentId>0){
	  this.currentId=this.currentId-1;
	  }
	  else{
	  this.currentId=publicPictures.length-1;
	  }
}
SlideShow.prototype.incrementCurrentId=function(){
if(this.currentId<publicPictures.length-1){
	  this.currentId=this.currentId+1;
	  }
	  else{
	  this.currentId=0;
	  }
}

SlideShow.prototype.performSlideShow=function(){

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
	previous.setAttribute('href','#');
	previous.className="navigator";
	var id=this.id;
    previous.onclick = function() { // Note this is a function
       slideShowPool[id].decrementCurrentId();
	   slideShowPool[id].performSlideShow();
    };
	document.getElementById('slideshow').appendChild(previous);
	
}
if(document.getElementById('uploader').firstChild!=null){
document.getElementById('uploader').removeChild(document.getElementById('uploader').firstChild);
}
document.getElementById('uploader').appendChild(document.createTextNode("Uploaded By "+publicPictures[this.currentId].getUploader()));
document.getElementById('date_created').innerHTML=publicPictures[this.currentId].getDate();
var slider=document.getElementById('image');
if(slider==null){
var view=document.createElement("div");
//view.id=albums[i].getName();
view.className="view view-first";

var img = document.createElement("img");
    img.src = publicPictures[this.currentId].getPath();
var comment=new Comment(this.currentId);
	
    img.alt = "Pixr";
	img.hspace=5;
	img.id='image';
	view.appendChild(img);
	
		var mask=document.createElement("div");
	mask.className="mask";
	
	var h2=document.createElement("h2");
	h2.id="h2";
var title=document.createTextNode(publicPictures[this.currentId].getTitle());
	h2.appendChild(title);
	var p=document.createElement("p");
	p.id="para";
	p.style.maxWidth = "700px";
	p.style.wordWrap = "break-word";
	
	var description=document.createTextNode(publicPictures[this.currentId].getDescription());
p.appendChild(description);
p.appendChild(document.createElement("BR"));
p.appendChild(document.createElement("BR"));
p.appendChild(document.createElement("BR"));
var tags=document.createTextNode(publicPictures[this.currentId].getTags().replace(/\s/g, "#") );
p.appendChild(tags);
	mask.appendChild(h2);
	mask.appendChild(p);
	view.appendChild(mask);
	
 document.getElementById('slideshow').appendChild(view);
 
 }
 else{
 slider.src=publicPictures[this.currentId].getPath();
 
Comment(this.currentId);
	 
 
 var myNode = document.getElementById("para");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
myNode = document.getElementById("h2");
while (myNode.firstChild) {
    myNode.removeChild(myNode.firstChild);
}
var t=document.createTextNode(publicPictures[this.currentId].getTitle());
	document.getElementById("h2").appendChild(t);

 	var desc=document.createTextNode(publicPictures[this.currentId].getDescription());
document.getElementById("para").appendChild(desc);
	document.getElementById("para").style.maxWidth = "700px";
	document.getElementById("para").style.wordWrap = "break-word";
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
var tg=document.createTextNode(publicPictures[this.currentId].getTags().replace(/\s/g, "#") );
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
       slideShowPool[id].incrementCurrentId();
	   slideShowPool[id].performSlideShow();
    };
	document.getElementById('slideshow').appendChild(next);
  }
  var timer;
  if(document.getElementById('stop')==null){
var stop = document.createElement("a");
stop.id='stop';
	stop.setAttribute('href','#');
stop_text=document.createTextNode('Stop Slide');	
 stop.appendChild(stop_text);
stop.style.visibility="hidden"; 
stop.onclick = function() { // Note this is a function
clearInterval(timer);
document.getElementById('prev').style.visibility="visible";
document.getElementById('next').style.visibility="visible";
document.getElementById('auto').style.visibility="visible";
document.getElementById('commentBox').style.visibility="visible";
//slideShowPool[id].decrementCurrentId();
document.getElementById('image').src=publicPictures[slideShowPool[id].currentId].getPath();
stop.style.visibility="hidden"; 

};
	document.getElementById('slideshow').appendChild(stop);
}
if(document.getElementById('auto')==null){
var auto = document.createElement("a");
auto.id='auto';
auto.setAttribute('href','#');
auto_text=document.createTextNode('Auto Slide');	
 auto.appendChild(auto_text);	
auto.onclick = function() { // Note this is a function
 stop.style.visibility="visible";
document.getElementById('prev').style.visibility="hidden";
document.getElementById('next').style.visibility="hidden";
document.getElementById('auto').style.visibility="hidden";
document.getElementById('commentBox').style.visibility="hidden";

timer=setInterval(function() {
document.getElementById('image').className += "fadeOut";

setTimeout(function() {

	document.getElementById('uploader').innerHTML=publicPictures[slideShowPool[id].currentId].getUploader();
 document.getElementById('image').src=publicPictures[slideShowPool[id].currentId].getPath();
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
var t=document.createTextNode(publicPictures[slideShowPool[id].currentId].getTitle());
	document.getElementById("h2").appendChild(t);

 	var desc=document.createTextNode(publicPictures[slideShowPool[id].currentId].getDescription());
document.getElementById("para").appendChild(desc);
document.getElementById("para").style.maxWidth = "700px";
document.getElementById("para").style.wordWrap = "break-word";
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
document.getElementById("para").appendChild(document.createElement("BR"));
var tag=document.createTextNode(publicPictures[slideShowPool[id].currentId].getTags().replace(/\s/g, "#") );
document.getElementById("para").appendChild(tag);
slideShowPool[id].incrementCurrentId();

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
function Comment(currentPic){
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

submit.appendChild(document.createTextNode("Add Comment"));
document.getElementById('commentBox').appendChild(submit);
//var prev_noc=pictures[currentPic].getNoOfComments()+ " Comments";

$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getPublicPictureComments", uploader:publicPictures[currentPic].getUploader() ,picture:publicPictures[currentPic].getName() },async:false
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
		publicPictures[currentPic].addComment(data[i]['comment']);
		document.getElementById('commentBox').appendChild(user);
		document.getElementById('commentBox').appendChild(com);
	}
  });
  


//no_com.innerHTML =prev_noc;
submit.onclick=function(){
var currentUser=sessionStorage.getItem("page1content");

var newcom=document.getElementById('comment').value;
publicPictures[currentPic].addComment(newcom);
var noc=publicPictures[currentPic].getNoOfComments()+ " Comments";
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
  data: { action: "insertComments", user:currentUser,picture:publicPictures[currentPic].getName(),comment:document.getElementById('comment').value,uploader:publicPictures[currentPic].getUploader() },async:false
})
  .done(function( data ) {
	//alert(data.length);
  });
document.getElementById('comment').value="";



}
//;


}
</script>



<!--gallery view-->
<script type="text/javascript">
var galleryPool=new Array();
var display_count=0;

function Gallery(){
this.id=arguments[0];
this.rows=5;//this should be not more than 5
this.cols=7;//this should be not more than 7
this.max_no_of_images_per_page=0;
this.no_of_pages=0;

this.gallery_images=new Array();
galleryPool[0]=this;

}
Gallery.prototype.setNoOfPages=function(){

this.max_no_of_images_per_page=this.rows*this.cols;
this.no_of_pages=parseFloat(publicPictures.length/this.max_no_of_images_per_page);

this.no_of_pages=Math.ceil(this.no_of_pages);
}

var searchFlag=0;
Gallery.prototype.display=function(){
if(publicPictures.length==0){
if(searchFlag==0)
alert('Currently there are no pictures in Explore');
	if(searchFlag==1){
	alert('No Image Found in current gallery');
	location.reload();
	}
}
else{
var width=this.cols*116;
var height=this.rows*116;
var photo=document.createElement("div");
photo.className="photo";

var topic=document.createElement("UL");
topic.className="topic";

var li_set=document.createElement("LI");
var link_set=document.createElement("a");
link_set.className="set";
link_set.setAttribute("href","#Portraits");
var link_set_text=document.createTextNode("Gallery View");
link_set.appendChild(link_set_text);
li_set.appendChild(link_set);


var container_ul=document.createElement("UL");

container_ul.style.width=width+"px";
//container_ul.style.height=height+"px";
for(i=arguments[0];i<this.rows*this.cols;i++){
if(i==publicPictures.length){
break;
}
var pic_li=document.createElement("li");
var id=""+i;
pic_li.id=id;
var pic_link=document.createElement("a");
var ind=i+1;
ind=""+ind;
pic_link.id="pic_link"+i;
pic_link.setAttribute('href','#');
pic_link.onclick=function(){
//alert(this.id[this.id.length-1]);
document.getElementById('slideshow').style.display='block';
document.getElementById('content_id').style.display='none';
document.getElementById('searchForm').style.display='none';
var param=this.id.replace( /^\D+/g, '');

var obj=new SlideShow(parseInt(param),0);
obj.performSlideShow();


};


var image=document.createElement("img");
this.gallery_images.push(image);
image.id="img"+i;
image.alt="";
image.title="";

image.src=publicPictures[i].getPath();

pic_link.appendChild(image);
pic_li.appendChild(pic_link);
//pic_li.style.visibility="hidden";

container_ul.appendChild(pic_li);

}
var page_no_div;

var br=document.createElement("BR");
br.className="clear";

li_set.appendChild(container_ul);
topic.appendChild(li_set);
photo.appendChild(topic);
photo.appendChild(br);

document.getElementById('content_id').appendChild(photo);
}
}

function showNewPage(){
var index=arguments[0].replace(/\D/g,'');
index=index-1;
var starting_id=0;
starting_id=index*galleryPool[0].rows*galleryPool[0].cols;
//alert(starting_id);
for(j=0;j<galleryPool[0].rows*galleryPool[0].cols;j++){
if(starting_id<pictures.length){
if(document.getElementById(""+j).style.visibility="hidden"){
document.getElementById(""+j).style.visibility="visible";
}
document.getElementById("img"+j).src=publicPictures[starting_id].getPath();
//document.getElementById("pic_link"+j).setAttribute('href','SlideShow.php?'+starting_id);
document.getElementById("pic_link"+j).onclick=function(){
//alert(this.id[this.id.length-1]);
document.getElementById('slideshow').style.display='block';
document.getElementById('searchForm').style.display='none';
document.getElementById('content_id').style.display='none';

var param=this.id.replace( /^\D+/g, '');
param=parseInt(param);

var param=index*galleryPool[0].rows*galleryPool[0].cols+param;

var obj=new SlideShow(parseInt(param),0);
obj.performSlideShow();

var comment=new Comment();

};

starting_id++;
}
else{
document.getElementById(""+j).style.visibility="hidden";
}
}



}
</script>


<script type="text/javascript">


function showExplore(){

document.getElementById('searchForm').style.display='block';
document.getElementById('content_id').style.display='block';
document.getElementById('slideshow').style.display='none';

var currentUser=sessionStorage.getItem("page1content");
if(arguments[0]=='all'){

$.ajax({
  type: "POST",
  url: "controller/UserController.php",
  data: { action: "getPublicPictures" },async:false
})
  .done(function( data ) {
  data=JSON.parse(data);
  for(i=0;i<data.length;i++){
    loadPublicPicture(data[i]['image_name'],data[i]['image_data'],data[i]['title'],data[i]['description'],data[i]['tags'],data[i]['access_rights'],data[i]['Email'],data[i]['date_created']);
	}
  });
}
else{
searchFlag=1;
	if(publicPictures.length==0){
	alert('no image available to be searched');
	}
	else if(document.getElementById('search').value.length==0){
	alert('Please write something in search field to search  ');
	}
	else{
	strgs=[];
	strgs = document.getElementById('search').value.split(" ");
	for(i=publicPictures.length-1;i>=0;i--){
		for (j=0;j<strgs.length;j++){
		 if((publicPictures[i].getTitle().toLowerCase().indexOf(strgs[j].toLowerCase())!=-1)||(publicPictures[i].getTags().toLowerCase().indexOf(strgs[j].toLowerCase())!=-1)){
		 //image found with title or tags
		 }
		 else{
		 publicPictures.splice(i,1);
		 }
	  }
	 }
	 
	}
$('#content_id').empty();
}

var gallery=new Gallery("Gallery1");
gallery.setNoOfPages();
gallery.display(0);//by default 0 index for picture
//alert(gallery.no_of_pages);

if(document.getElementById('page_no_div')==null){
page_no_div=document.createElement("div");
 
page_no_div.id="page_no_div_id";
page_no_div.className="page_no_div";
}

page_no_div.style.position="absolute";
var temp_h=gallery.rows*116+200;
page_no_div.style.top=temp_h+"px";
page_no_div.style.left="60px";
page_no_div.style.width="760px";
//page_no_div.style.height="100px";
page_no_div.style.overflow="auto";

for(i=1;i<=gallery.no_of_pages;i++){
var li=document.createElement("li");
var page=document.createElement("button");
page.id="page"+i;
var id=""+i;
page.style.marginRight="10px";
page.setAttribute("onclick","showNewPage(id)");



var page_no=document.createTextNode(""+i);
page.appendChild(page_no);
li.appendChild(page);
page_no_div.appendChild(li);

}

document.getElementById('content_id').appendChild(page_no_div);
//hell("page1");

}
</script>
</head>
<body onload="showExplore('all')">

<div id="site_content">
 <div class="form_settings"id="searchForm" >
<p><span></span><input maxlength="100"   type="text" name="search" id="search" placeholder="Search photo based on tags or title separate each title or tag with space" style="width:600px;" value="" /></p>
<p><button style="margin-left:0px;"type="button" class="submit"  name="searchPhoto" onclick="showExplore('search')">Search</button></p>					
</div>

<div class="content"id="content_id">
</div>
<div id="slideshow">
<a href="#" id="uploader"style="font: 170% 'Yanone Kaffeesatz', arial, sans-serif; color: #09D4FF;"></a>
<label id="date_created"style="font: 80% 'Yanone Kaffeesatz', arial, sans-serif; color: #FFF;"></label>

 </div>
 
 
 <!--dummy-->
</body>
<script>
document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};

</script>

</html>