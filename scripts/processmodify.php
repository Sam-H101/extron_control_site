<?php
  require_once"../includes/commands.php";
  require_once"../includes/charts.php";
  require_once"../includes/dbinfo.php";
  require_once"../includes/sessions.php";
  require_once"../includes/permissions.php";
  require_once"../includes/ldapFunctions.php";

  if (isset($_POST))
  {
   // if post event occurs
   
     $ip = str_replace(' ','',$_POST['ip']);
     $loc = str_replace(' ','',$_POST['loc']);
     $Building = str_replace(' ','',$_POST['Building']);
     $u = str_replace(' ','',$_POST['user']);
     $p = str_replace(' ','',$_POST['pass']);
     $in1 = str_replace(' ','',$_POST['in1']);
     $in2 = str_replace(' ','',$_POST['in2']);
     $oldip = str_replace(' ','',$_POST['oldip']);
     updateNode( $ip, $loc, $Building, $u, $p , $in1, $in2, $oldip);
     
     

 
  
  
  
  }



?>