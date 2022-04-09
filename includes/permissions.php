<?php
  require_once"dbinfo.php";
  require_once"sessions.php";
  require_once"commands.php";
  
  // this file is used to hold the functions for all the permission commands
   
  function addUserToGroup($userID, $groupID)
  {
  
  }
  
   function createGroup2($groupName)
   {
   $CN = str_replace(" ", "_", $groupName);
   return createGroup($CN, $groupName);
   
   }

   function createGroup($groupName, $groupCommonName)
   {
   if (checkGroupIfExist($groupName))
   {
     return False;
   }
   
   else
   {
     global $db;
     $conn = connect();
      
     $sql ="INSERT INTO `$db`.`extron_permissionGroups` (`groupId`,`groupName`,`Group Common Name`) VALUES ('','$groupName', '$groupCommonName');" ;
     $res = $conn->query($sql);
  	 echo $conn->error;
     if ($res == TRUE)
 		 {
				return TRUE;
 	 	 }
     else
     {
       return False;
       }
   }
  }
  
  function checkGroupIfExist($groupName)
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissionGroups` WHERE `groupName` = '$groupName';";
    $res = $conn->query($sql);
    echo $conn->error;
  	if ($res == TRUE)
 				{
 					if ($res->num_rows > 0){ $conn->close(); return TRUE;} else { return FALSE; }
 				}
  }
  
  function getGroupID($groupName)
  {
    $conn = connect();
    global $db;
    
    $sql = "SELECT * FROM `$db`.`extron_permissionGroups` WHERE `groupName` = '$groupName';";
    
    $res = $conn->query($sql);
    echo $conn ->error;
    if ($res == TRUE)
    {
      $result = $res->fetch_assoc();
      $conn->close();
      return $result['groupId'];
    }
    else {return "error";}    
  
  }
  
  function createPermission($permName)
  {
    if ( getPermIDbyName($permName) == "")
    {
        // we do not have a perm so we can go ahead and insert   
    
    }
    
    else
    {
    	LogError("CreatePermission: $permName already exists");
    }
  }
  
  function returnGroups()
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissionGroups`;";
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $arr = array();
      $i = 0;
      while($result = $res->fetch_assoc())
      {
        $arr[$i] = $result;
        $i++;
      }
      return $arr;
    }
  
  }
    function returnAllPerm()
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissionGroups`;";
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $arr = array();
      $i = 0;
      while($result = $res->fetch_assoc())
      {
        $arr[$i] = $result;
        $i++;
      }
      return $arr;
    }
  }
    function returnAllPerms()
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissions` order by `permid`;";
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $arr = array();
      $i = 0;
      while($result = $res->fetch_assoc())
      {
        $arr[$i] = $result;
        $i++;
      }
      return $arr;
    }
  }
  function permCheckboxArr($groupid)
  {
     $gperms = returnPermPerGroups($groupid);
     $aperms = returnAllPerms();
     $i = 0;
     $found = false;
    echo "<br>";
    
     foreach ($aperms as $a)
     {
     
       
       $found = false;
      
       foreach ($gperms as $g)
       {
         if ($a['permid'] == $g['PermissionId'])
         {
           $found = true;
           $name = $a['permDesc'];
           $id = $g['PermissionId'];
           echo <<<EOL
              <input type="checkbox" name="checkbox{$id}" value="{$id}" checked> {$name}<br>       
           
EOL;
         }
       }
       if ($found == false)
       {
         $name = $a['permDesc'];
         $id = $a['permid'];
          echo <<<EOL
         <input type="checkbox" name="checkbox{$id}" value="{$id}" > {$name}<br>   
EOL;

       }
     }
  
  }
  
  function updatePermissionsArr($permArr, $groupid)
  {
    $allPerm = returnAllPerms();
    $currPerms = returnPermPerGroups($groupid);
    

    // there is not a perm with that name 
    // add permission to group
    global $db;
    $conn = connect();
    //$permid = getPermIDbyName($permissionName);
    
       
    // DELETE QUERY
    $sql = "DELETE FROM  `$db`.`extron_permissionsPerGroup` WHERE `groupId` like '$groupid'";
    $res = $conn->query($sql);
    echo $conn->error;

    foreach ($permArr as $p)
    {
      $sql = "INSERT INTO `$db`.`extron_permissionsPerGroup` (`groupId` , `PermissionId` ) VALUES ($groupid, $p);";
          $res = $conn->query($sql);
          echo $conn->error;
    }



  
  
  }
  
    // dont know if being used so leaving in case
    function returnPermPerGroup($groupid)
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissionGroups` WHERE `groupId` like '$groupid';";
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $arr = array();
      $i = 0;
      while($result = $res->fetch_assoc())
      {
        $arr[$i] = $result;
        $i++;
      }
      return $arr;
    }
  }
        function returnPermPerGroups($groupid)
  {
    $conn = connect();
    global $db;
    $sql = "SELECT * FROM `$db`.`extron_permissionsPerGroup` WHERE `groupId` like '$groupid' order by `PermissionId`;";
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $arr = array();
      $i = 0;
      while($result = $res->fetch_assoc())
      {
        $arr[$i] = $result;
        $i++;
      }
      return $arr;
    }
  
  
  }
  function checkGroup($userId)
  {
    global $db;
    $conn = connect();
    $sql = "SELECT groupID FROM `$db`.`extron_userPermissions` where userID = '$userId';";
    $res = $conn->query($sql);
    $conn -> close();
    if ($res == TRUE)
    {
       $result = $res->fetch_assoc();
       return $result['groupID']; 
    
    }
  }

  function checkPerm($perm)
  {
    global $db;
    $conn = connect();
    $id = $_SESSION['id'];
    $group = checkGroup($id);
    
    $sql = "SELECT groupId FROM `$db`.`extron_permissionsPerGroup` as A join `$db`.`extron_permissions` AS B WHERE A.PermissionId = B.permid AND A.groupId = $group AND B.permName = '$perm';";
    
    $res = $conn->query($sql);
    $ctr = 0;
    if ($res == TRUE)
    {
       while ($result = $res->fetch_assoc())
         $ctr ++;
    }
    $conn->close();
    if ($ctr > 0)
      return TRUE;
    else
      return FALSE;
      

  }
  function getPermIDbyName($permName)
  {
    $conn = connect();
    global $db;
    
    $sql = "SELECT permid FROM `$db`.`extron_permissions` where permName = '$permName';";
    
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $result = $res->fetch_assoc();
      $conn->close();
      return $result['permid'];
    }
    else {return "error";}    
  }
  
  function listPerms()
  {
  
  
  
  }

  function getPermName($permid)
  {
     $conn = connect();
    global $db;
    
    $sql = "SELECT permName FROM `$db`.`extron_permissions` where permid = '$permid';";
    
    $res = $conn->query($sql);
    if ($res == TRUE)
    {
      $result = $res->fetch_assoc();
      $conn->close();
      return $result['permName'];
    }
    else {return false;}    
  }
  
  // check if permission in group exists?
  function checkIfPGroupExist($groupID, $permid)
  {
    global $db;
    $conn = connect();
    
    $SQL = "SELECT * FROM  `$db`.`extron_permissionsPerGroup` WHERE `groupId` Like '$groupID' AND `PermissionId` LIKE '$permid'";
    $res = $conn->query($sql);
    if ($res == TRUE)
      return true;
    else
      return false;
  }
  
  // remove an permission from a gorup  
  function removePermissionFromGroup($groupName, $permid)
  {
      if(checkGroupIfExist($groupName) == TRUE)
      {
        // Group Exists
       $groupID = getGroupID($groupName);
        if (checkIfPGroupExist($groupID, $permid) == true)
        {
         // there is not a perm with that name 
          // add permission to group
          global $db;
          $conn = connect();
          //$permid = getPermIDbyName($permissionName);
      
         
          // DELETE QUERY
          $sql = "DELETE FROM  `$db`.`extron_permissionsPerGroup` WHERE `groupId` like '$groupID' AND `PermissionId` Like '$permid'";
          $res = $conn->query($sql);
          echo $conn->error;
          if ($res == TRUE)
          {
            return TRUE;
          }
        }    
      }
    
  }
  // currently with no error checking
  function addPermissionToGroup($groupName, $permid)
  {
   
      if(checkGroupIfExist($groupName) == TRUE)
      {
        // Group Exists
       $groupID = getGroupID($groupName);
        if (checkIfPGroupExist($groupID, $permid) == false)
        {
         // there is not a perm with that name 
          // add permission to group
          global $db;
          $conn = connect();
          //$permid = getPermIDbyName($permissionName);
      
         
        
          $sql = "INSERT INTO `$db`.`extron_permissionsPerGroup` (`groupId` , `PermissionId` ) VALUES ($groupID, $permid);";
          $res = $conn->query($sql);
          echo $conn->error;
          if ($res == TRUE)
          {
            return TRUE;
          }
        }    
      }
    
  }


    
 

 



?>