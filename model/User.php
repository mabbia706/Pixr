<?php
require_once("DataAccessHelper.php");

class User {    
    private $username="";
    private $name="";
    
    public function __construct($username){
        $this->username = $username;
        $this->load();
    }
    
    private function load(){
        $query = "select * from user where Email='" . $this->username . "'";
        $rs = DataAccessHelper::executeQuery($query);
        
	  if (sizeof($rs) > 0){
		$this->name = $rs[0]["sname"];
	  }
    }
    public static function addUser($name,$email,$password,$coverphoto,$profilephoto){
	 $query = "INSERT INTO `user` (`Name`, `Email`, `Password`,`cover_picture`,`profile_picture`) VALUES ('".$name."', '".$email."', '".$password."', '".$coverphoto."', '".$profilephoto."')";
       $rs = DataAccessHelper::executeQuery($query);
	   return true;
	}
	public static function loginWithFacebook($name,$email,$coverphoto,$profilephoto){
		$query = "select * from user where Email='" .$email. "'";
		 $rs = DataAccessHelper::executeQuery($query);
		if (sizeof($rs) > 0){}
		else{
		$query = "INSERT INTO `user` (`Name`, `Email`, `Password`,`cover_picture`,`profile_picture`) VALUES ('".$name."', '".
		$email."', 'Facebook', '".$coverphoto."', '".$profilephoto."')";
		$rs = DataAccessHelper::executeQuery($query);
	   
		}
		return true;
	
	}
	public static function loginWithFlickr($name,$email,$coverphoto,$profilephoto,$xml){
		$query = "select * from user where Email='" .$email. "'";
		 $rs = DataAccessHelper::executeQuery($query);
		if (sizeof($rs) > 0){}
		else{
		$query = "INSERT INTO `user` (`Name`, `Email`, `Password`,`cover_picture`,`profile_picture`) VALUES ('".$name."', '".
		$email."', 'Flickr', '".$coverphoto."', '".$profilephoto."')";
		$rs = DataAccessHelper::executeQuery($query);	   
		}
		foreach($xml->photos->photo as $photo){
		$rights="";
		$query = "select * from `picture_data` where `Email`='" .$email. "'and `image_name`=".$photo['title']."";
		 $rs = DataAccessHelper::executeQuery($query);
		if (sizeof($rs) > 1){}
		else{
			if($photo['ispublic']==1){
			$rights="Public";
			}
			else{
			$rights="Private";
			}
			$whole_image="https://farm".$photo['farm'].".static.flickr.com/".$photo['server']."/".$photo['id']."_".$photo['secret']."_m.jpg";
			$query = "INSERT INTO `picture_data` (`Email`, `image_name`, `image_data`,`access_rights`) VALUES ('".$email."', '".$photo['title']."', '".$whole_image."','".$rights."')";
			if($rs = DataAccessHelper::executeQuery($query)!='0'){
				return true;
				}
				else{
				return false;
				}
			}
			
		}
		
		return true;

	}
	public static function addPictures($email,$images,$whole_image,$titles,$descriptions,$tags,$rights,$date){
		if(!isset($titles))
		$titles="";
		if(!isset($descriptions))
		$descriptions="";
		if(!isset($tags))
		$tags="";
		if(!isset($rights))
		$rights="Private";
		
		
		
			$query = "INSERT INTO `picture_data` (`Email`, `image_name`, `image_data`,`title`, `description`, `tags`,`access_rights`,`date_created`) VALUES ('".$email."', '".$images."', '".$whole_image."', '".$titles."', '".$descriptions."', '".$tags."', '".$rights."','".$date."')";
		if($rs = DataAccessHelper::executeQuery($query)!='0'){
		return true;
		}
		else{
		return false;
		}
     
	}
	public static function addAlbum($email,$title){
		$query = "INSERT INTO `Album` (`Email`, `album_title`) VALUES ('".$email."', '".$title."')";
		$rs = DataAccessHelper::executeQuery($query);
		return true;
	}
	public static function addPicturesToAlbum($email,$title,$images,$date){
		for($i=0;$i<count($images);$i++){
			$query = "INSERT INTO `Album` (`Email`, `album_title`, `image_name`,`date_created`) VALUES ('".$email."', '".$title."', '".$images[$i]."', '".$date."')";
			$rs = DataAccessHelper::executeQuery($query);
		}
		return true;
     
	}
	
	public static function getName($username){
	   $query = "select * from user where Email='" . $username . "'";
     $rs = DataAccessHelper::executeQuery($query);
	return $rs[0]["Name"];
	}
	public static function getPicturesFromDb($email){
		$query = "select * from picture_data where Email='" . $email . "'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getGroupPictures($email,$group){
		$query = "SELECT distinct * FROM `group` join `group_images`join `picture_data` WHERE `Admin`='".$email."' and `group_name`='".$group."' and `group`.`group_id`=`group_images`.`group_id`and `group_images`.`image_name`=`picture_data`.`image_name`";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getSharedAttrPictures($email){
		$query = "select * from picture_data where Email='" . $email . "'and access_rights ='shared'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getPublicPictures(){
		$query = "select * from picture_data where access_rights ='public'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getPicturesFromAlbum($email,$title){
		$query="SELECT  * FROM `Album`JOIN `picture_data` WHERE `Album`.`Email`=`picture_data`.`Email` and `album_title`='".$title."' and `Album`.`image_name`=`picture_data`.`image_name`and `album`.`Email`='".$email."'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getPicturesFromGroupAlbum($email,$title,$group){
		$query="SELECT  * FROM `group_albums`JOIN `group` join `picture_data` WHERE `group`.`Admin`='".$email."'and `group_name`='".$group."' and `album_title`='".$title."' and `group_albums`.`image_name`=`picture_data`.`image_name`and `group`.`group_id`=`group_albums`.`group_id`";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getAlbums($email){
		$query = "select distinct`album_title`,`date_created` from Album where Email='" . $email . "'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getGroupAlbums($email,$group){
		$query = "select distinct`album_title`,`group_albums`.`date_created` from `group` join `group_albums` where `Admin`='" . $email . "'and `group_name`='".$group."'and `group`.`group_id`=`group_albums`.`group_id`";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getComments($email,$picture){
		$query = "select * from Comment where Email='" . $email . "'and image_name='".$picture."'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	
	public static function getProfileAndCoverPhoto($email){
		$query = "select * from user where Email='" . $email . "'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function updateCoverPhoto($email,$photo){
		$query = "UPDATE `user` SET `cover_picture`='".$photo."' where Email='" . $email . "'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function updateGroupCoverPhoto($email,$photo,$group){
		$query = "UPDATE `group` SET `cover_photo`='".$photo."' where `Admin`='" . $email . "'and `group_name`='".$group."'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function updateProfilePicture($email,$photo){
		$query = "UPDATE `user` SET `profile_picture`='".$photo."' where Email='" . $email . "'";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getAllUsers($currentUser){
		$query = "Select* from `user` where `Email`!='".$currentUser."'ORDER BY `Email`" ;
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getGroupsCreated($currentUser){
		$query = "Select* from `group` where `Admin`='".$currentUser."'ORDER BY `group_name`" ;
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getGroupsJoined($currentUser){
		$query = "Select* from `group` join `group_members` where `group_members`.`member`='".$currentUser."'and `group`.`group_id`=`group_members`.`group_id` ORDER BY `group_name`" ;
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getGroupDetails($currentUser,$group){
		$query = "Select* from `group`join `group_members` where `Admin`='".$currentUser."'and `group_name`='".$group."'and `group`.`group_id`=`group_members`.`group_id`" ;
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function getJoinedGroupDetails($currentUser,$group){
		$query = "Select* from `group`join `group_members` where `group_name`='".$group."'and `group`.`group_id`=`group_members`.`group_id`" ;
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function insertComments($email,$picture,$comment,$uploader){
		$query = "insert into Comment (`Email`, `image_name`,`comment`, `Email_Commentator`) VALUES ('".$uploader."', '".$picture."', '".$comment."', '".$email."')";
		$rs = DataAccessHelper::executeQuery($query);
		return $rs;
	}
	public static function createGroup($admin,$group,$member,$date){
		$query = "insert into `group` (`Admin`,`group_name`, `cover_photo`,`date_created`) VALUES ('".$admin."', '".$group."', 'images/defaultgroupcover.png','".$date."')";
		$rs = DataAccessHelper::executeQuery($query);
		$query1 = "Select `group_id` from `group` where `Admin`='".$admin."'and `group_name`='".$group."'";
		$rs1 = DataAccessHelper::executeQuery($query1);
		for($i=0;$i<sizeof($member);$i++){
		$query2 = 	"insert into `group_members` (`group_id`,`member`) VALUES ('".$rs1[0]["group_id"]."', '".$member[$i]."')";
		$res=DataAccessHelper::executeQuery($query2);
		}
		return $res;
	}
	public static function uploadImageToGroup($user,$group,$image,$image_name,$admin){
	$query1 = "Select `group_id` from `group` where `Admin`='".$admin."'and `group_name`='".$group."'";
		$rs1 = DataAccessHelper::executeQuery($query1);
		$query2 = 	"insert into `group_images` (`group_id`,`image_data`,`image_name`,`uploader`) VALUES ('".$rs1[0]["group_id"]."', '".$image."','".$image_name."','".$user."')";
		$res=DataAccessHelper::executeQuery($query2);
	return $res;
	}
	public static function addPicturesToGroupAlbum($user,$title,$images,$group,$admin,$date){
		$query1 = "Select `group_id` from `group` where `Admin`='".$admin."'and `group_name`='".$group."'";
		$rs1 = DataAccessHelper::executeQuery($query1);
	
		for($i=0;$i<count($images);$i++){
			$query = "INSERT INTO `group_albums` (`group_id`, `album_title`, `image_name`, `creator`,`date_created`) VALUES ('".$rs1[0]["group_id"]."', '".$title."', '".$images[$i]."', '".$user."', '".$date."')";
			$rs = DataAccessHelper::executeQuery($query);
		}
		return true;
     
	}
	public static function checkDuplicateGroup($currentUser,$group){
	 $query = "select * from `group` where`group_name`='".$group."'";
	  $rs = DataAccessHelper::executeQuery($query);
	   if (sizeof($rs) > 0){
		return true; 
	 }
	 else{
	 return false;
	 }
	 	
	}
	public static function checkForDuplicate($email){
	 $query = "select * from user where Email='" . $email . "'";
	  $rs = DataAccessHelper::executeQuery($query);
	 if (sizeof($rs) > 0){
		return true; 
	 }
	 else{
	 return false;
	 }
		
	}
	public static function checkAlbumName($email,$title){
	 $query = "select * from Album where Email='" . $email . "'and album_title='" . $title . "'";
	  $rs = DataAccessHelper::executeQuery($query);
	 if (sizeof($rs) > 0){
		return true; 
	 }
	 else{
	 return false;
	 }
		
	}
	public static function checkGroupAlbumName($email,$title,$group){
	 $query = "select * from `group` join `group_albums` where `Admin`='" . $email . "'and album_title='" . $title . "'and `group_name`='".$group."'and `group`.`group_id`=`group_albums`.`group_id`";
	  $rs = DataAccessHelper::executeQuery($query);
	 if (sizeof($rs) > 0){
		return true; 
	 }
	 else{
	 return false;
	 }
		
	}
	
    public static function validate($username,$password){
        $query = "select * from user where Email='" . $username . "'";
        $rs = DataAccessHelper::executeQuery($query);

	  if (sizeof($rs) > 0){

		if($rs[0]["Password"] == $password){
                    return true;
            	}
	  }        
        return false;
    }
	public static function myservice_getName($email){
		$query = "select `Name`,`Email` from `user` where Email='" . $email . "'";
        $rs = DataAccessHelper::executeQuery($query);
		
	  if (sizeof($rs) > 0){

		return $rs;
	  }        
       // return "invalid email";
	}
	public static function myservice_getPhotos($email){
		$query = "select `picture_data`.`Email`,`image_name`,`image_data` from `user`join`picture_data` on `user`.`Email`=`picture_data`.`Email` where `picture_data`.`Email`='" . $email . "'";
        $rs = DataAccessHelper::executeQuery($query);
		
	  if (sizeof($rs) > 0){

		return $rs;
	  }        
       // return "invalid email";
	}
} ?>
