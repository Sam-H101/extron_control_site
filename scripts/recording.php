<?php
require_once"../includes/commands.php";
require_once"../includes/charts.php";
require_once"../includes/dbinfo.php";
require_once"../includes/sessions.php";
require_once"../includes/permissions.php";
require_once"../includes/ldapFunctions.php";



$BUTTON = $_POST['buttonpressed'];
$_SESSION['recording1'] = '';
//if (isset($_POST['start_button']))
if($BUTTON=='start_button')
{
  $nodeid = $_POST['nodeVal'];
  $ip = findbyID($nodeid);
  startRec($ip);
  $_SESSION['recording1'] = " \n \n $ip Recording Started d ";
 
  // add stream start command to start button
   if (CheckRTMP($ip) == TRUE)
  {
    startRTMPrec($ip);
   $_SESSION['recording1'] .= "\n $ip Streaming Started";
  }
}

//else if (isset($_POST['stop_button']))
else if($BUTTON=='stop_button')
{
  $nodeid = $_POST['nodeVal'];
  $ip = findbyID($nodeid);
  stopRec($ip);
  $_SESSION['recording1'] = "$ip Recording Stopped";
  // add stream stop command to stop button
  if (CheckRTMP($ip) == TRUE)
  {
    stopRTMPrec($ip);
   // $_SESSION['recording1'] = "$ip Stream Stopped";
  }
}
//else if (isset($_POST['Start_Stream']))
if($BUTTON=='Start_Stream')
{
  $nodeid = $_POST['nodeVal'];
  $ip = findbyID($nodeid);
  if (CheckRTMP($ip) == TRUE)
  {
    startRTMPrec($ip);
    $_SESSION['recording1'] = "$ip Stream Started";
  }
  else
  {
    // function has check, uneeded overhead but to lazy to relog command
    startRTMPrec($ip);
    $_SESSION['recording1'] = "$ip Not setup for Streaming.";
  }

}
//else if (isset($_POST['Stop_Stream']))
if($BUTTON=='Stop_Stream')
{
  $nodeid = $_POST['nodeVal'];
  $ip = findbyID($nodeid);
  if (CheckRTMP($ip) == TRUE)
  {
    stopRTMPrec($ip);
    $_SESSION['recording1'] = "$ip Stream Stopped";
  }
  else
  {
    stopRTMPrec($ip);
    $_SESSION['recording1'] = "$ip Not setup for Streaming.";
  }

}


echo $_SESSION['recording1'];

?>

