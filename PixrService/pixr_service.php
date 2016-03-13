<?php
require_once ("../controller/UserController.php");

if(isset($_GET['user_email']) && isset($_GET['method'])&&isset($_GET['format'])) {
if($_GET['method']=="getName"){
	/* soak in the passed variable or set our own */
	$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default
	$user_id = ($_GET['user_email']); //no default

	
	/* create one master array of the records */
	$posts = array();
	$posts=myservice_getName($user_id);

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<post>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>',htmlentities($value);
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</post>';
	}

	}
	if($_GET['method']=="getPhotos"){
	/* soak in the passed variable or set our own */
	$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default
	$user_id = ($_GET['user_email']); //no default

	
	/* create one master array of the records */
	$posts = array();
	$posts=myservice_getPhotos($user_id);

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<post>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>',htmlentities($value);
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</post>';
	}

	}
}







?>