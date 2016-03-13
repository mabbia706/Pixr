var abc = 0;      // Declaring and defining global increment variable.

$(function(){
    $("#upload_link").on('click', function(e){
		e.preventDefault();
        $("#file:hidden").trigger('click');
    });
});




var temp=[];
var title=[];
var description=[];
var tags=[];
var accessrights=[];
var valaccessrights=[];
var image_data=[];

$(document).ready(function() {


//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
$('#add_more').click(function() {
$('#filediv').before($("<div/>", {
id: 'filediv'
}).fadeIn('slow').append($("<input/>", {
name: 'file[]',
type: 'file',
id: 'file'
}), $("")));
});
// Following function will executes on change event of file input to select different file.
$('body').on('change', '#file', function () {
var files=this.files;
for(var g=0,f;f=files[g];g++){

//if (this.files[0]) {
abc += 1; // Incrementing global variable by 1.
var z = abc - 1;
//var x = $(this).parent().find('#previewimg' + z).remove();
$('#result').empty();
$('#browsedfiles').append("<div id='abcd" + abc + "' class='abcd'></div>");
$("#abcd" + abc).append($("<a/>", {
id: 'upload_link' + abc,
href:'#',
}).click(function() {

var link_id=($(this).attr("id"));
link_id=link_id.replace( /\D+/g, '');
$('#current').html(temp[link_id-1]);
$('#title').val(title[link_id-1]);
$('#description').val(description[link_id-1]);
$('#tags').val(tags[link_id-1]);
$('#accessrights').val(valaccessrights[link_id-1]);

$('#divpopup').dialog({
	title:"Image atributes",
	width:500,
	height:500,
	modal:true,
	buttons:{
		Apply:
		function(){
		title[link_id-1]=$("#title").val();
		description[link_id-1]=$("#description").val();
		tags[link_id-1]=$("#tags").val();
		accessrights[link_id-1]=$( "#accessrights option:selected" ).text();
		valaccessrights[link_id-1]=$( "#accessrights option:selected" ).val();
		$(this).dialog('close');
		},
		Close:
		function(){
		$(this).dialog('close');
		}
	
	}
	
	});


}));

$("#upload_link" + abc).append($("<img/>", {
id: 'previewimg' + abc,
src: '',
alt: 'browsing'
}));

var reader = new FileReader();
reader.id=abc;
reader.onload =function imageIsLoaded(e) {
image_data.push(e.target.result);
$('#previewimg' + $(this).attr('id')).attr('src', e.target.result);
};
reader.readAsDataURL(f);
temp.push(f.name);
//$(this).hide();

$("#abcd" + abc).append($("<img/>", {
id: 'img',
src: 'x.png',
alt: 'delete'
}).click(function() {
abc-=1;
$(this).parent().remove();
var id=($(this).parent().attr("id"));
id=id.replace( /\D+/g, '');
temp.splice(id-1,1);
image_data.splice(id-1,1);

title.splice(id-1,1);
description.splice(id-1,1);
tags.splice(id-1,1);

//assigning new ids to div after removing to achive consistency
var k=1;
$('#browsedfiles').children().each(function () {
   $(this).attr('id','abcd' +k);
   $(this).children('a').attr('id','upload_link' +k);
   $(this).children('a').children('img').attr('id','previewimg' +k);
   
	k++;
});
}));
}

});


// To Preview Image
$('#loadPictures').click(function(e) {

$.post('controller/UserController.php',{action:'getPictures',user:id },
	function( data ) {
	data=(jQuery.parseJSON(data));
	alert(data.length);
    });
loadPictures();
//showPhotoStream();
});
$('#upload').click(function(e) {

var name = $(":file").val();
if (temp.length<=0) {
alert("No Image available to be uploaded");

}
else{

var stringed = JSON.stringify(temp);
var data = JSON.stringify(image_data);
var image_title = JSON.stringify(title);
var image_description = JSON.stringify(description);
var image_tag = JSON.stringify(tags);
var image_rights = JSON.stringify(accessrights);
var user = document.getElementById("user");
var currDate=new Date();
/*
$.post('../controller/UserController.php',{images: stringed,whole_image:data,titles:image_title,descriptions:image_description,tags:image_tag,rights:image_rights,action:'upload',user:user.innerHTML },
	function( data ) {
	$('#browsedfiles').empty();
		$('#result').empty();
       $('#result').append(data);
	   temp.splice(0,temp.length);
	   image_data.splice(0,image_data.length);
	   title.splice(0,title.length);
	   description.splice(0,description.length);
	   tag.splice(0,tag.length);
	   accessrights.splice(0,accessrights.length);
    });*/
	$('#browsedfiles').empty();
		$('#result').empty();
document.getElementById('progresscircle').style.display="block";

  var formdata = new FormData();
	formdata.append("images", stringed);
	formdata.append("whole_image",data);
	formdata.append("titles",image_title);
	formdata.append("descriptions",image_description);
	formdata.append("tags",image_tag);
	formdata.append("rights",image_rights);
	formdata.append("action",'upload');
	formdata.append("user",user.innerHTML );
	formdata.append("date",currDate );
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", function(event){
	//document.getElementById("status").innerHTML = event.target.responseText;
	//document.getElementById("progressBar").value = 0;
	$('#browsedfiles').empty();
		$('#result').empty();
		document.getElementById('progresscircle').style.display="none";
       $('#result').append(event.target.responseText);
	   temp.splice(0,temp.length);
	   image_data.splice(0,image_data.length);
	   title.splice(0,title.length);
	   description.splice(0,description.length);
	   tag.splice(0,tag.length);
	   accessrights.splice(0,accessrights.length);
    //Do something success-ish
	
	
	}, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "../controller/UserController.php");
	ajax.send(formdata);
	
}
});
function progressHandler(event){

	//document.getElementById("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	//document.getElementById("progressBar").value = Math.round(percent);
	//document.getElementById("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
	al=Math.round(percent);
		diff = ((al / 100) * Math.PI*2*10).toFixed(2);
	ctx.clearRect(0, 0, cw, ch);
	ctx.lineWidth = 20;
	ctx.fillStyle = '#09F';
	ctx.strokeStyle = "#09F";
	ctx.textAlign = 'center';
	ctx.font="30px Arial";
	ctx.fillText(al+'%', cw*.5, ch*.5+2, cw);
	ctx.beginPath();
	ctx.arc(150, 150, 140, start, diff/10+start, false);
	ctx.stroke();
//	if(al >= 100){
		//clearTimeout(sim);
	    // Add scripting here that will run when progress completes
	//}
	//al++;

}
function errorHandler(event){
	document.getElementById("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	document.getElementById("status").innerHTML = "Upload Aborted";
}

});

