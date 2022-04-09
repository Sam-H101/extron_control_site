<?php 

	// functions for version updates
	// for mostly reference and to show that there are updates avaliable to have an update server once setup.
	require_once'dbinfo.php';
	require_once"commands.php";
	function getCurrVersion()
	{
		global $db;
		$conn = connect();
		
		$sql = "SELECT * FROM `$db`.extron_panelVersion;";
		$results = $conn->query($sql);
		if ($results == true)
		{
			$res = $results->fetch_assoc();
			$conn->close();
			return $res['versionNum'];
			
		
		}
	
	}

	function pushUpdate($ver)
	{
		global $db;
		
		
		$conn = connect();
		
		$sql = "INSERT INTO `$db`.`extron_panelVersion` (`versionNum`) VALUES ('$ver')";
		$results = $conn->query($sql);
		if ($results != TRUE)
		{
			echo returnError($conn);
		}
	
		$conn->close();
	}

	function countAvalUpdates()
	{
		global $db;
		$conn = connect();
		$sql = "SELECT COUNT(*) as cnt FROM `$db`.`extron_panelVersion`
      where versionNum > 1.3;";
		$results = $conn->query($sql);
		$res = $results->fetch_assoc();
		$conn->close();
		
		return ($res['cnt'] - 1);
	
	}

	function truncateVersion()
	{
		global $db;
		$conn = connect();
	
		$sql = "TRUNCATE TABLE `$db`.`extron_panelVersion`;";
 		if (!$conn->query($sql))
 			echo returnError($conn);
 		$conn->close();
 
	}

?>