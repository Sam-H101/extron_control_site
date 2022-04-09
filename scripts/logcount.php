<?php
//	ini_set('display_errors', 1);
	require_once"../includes/commands.php";
  
  if (isset($_GET['sec']) == 'log_count')
    {
      $logs = ReturnLogCountLogs();
        if (empty($logs))
           print_r(json_encode($logs)); 
        else
           print_r($logs); 
    } 
	else if (isset($_GET['sec1']) == 'all_log')
   {
     $logs = ReturnLogs();
       if (empty($logs))
           print_r(json_encode($logs)); 
        else
           print_r($logs); 
   }
  else if (isset($_GET['sec2']) == 'crit')
   {
      $logs = ReturnCritLogs();
       if (empty($logs))
           print_r(json_encode($logs)); 
        else
           print_r($logs); 
   }
?>
