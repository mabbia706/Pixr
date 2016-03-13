

<?php

session_start();
$mt                    = microtime();
$rand                  = mt_rand();
$oauth_nonce           = md5($mt . $rand);
$request_token_url     = "http://www.flickr.com/services/oauth/request_token";
$nonce                 = $oauth_nonce;
$timestamp             = gmdate('U'); //It must be UTC time
$cc_key                = "17db6bf946cba362a9ac7825f461f66b";
$cc_secret             = "34593a1886e5cacb";
$sig_method            = "HMAC-SHA1";
$oversion              = "1.0";
$callbackURL           = "http://localhost:8080/Project/Pixr/Pixr/phpflickr-master/phpFlickr.php";

$basestring = "oauth_callback=".urlencode($callbackURL)."&oauth_consumer_key=".$cc_key."&oauth_nonce=".$nonce."&oauth_signature_method=".$sig_method."&oauth_timestamp=".$timestamp."&oauth_version=".$oversion;

$baseurl         = "GET&".urlencode($request_token_url)."&".urlencode($basestring);

$hashkey         = $cc_secret."&";
$oauth_signature = base64_encode(hash_hmac('sha1', $baseurl, $hashkey, true));

$fields = array(
           'oauth_nonce'=>$nonce,
           'oauth_timestamp'=>$timestamp,
           'oauth_consumer_key'=>$cc_key,
           'oauth_signature_method'=>$sig_method,
           'oauth_version'=>$oversion,
           'oauth_signature'=>$oauth_signature,
           'oauth_callback'=>$callbackURL
     );

$fields_string = "";

    
//You have to encode each and every field again
foreach($fields as $key=>$value)               
$fields_string .= "$key=".urlencode($value)."&";

$fields_string = rtrim($fields_string,'&');
$url = $request_token_url."?".$fields_string;

$ch         = curl_init(); 
     $timeout    = 5; // set to zero for no timeout 
     curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
$file_contents = curl_exec($ch); 
curl_close($ch); 

$rsp_arr = explode('&',$file_contents); 
print "<pre>";
print_r($rsp_arr); //prints array containing auth token which is used in header
echo $rsp_arr[1];
$_SESSION['Flickr'] = $rsp_arr[2];
header("Location:http://www.flickr.com/services/oauth/authorize?".$rsp_arr[1]."&perms=write");

die;
?>
