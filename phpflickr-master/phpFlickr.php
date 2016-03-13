<?php
require_once ("../controller/UserController.php");
session_start();
if(isset($_GET['oauth_token'])&&isset($_GET['oauth_verifier'])){
$oauth_token=$_GET['oauth_token'];
$oauth_verifier=$_GET['oauth_verifier'];

$mt                    = microtime();
$rand                  = mt_rand();
$oauth_nonce           = md5($mt . $rand);
$nonce                 = $oauth_nonce;
$timestamp             = gmdate('U'); //It must be UTC time
$cc_key                = "17db6bf946cba362a9ac7825f461f66b";
$cc_secret             = "34593a1886e5cacb";
$sig_method            = "HMAC-SHA1";
$oversion              = "1.0";
$callbackURL           = "http://localhost:8080/Project/Pixr/Pixr/phpflickr-master/phpFlickr.php";
$format				="json";
$oauth_token_secret=$_SESSION['Flickr'];
$oauth_token_secret=str_replace("oauth_token_secret=","",$oauth_token_secret);

$request_token_url = 'http://www.flickr.com/services/oauth/access_token';
$page = 1;
$basestring = "oauth_consumer_key=".$cc_key."&oauth_nonce=".$nonce."&oauth_signature_method=".$sig_method."&oauth_timestamp=".$timestamp."&oauth_token=".$oauth_token."&oauth_verifier=".$oauth_verifier."&oauth_version=".$oversion;//."&format=".$format."&nojsoncallback=1"."&page=". ((string) $page)."&per_page=500"."&user_id=me"

$basestring = "GET&".urlencode($request_token_url)."&".urlencode($basestring);
$hashkey = $cc_secret."&".$oauth_token_secret;

$oauth_signature = base64_encode(hash_hmac('sha1', $basestring, $hashkey, true));

$fields = array(
           'oauth_nonce'=>$nonce,
           'oauth_timestamp'=>$timestamp,
           'oauth_verifier'=>$oauth_verifier,
           'oauth_consumer_key'=>$cc_key,
           'oauth_signature_method'=>$sig_method,
           'oauth_version'=>$oversion,
           'oauth_token' => $oauth_token,
           'oauth_signature'=>$oauth_signature/*,
		   'format'=>$format,
		   'nojsoncallback'=>"1",
		   'page'=>((string) $page),
		   'per_page'=>"500",
		   'user_id'=>"me"*/
		   
     );

 $fields_string = "";
 foreach($fields as $key=>$value)    
           $fields_string .= "$key=".urlencode($value)."&";
 $fields_string = rtrim($fields_string,'&');
  
 $url = $request_token_url."?".$fields_string;
  $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, ($url ));
    $result = curl_exec($curl);
	curl_close($curl); 

	$data=explode('&',$result);//index 0 fullname,index 1 oauth_token,index 2 oauth_token_secret,index 3 user_nsid,index 4 username
	$fullname=str_replace("fullname=","",$data[0]);
	$fullname=str_replace("%20"," ",$fullname);
	$username=str_replace("username=","",$data[4]);
	$username=str_replace("%20"," ",$username);
	$user_nsid=str_replace("user_nsid=","",$data[3]);
	//$user_nsid=str_replace("%40","@",$user_nsid);
	$_SESSION['Flickr']=$username;
 
 //getting photos of user

 //getting certifiacte to remove ssl error
$arrContextOptions=array(
    "ssl"=>array(
        "cafile" => "ca-bundle.crt",
        "verify_peer"=> true,
        "verify_peer_name"=> true,
    ),
);  
$getPhotoUrl="https://api.flickr.com/services/rest/?method=flickr.people.getPhotos&api_key=17db6bf946cba362a9ac7825f461f66b&user_id=".$user_nsid."&format=rest";
$xml = simplexml_load_file($getPhotoUrl);
//$json=json_encode($xml);
//$photo=json_decode($json,true);
//echo $photo[0]->['id'].'<br>';
loginWithFlickr($fullname,$username,$xml);
//header("Location: ../controller/UserController.php?action=loginwithflickr&name=".$fullname."&email=" .$username."");
	 

}


?>
