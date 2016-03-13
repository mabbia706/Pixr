<?php
class DataAccessHelper {	

	public static function executeQuery($sql)
	{
		$conn = DataAccessHelper::getConnection();
		$rs = array();

		// Performing SQL query
		
	
		$result = mysql_query($sql,$conn); //or die('Query failed: ' . mysql_error($conn));
		if(!$result){
		return '0';
		}
		// Preparing rs
		
		while ($record = @mysql_fetch_array($result, MYSQL_ASSOC)) {
 		    $row = array();	
			foreach ($record as $col => $value) {
			$row[$col] = $value;
		    }
		    $rs[] = $row;		
		}
		//Free result-set
		@mysql_free_result($result);
		// Closing connection
		mysql_close($conn);
		return $rs;		
		
	}
		public static function executePicturesQuery($sql)
	{
		$conn = DataAccessHelper::getConnection();
		$rs = array();

		// Performing SQL query
		
	
		$result = mysql_query($sql,$conn) or die('Query failed: ' . mysql_error($conn));

		// Preparing rs
		
		while ($record = @mysql_fetch_array($result, MYSQL_ASSOC)) {
 		    $row = array('Email'=>$record['Email'],'image_name'=>$record['image_name'],'image_data'=>$record['image_data'],'title'=>$record['title'],'description'=>$record['description'],'tags'=>$record['tags'],'access_rights'=>$record['access_rights']);		
		    
		    array_push($rs,$row);		
		}
		//Free result-set
		@mysql_free_result($result);
		// Closing connection
		mysql_close($conn);
		return $rs;		
		
	}
	
	private static function getConnection()
	{
		$conn = null;
		$conn = mysql_connect('localhost', 'root', '');
		mysql_select_db('pixr');	
		return $conn;
	}

}
?>
