<?php 
	require_once"commands.php";
	require_once"dbinfo.php";
	


	function returnChartLog($days)
	{
		global $db;
		$conn = connect();
		$sql = "SELECT `Date`, `count` as Count  FROM `$db`.`extron_sevenDayLogSummery` WHERE `Date` >= DATE(NOW() - INTERVAL 7 DAY)";		
		$result = $conn->query($sql);
		if ($result == TRUE)
		{
			$conn->close();
			return $result;
		}
		
		else
		{
			return returnError($conn);
			
		}
	
	}
	
	function countChartXDays($days)
	{
		global $db;
		$conn = connect();
		$sql = "SELECT `id`, `extron_id`, SUM(`count`) as cnt from `$db`.`extron_sevenDayLog` where `Date` >= DATE(NOW() - INTERVAL $days DAY) GROUP BY `extron_id`;";		
		$result = $conn->query($sql);
		if ($result == TRUE)
		{
			$conn->close();
			return $result;
		}
		
		else
		{
			return returnError($conn);
			
		}
	
	}
	
	// returns daily count of all the chart logs per machine id
	function countChartOneDay()
	{
		return countChartXDays(0);
	
	}
	
	// returns daily total of starts / stops
	function sumChartsDailyData()
	{
		$result = countChartOneDay();
		$ctr = 0;
		if ($result == NULL)
			return 0;
		while ($res = $result -> fetch_assoc())
		{
			$ctr = $ctr + $res['cnt'];
		}
		return $ctr;
	}
	
	function setDailyCounts()
	{
		global $db;
		$conn = connect();
		resetAllRecLogs();
		$ct = sumChartsDailyData();
    $date = date("Y-m-d");
		$sql = "INSERT INTO `$db`.`extron_sevenDayLogSummery` (`count`, `Date`) VALUES ($ct, '$date');";
		if (!$conn->query($sql))
		{
     
			return returnError($conn);
		}
		$conn->close();
	}
	
	
	function updateChartTable($ip, $count)
	{
		global $db;
		$conn = connect();
		$id = returnID($ip);
    $date = date("Y-m-d");
		$sql = "INSERT INTO `$db`.`extron_sevenDayLog` (`extron_id`, `count`, `Date`) VALUES ($id, $count,'$date');";
		
		$result = $conn->query($sql);
		if ($result != TRUE)
		{
		
			return returnError($conn);
		}
		$conn->close();
	
	}
	
 
	function formatChart($days)
	{
		$data = returnChartLog($days);
		
		$arr = array();
		while ($dat = $data->fetch_assoc())
		{
			$arr[] = $dat;
			
		}
		
		$chartData = json_encode($arr);
		return $chartData;
	}
	
	
	
	
	
	
	
?>	