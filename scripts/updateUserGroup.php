<?php
  require_once"../includes/userroles.php";
  
  $id = "";
  $group = "";
  if (isset($_POST['id']))
  {
    $id = $_POST['id'];
    
  
  }


  if (isset($_POST['roles']))
  {
    $group = $_POST['roles'];
  }
  
  if ($id == "")
  {  

    header( "refresh:0;url=/pages/modifyusers.php" );
  }
  
  
  if ($group == "")
  {
    
    header( "refresh:0;url=/pages/modifyusers.php" );
  }
  

    if (!(checkPerm("permission_modify_perm_groups_admin")) && $group == 1)
    {
      header( "refresh:0;url=/pages/modifyusers.php" );
      $_SESSION['groupError'] = "Unable to add to Full Admin Group";
     
      
    }
     else if (checkPerm("permission_modify_perm_groups") && $group != 1)
    {
    // if can update all but admin group
      updatePermGroupOfUser($id, $group);
  
    
    }
    else if (checkPerm("permission_modify_perm_groups_admin"))
    {
         // if admin
      updatePermGroupOfUser($id, $group);
 
    }


  
  header( "refresh:0;url=/pages/modifyusers.php" );
  
  

?>