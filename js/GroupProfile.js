
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
  this.date_created=arguments[7];
  
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
  
  this.getDate=function(){
  return this.date_created;
  }
  
  

}
 
var pictures = new Array();
var albums=new Array();
function loadPicture(image_name,image_data,title,description, tags,access_rights,uploader,date){
pictures.push(new Picture(image_data,image_name,title,description,tags,access_rights,uploader,date));
}
function loadAlbum(album_title,date){
albums.push(new Album(album_title,date));

}
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


