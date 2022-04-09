 
<?php

require_once"../includes/commands.php";
require_once"../includes/charts.php";
require_once"../includes/dbinfo.php";
require_once"../includes/sessions.php";
require_once"../includes/permissions.php";
require_once"../includes/ldapFunctions.php";
$res = "";

 global $db;
 
$cal_id = $_POST['cal_id'];
global $db;
$conn = connect();
$sql = "SELECT `cal_html`, `cal_iframe`, `BUILDING` from `$db`.`extron_calendars` join `$db`.`extron_panels` WHERE `ex_id` = $cal_id and`id_panels` =`ex_id`;";
$res = $conn->query($sql);
if ($res->num_rows != 0 && $res == TRUE)
{
  $results = $res ->fetch_assoc();
                                                 
  $build = $results['BUILDING'];
                                                 
                                               
  if(!checkCalanderPerms($build, $results['cal_html']) == FALSE)
      $res = $results['cal_iframe'];
  $conn->close();
}

                                              
echo $res;
                                           
                                            
?>