	<?php
  date_default_timezone_set('America/New_York');
	$date_command = date('m/d/Y h:i:s a', time());
	require_once'Net/SSH2.php';
	require_once'dbinfo.php';
	require_once'updates.php';
	require_once'charts.php';
  require_once'sessions.php';
  require_once'commands.php';
  
  function checkLDAPPerms_1($username)
{
   	global $db;
 		$conn = connect();
    $sql = "SELECT * From `$db`.`extron_userPermissions` where `userID` = '$username';";
    
    $result = $conn->query($sql);
    echo $conn->error;
    if (!($conn->error)){
    
      if ($result->num_rows > 0){
        return true;
      }
      else
        {
          $sql1 = "INSERT INTO `$db`.`extron_userPermissions` ( `groupID`, `userID`) VALUES(4, '$username');";
          $result1 = $conn->query($sql1);
          
          if ($result1 != TRUE)
          {
            returnError($conn);
          }
        }
    }
    $conn->close();
}


// get the perm group of a user
function getUserPermGroup($userID)
  {
 	  global $db;
 		$conn = connect();
    $permRole = "";
    $sql = "SELECT * From `$db`.`extron_userPermissions` where `userID` = '$userID';";
    
    $result = $conn->query($sql);
    if (!($conn->error)){
    
      if ($result->num_rows > 0){

        while ($res = $result->fetch_assoc())
        {
          $permRole = $res['groupID'];
         
        }
      }
    
    return $permRole;
  }

}

// return all permisson groups
function getAllPermGroups()
  {
    global $db;
    $conn = connect();
    $sql = "select * from `$db`.`extron_permissionGroups`;";
    $result = $conn->query($sql);
     if (!($conn->error)){
       $conn->close(); 
       return $result;
     }

     else { echo $conn->error; }  
}  




function permGroupsToSelect($id1)
{
  $groups = getAllPermGroups();
  while($group = $groups->fetch_assoc())
  {

    $id = $group['groupId'];   
    $name = $group['Group Common Name'];   
    echo  "<option value="; 
    echo  ' " ';
    echo $id;
    echo ' " ';
    if ($id == getUserPermGroup($id1))
    {
      echo 'selected = "selected"';
    }
    echo " > $name </option>";
    echo "\n";
    
    
  }

}


// Get permission group common name from db
function getPermCommonNameOfUser($username)
{
    global $db;
 		$conn = connect();
    $permRole = "";
    $sql = "SELECT `Group Common Name` as GroupName From `$db`.`extron_userPermissions` as a join `$db`.`extron_permissionGroups` as b  where `a`.`groupID` = `b`.`groupID` and `userID` = '$username';";
    
    $result = $conn->query($sql);
    echo $conn->error;
    if (!($conn->error)){
    
      if ($result->num_rows > 0){

        while ($res = $result->fetch_assoc())
        {
          $permRole = $res['GroupName'];
        }
      }
    $conn->close();
    return $permRole;
  }

}
// Get the Permission Group name, not common name from the database
function getPermNameOfUser($username)
{
    global $db;
 		$conn = connect();
    $permRole = "";
    $sql = "SELECT groupName From `$db`.`extron_userPermissions` as a join `$db`.`extron_permissionGroups` as b  where `a`.`groupID` = `b`.`groupID` and `userID` = '$username';";
    
    $result = $conn->query($sql);
    echo $conn->error;
    if (!($conn->error)){
    
      if ($result->num_rows > 0){

        while ($res = $result->fetch_assoc())
        {
          $permRole = $res['GroupName'];
        }
      }
    $conn->close();
    return $permRole;
  }

}

// update the permissions of a user account
function updatePermGroupOfUser($username, $groupID)
{
    global $db;
    $conn = connect();
    $sql = "UPDATE `$db`.`extron_userPermissions` SET `groupID`= '$groupID' WHERE `userID` = '$username';";
    $result = $conn->query($sql);
    if(!($conn->error)){
      return true;
    } 
    else {return false;}
}

	function parseAllUsersToJSON()
	{
		global $host;
		global $db;
		global $user;
		global $pass;
		$table = 'extron_v_UsersWithRoles';


 
		// Table's primary key
		$primaryKey = 'userID';
 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier - in this case object
		// parameter names
		$columns = array(
		array(
				'db' => 'userID',
				'dt' => 'dt_userID',
				'formatter' => function( $d, $row ) {
					// Technically a DOM id cannot start with an integer, so we prefix
					// a string. This can also be useful if you have multiple tables
					// to ensure that the id is unique with a different prefix
					return 'row_'.$d;
				}
			),
			
			array( 'db' => 'userID', 'dt' => 'dt_userID' ),
			array( 'db' => 'Group Common Name',  'dt' => 'dt_GCN' ),
	
	
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
		
		
			echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
			);
		
	}



	function parseAllRolesToJSON()
	{
		global $host;
		global $db;
		global $user;
		global $pass;
		$table = 'extron_permissionGroups';


 
		// Table's primary key
		$primaryKey = 'GroupId';
 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier - in this case object
		// parameter names
		$columns = array(
		array(
				'db' => 'groupId',
				'dt' => 'dt_groupID',
				'formatter' => function( $d, $row ) {
					// Technically a DOM id cannot start with an integer, so we prefix
					// a string. This can also be useful if you have multiple tables
					// to ensure that the id is unique with a different prefix
					return 'row_'.$d;
				}
			),
			
			array( 'db' => 'groupId', 'dt' => 'dt_groupID' ),
			array( 'db' => 'Group Common Name',  'dt' => 'dt_GCN' ),
	
	
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
		
		
			echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
			);
		
	}



?>
  
  
  