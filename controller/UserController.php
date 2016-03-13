<?php require_once("../model/User.php");
 ?>

<?php

if(isset($_REQUEST["action"])||isset($_POST["action"])){
	session_start(); 
	if ($_REQUEST["action"] == "login"){
		loginHandler(mysql_real_escape_string($_REQUEST["username"]),md5(mysql_real_escape_string($_REQUEST["password"])));
	}
	else if($_REQUEST["action"] == "loginwithfacebook"){
		loginWithFacebook($_REQUEST["name"],$_REQUEST["email"]);
	}
	else if($_REQUEST["action"] == "loginwithflickr"){
		loginWithFlickr($_REQUEST["name"],$_REQUEST["email"]);
	}
	else if($_REQUEST["action"] == "logout"){
		logoutHandler();
	}
	else if($_REQUEST["action"] == "signup"){
		signUpHandler(strip_tags($_REQUEST["name"]),strip_tags($_REQUEST["username"]),strip_tags($_REQUEST["password"]),strip_tags($_REQUEST["confirmpassword"]));
	}
	else if($_POST["action"] == "getPictures"){
		getPictures($_POST["user"]);
	}
	
	else if($_POST["action"] == "getGroupPictures"){
		getGroupPictures($_POST["Admin"],$_POST["group"]);
	}
	else if($_POST["action"] == "getSharedAttrPictures"){
		getSharedAttrPictures($_POST["user"]);
	}
	else if($_POST["action"] == "getPublicPictures"){
		getPublicPictures();
	}
	else if($_POST["action"] == "getProfileAndCoverPhoto"){
		getProfileAndCoverPhoto($_POST["user"]);
	}
	else if($_POST["action"] == "updateCoverPhoto"){
		updateCoverPhoto($_POST["user"],$_POST["photo"]);
	}
	else if($_POST["action"] == "updateGroupCoverPhoto"){
		updateGroupCoverPhoto($_POST["user"],$_POST["photo"],$_POST["group"]);
	}
	else if($_POST["action"] == "updateProfilePicture"){
		updateProfilePicture($_POST["user"],$_POST["photo"]);
	}
	else if($_POST["action"] == "getAlbums"){
		getAlbums($_POST["user"]);
	}
	else if($_POST["action"] == "getGroupAlbums"){
		getGroupAlbums($_POST["Admin"],$_POST["group"]);
	}
	else if($_POST["action"] == "getComments"){
		getComments($_POST["user"],$_POST["picture"]);
	}
	else if($_POST["action"] == "getPublicPictureComments"){
		getComments($_POST["uploader"],$_POST["picture"]);
	}
	else if($_POST["action"] == "insertComments"){
		insertComments($_POST["user"],$_POST["picture"],$_POST["comment"],$_POST["uploader"]);
	}
	else if($_POST["action"] == "getPicturesFromAlbum"){
		getPicturesFromAlbum($_POST["user"],$_POST["album_title"]);
	}
	else if($_POST["action"] == "getPicturesFromGroupAlbum"){
		getPicturesFromGroupAlbum($_POST["Admin"],$_POST["album_title"],$_POST["group"]);
	}
	else if($_POST["action"] == "Add Album"){
		addAlbum($_POST["user"],$_POST["album_title"]);
	}
	else if($_POST["action"] == "checkAlbumName"){
		CheckAlbumName($_POST["user"],$_POST["album_title"]);
	}
	else if($_POST["action"] == "checkGroupAlbumName"){
		CheckGroupAlbumName($_POST["Admin"],$_POST["album_title"],$_POST["group"]);
	}
	else if($_POST["action"] == "Add Pictures To Album"){
		addPicturesToAlbum($_POST["user"],$_POST["album_title"],$_POST["date"]);
	}
	else if($_POST["action"] == "Add Pictures To Group Album"){
		addPicturesToGroupAlbum($_POST["user"],$_POST["album_title"],$_POST["group"],$_POST["Admin"],$_POST["date"]);
	}
	else if ($_POST["action"] == "upload"){
		upload_images($_POST["user"]);
	}
	else if ($_POST["action"] == "getAllUsers"){
		getAllUsers($_POST["user"]);
	}
	else if ($_POST["action"] == "createGroup"){
		createGroup($_POST["user"],$_POST["group"],$_POST["grp_members"],$_POST["date"]);
	}
	else if ($_POST["action"] == "checkDuplicateGroup"){
		checkDuplicateGroup($_POST["user"],$_POST["group"]);
	}
	else if ($_POST["action"] == "getGroupsCreated"){
		getGroupsCreated($_POST["user"]);
	}
	else if ($_POST["action"] == "getGroupsJoined"){
		getGroupsJoined($_POST["user"]);
	}
	else if ($_POST["action"] == "getGroupDetails"){
		getGroupDetails($_POST["user"],$_POST["group"]);
	}
	else if ($_POST["action"] == "getJoinedGroupDetails"){
		getJoinedGroupDetails($_POST["user"],$_POST["group"]);
	}
	else if ($_POST["action"] == "uploadImageToGroup"){
		uploadImageToGroup($_POST["user"],$_POST["group"],$_POST["image"],$_POST["image_name"],$_POST["Admin"]);
	}
}
	
?>


<?php

	function Error($errorMessage,$page,$username){
	if(isset($username)){
	header("Location: ../".$page."?username=".$username."&error=" . $errorMessage);
		
	}
	else{
		header("Location: ../".$page."?error=" . $errorMessage);
		}
	}
	function signUpHandler($name,$email,$password,$confirmpassword){
	
		if(isset($name)&&isset($email)&&isset($password)&&isset($confirmpassword)){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format"; 
			Error($emailErr,'Sign_Up.php',$email);
			}
			else if(User::checkForDuplicate($email)){
			Error('Email Already in Use','Sign_Up.php',$email);
			}
			else if (
						strlen($password) < 8 /*||
						preg_match('/[A-Z]/', $password) <= 0 ||
						preg_match('/[a-z]/', $password) <= 0 */)
			{
				Error('Minimum password length is 8','Sign_Up.php',$email);
				
			}

			else if($confirmpassword!=$password){
			Error('Passwords do not match','Sign_Up.php',$email);
			}
			else{
				$coverphoto="images/DefaultCoverPhoto.jpg";
				$profilephoto="images/DefaultProfilePhoto.jpg";
				if(User::addUser($name,$email,md5($password),$coverphoto,$profilephoto)){
					header("Location: ../Sign_In.php?Message='You are added to Pixr You can Sign In'");
				}
			}
		}
		else{
				Error('All fields must be filled ','Sign_Up.php',$email);
		}
	}
	function loginHandler($username,$password){
		if ( isset($username) && isset($password) && 
			User::validate($username,$password ) ) {
			$_SESSION["user"] =$username;
			$name=User::getName($username);
			header("Location: ../Profile.php?name=".$name."&email=" . $username);
		}
		else{
		Error("'invalid email or password'",'Sign_In.php',$username);
			
		}
	}
	function logoutHandler(){
	if(isset($_SESSION["user"])){
		$_SESSION["user"] = null;
		}
		else if(isset($_SESSION["name"])){
						$_SESSION["name"] = null;
		}
		else if(isset($_SESSION["Flickr"])){
						$_SESSION["Flickr"] = null;
		}
		header("Location: ../pixr.php");	
	}
	
	function upload_images($email){
	$user="";$images="";$whole_image="";$titles="";$descriptions="";$tags="";$rights="";$date="";
	if(isset($_POST['images'])){
		$images = json_decode(str_replace('\\', '', $_POST['images']));
		}
		if(isset($_POST['whole_image'])){
	
		$whole_image = json_decode(str_replace('\\', '', $_POST['whole_image']));
		}
		if(isset($_POST['titles'])){
	
		$titles = json_decode(str_replace('\\', '', $_POST['titles']));
		}
		if(isset($_POST['descriptions'])){
	
		$descriptions = json_decode(str_replace('\\', '', $_POST['descriptions']));
		}
		if(isset($_POST['tags'])){
	
		$tags = json_decode(str_replace('\\', '', $_POST['tags']));
		}
		if(isset($_POST['rights'])){
	
		$rights = json_decode(str_replace('\\', '', $_POST['rights']));
		}
		if(isset($_POST['user'])){
	
		$user =$_POST['user'];
		}
		if(isset($_POST['date'])){
		$date=$_POST['date'];
		}
		
		$target_path = "../uploads/";
		  
		$j = 0;     // Variable for indexing uploaded image.
		     // Declaring Path for uploaded images.
		for ($i = 0; $i <sizeof($images); $i++) {
		// Loop to get individual element from the array
		$validextensions = array("jpeg", "jpg", "png");      // Extensions which are allowed.
		$ext = explode('.', basename($images[$i]));   // Explode file name from dot(.)
		$file_extension = end($ext); // Store extensions in the variable.
		$target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext) - 1];     // Set the target path with a new name of image.
		$j = $j + 1;      // Increment the number of uploaded images according to the files in array.
		if (/*getimagesize($whole_image[$i])< 1000000&&*/    // Approx. 1mb files can be uploaded.*/
		 in_array($file_extension, $validextensions)) {
		/*if (move_uploaded_file($whole_image[$i], $target_path)) {*/
		// If file moved to uploads folder.
		if(!isset($titles[$i]))
		$titles[$i]="";
		if(!isset($descriptions[$i]))
		$descriptions[$i]="";
		if(!isset($tags[$i]))
		$tags[$i]="";
		if(!isset($rights[$i]))
		$rights[$i]="Private";
		
		if($file_extension=="jpeg"||$file_extension=="jpg"){
			$img = imageCreateFromJpeg(($whole_image[$i])); 
			if($img != false) 
			{ 
			$temp=str_replace("'",'',$images[$i]);
			$target_path = "../uploads/".$temp;
				imagejpeg($img,$target_path); 
				
				$whole_image[$i]="uploads/".$temp;
			} 
		}
		else if($file_extension=="png"||$file_extension=="png"){
			$img = imageCreateFromPng(($whole_image[$i])); 
			if($img != false) 
			{ 
			$temp=str_replace("'",'',$images[$i]);
			$target_path = "../uploads/".$temp;
				imagePng($img,$target_path); 
				$whole_image[$i]="uploads/".$temp;
			}
			
		}
		if(User::addPictures($email,$images[$i],$whole_image[$i],$titles[$i],$descriptions[$i],$tags[$i],$rights[$i],$date)){
		echo "<span id='noerror'>$j).$images[$i] uploaded successfully!.</span><br/><br/>";
		}
		else{
		echo "<span id='error'>$j).$images[$i] already exists!.</span><br/><br/>";
		}
		
		}/* else {     //  If File Was Not Moved.
		echo $j. ').<span id="error">Unable to upload Please try again!.</span><br/><br/>';
		}
		}*/ else {     //   If File Size And File Type Was Incorrect.
		echo  "<span id='error'>$j).$images[$i]***Invalid file Size or Type***</span><br/><br/>";
		}
		}
		
	
	}
	function getPictures($email){
	
		$val=User::getPicturesFromDb($email);
		echo json_encode($val);
			
	}
	function getSharedAttrPictures($email){
	
		$val=User::getSharedAttrPictures($email);
		echo json_encode($val);
			
	}
	function addAlbum($email,$title){
		User::addAlbum($email,$title);
	}
	function checkAlbumName($email,$title){
		if(User::checkAlbumName($email,$title)){
		echo 'Exists';
		}
		
	}
	function addPicturesToAlbum($email,$title,$date){
		if(isset($_POST['pics'])){
			$images = json_decode(str_replace('\\', '', $_POST['pics']));
			User::addPicturesToAlbum($email,$title,$images,$date);
		}
	}
	function addPicturesToGroupAlbum($email,$title,$group,$admin,$date){
		if(isset($_POST['pics'])){
			$images = json_decode(str_replace('\\', '', $_POST['pics']));
			User::addPicturesToGroupAlbum($email,$title,$images,$group,$admin,$date);
		}
	}
	function getAlbums($email){
		$val=User::getAlbums($email);
		echo json_encode($val);
	}
	function getGroupAlbums($email,$group){
		$val=User::getGroupAlbums($email,$group);
		echo json_encode($val);
	}
	function getPicturesFromAlbum($email,$title){
		$val=User::getPicturesFromAlbum($email,$title);
		echo json_encode($val);
	
	}
	function getPicturesFromGroupAlbum($email,$title,$group){
		$val=User::getPicturesFromGroupAlbum($email,$title,$group);
		echo json_encode($val);
	
	}
	function getComments($email,$picture){
		$val=User::getComments($email,$picture);
		echo json_encode($val);
	}
	function insertComments($email,$picture,$comment,$uploader){
		User::insertComments($email,$picture,$comment,$uploader);
	}
	function getProfileAndCoverPhoto($email){
		$val=User::getProfileAndCoverPhoto($email);
		echo json_encode($val);
	}
	function updateCoverPhoto($email,$photo){
		User::updateCoverPhoto($email,$photo);
	}
	function updateGroupCoverPhoto($email,$photo,$group){
		User::updateGroupCoverPhoto($email,$photo,$group);
	}
	function updateProfilePicture($email,$photo){
		User::updateProfilePicture($email,$photo);
	}
	function getPublicPictures(){
		$val=User::getPublicPictures();
		echo json_encode($val);
	}
	function getAllUsers($currentUser){
		$val=User::getAllUsers($currentUser);
		echo json_encode($val);
	}
	function getGroupsCreated($currentUser){
		$val=User::getGroupsCreated($currentUser);
		echo json_encode($val);
	}
	function getGroupsJoined($currentUser){
		$val=User::getGroupsJoined($currentUser);
		echo json_encode($val);
	}
	function createGroup($currentUser,$group,$grp_members,$date){
		$members = json_decode(str_replace('\\', '', $grp_members));
		User::createGroup($currentUser,$group,$members,$date);
		
	}
	function checkDuplicateGroup($currentUser,$group){
		if(User::checkDuplicateGroup($currentUser,$group)){
		echo "Exists";
		}
		else{
			echo "";
		}
	}
	function getGroupDetails($currentUser,$group){
		$val=User::getGroupDetails($currentUser,$group);
		echo json_encode($val);
	}
	function getJoinedGroupDetails($currentUser,$group){
		$val=User::getJoinedGroupDetails($currentUser,$group);
		echo json_encode($val);
	}
	function uploadImageToGroup($user,$group,$image,$image_name,$Admin){
		User::uploadImageToGroup($user,$group,$image,$image_name,$Admin);
	}
	function getGroupPictures($user,$group){
		$val=User::getGroupPictures($user,$group);
		echo json_encode($val);
	}
	function checkGroupAlbumName($user,$album,$group){
		if(User::checkGroupAlbumName($user,$album,$group)){
		echo 'Exists';
		}
	}
	function loginWithFacebook($name,$email){
				$coverphoto="images/DefaultCoverPhoto.jpg";
				$profilephoto="images/DefaultProfilePhoto.jpg";
		User::loginWithFacebook($name,$email,$coverphoto,$profilephoto);
		header("Location: ../Profile.php?name=".$name."&email=" . $email);
	}
	function loginWithFlickr($name,$email,$xml){
				$coverphoto="images/DefaultCoverPhoto.jpg";
				$profilephoto="images/DefaultProfilePhoto.jpg";

		User::loginWithFlickr($name,$email,$coverphoto,$profilephoto,$xml);
		header("Location: ../Profile.php?name=".$name."&email=" . $email);
	}
	function myservice_getName($email){
		$result=User::myservice_getName($email);
		return $result;
	}
	function myservice_getPhotos($email){
		$result=User::myservice_getPhotos($email);
		return $result;
	}
?>


