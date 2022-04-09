<?php 
  require_once("commands.php");
  require_once("dbinfo.php");
  require_once("nodes.php");
  
  $conn = connect();
  
  ###################################################################
  ##################### CREATION FUNCTIONS ##########################
  #                                                                 #
  #   Includes all of the commands needed to add a new node to the  #
  #   System and create the needed assocated parts for the front    #
  ###################################################################
  
  
  
  # function createNode($ip, $username, $pass, $commonname , $location, $building);
  # function createPanelSettings($ip, $top, $bottom);
  # function createCal($iframe, $calkey);
  # function createPermissionForNode($pername, $perdesc);
  # function createPermissionPanelDisplayAssoc($permname);
  # function addPermtogroup($perm, $groupID);
  
  
  
  // add a new node to the panel
  function createNode($ip, $username, $pass, $commonname , $location, $building)
  {
    global $conn;
    global $db;
    $stmt = $conn->prepare("INSERT INTO `$db`.`extron_panels`(`ipaddr`, `location`, `BUILDING`, `commonname`, `telnetpass`, `telnetuser`, `isRec`) VALUES (?,?,?,?,?,?,0);");
    $stmt->bind_param("ssssss", $ipaddr, $loc, $build, $cname, $tpass, $tuser);
    $ipaddr = $ip;
    $loc = $location;
    $build = $building;
    $cname = $commonname;
    $tpass = $pass;
    $tuser = $username; 
    
    $stmt->execute();  
  
  }
  
  // add the top and bottom channel inputs
  function createPanelSettings($ip, $top, $bottom)
  {
  
  }
  
  function createCal($iframe, $calkey)
  {
    global $conn;
    global $db;
    
    
  }

  function createPermissionForNode($pername, $perdesc)
  {
  
  }
  
  function createPermissionPanelDisplayAssoc($permname)
  {
  
  }
  
  function addPermtogroup($perm, $groupID)
  
  {
  
  
  }
?>



?>