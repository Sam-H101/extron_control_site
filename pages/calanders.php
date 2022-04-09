


<?php

require_once"../includes/commands.php";
require_once"../includes/charts.php";
require_once"../includes/dbinfo.php";
require_once"../includes/sessions.php";
     $res = returnAllNodes();
     
     $nodeArr = array();
     while($result = $res->fetch_assoc()) 
     {
         $calander = $result['id_panels'];
         $location = $result['commonname'];
         
         $nodeArr[] = array($calander,$location);         
         //echo "<li><a href=" . '"' . "index.php?cal_id=$calander". '"' . ">$location</a></li>";
          
     }
     
  
     
     echo json_encode($nodeArr);
     
     
?>