<?php
	require_once"commands.php";
	require_once"dbinfo.php";
	require_once"ping.php";
	
	function selectAllNodes()
	{
		global $db;
		$conn = connect();
		$sql = "SELECT * from `$db`.`extron_panels`;";
		$result = $conn->query($sql);
		if ($result == TRUE)
		{
			return $result;
		}	
	}


	function deleteNode($ip)
	{
		global $db;
		$conn = connect();
		$sql = "DELETE FROM `$db`.`extron_panels` WHERE `ipaddr` = '$ip';";
		$result = $conn->query($sql);
		
		if ($result == TRUE)
		{
			return "Deleteion of $ip Successful";
		}
		else
		{
			LogError("Deletion of $ip Failed");
			return "Deletion Failure";
			
		
		}
	
	}
	function parseAllNodesToJSON()
	{
		global $host;
		global $db;
		global $user;
		global $pass;
		$table = 'extron_panels';


 
		// Table's primary key
		$primaryKey = 'id_panels';
 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier - in this case object
		// parameter names
		$columns = array(
		array(
				'db' => 'id_panels',
				'dt' => 'dt_id',
				'formatter' => function( $d, $row ) {
					// Technically a DOM id cannot start with an integer, so we prefix
					// a string. This can also be useful if you have multiple tables
					// to ensure that the id is unique with a different prefix
					return 'row_'.$d;
				}
			),
			
			array( 'db' => 'ipaddr', 'dt' => 'dt_ipaddr' ),
			array( 'db' => 'location',  'dt' => 'dt_location' ),
			array( 'db' => 'commonname',   'dt' => 'dt_commonname' ),
	
		);
 
		$sql_details = array(
			'user' => "$user",
			'pass' => "$pass",
			'db'   => "$db",
			'host' => "$host",
		);
 
 
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* If you just want to use the basic configuration for DataTables with PHP
	* server-side, there is no need to edit below this line.
	*/

 

		require( 'ssp.class.php' );
		
/*		
			echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
			);

*/	
   $data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
  // var_dump($data);
  $i = 0;
  $res[] = array();
  foreach($data['data'] as $d)
  {
  
    $png = pingAddress($d['dt_ipaddr']);
    $arr = array('status'=>$png);
   
   $res1 = array_merge($data['data'][$i], $arr);
    $data['data'][$i] = array_replace($data['data'][$i], $res1);
//    $data['data'][$i] = $res;
//    var_dump($data['data'][$i];
    $i++;
  }
   
   echo json_encode($data);
	

}	
?>