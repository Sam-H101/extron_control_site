<?php
	set_time_limit(0);
	require_once "../includes/times_Function.php";
	require_once "../includes/commands.php";
  require_once "../autorun.php";
	 	global $db;
 		$conn = connect();
 		$sql = "select * from `$db`.`extron_panels`;";
 		$res = $conn->query($sql);
 		while ($result = $res->fetch_assoc())
 		{
		echo $result['ipaddr'] . '<br>' ;
      runCommands($result['ipaddr']);
			sleep(1);
		}

?>
