<?php
  require_once ("../includes/permissions.php");
  
  
  

  if (!empty($_POST))
  {
  
    $Group = $_POST['nGroup'];
    $creation = createGroup2($Group);
    
    if ($creation == TRUE)
    {
      echo "Successful Creation Of User Group";
    }
    else
    {
      echo "There was an error creating group";
    
    }
  }
  
  else
  {
     header( "refresh:0;url=/pages/index.php" );
  }

?>