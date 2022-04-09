<?php
	// listnodes.php
	require_once"../includes/commands.php";
  require_once"../includes/userroles.php";
  require_once"../includes/sessions.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Modify Users</title>

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables CSS -->
        <link href="../css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="../css/dataTables/dataTables.responsive.css" rel="stylesheet">

		<link href="../css/dataTables/dt.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
 
    <?php      if (checkAPerm('permission_modify_perm_groups') != 1)
                    {
                      header( "refresh:0;url=/pages/index.php" );
                      echo checkAPerm('permission_modify_perm_groups');
                    } else {
    
    ?>
    <body>
	
    <?php if (!(isset($_GET['id'])))
    {
      header( "refresh:0;url=/pages/modifyusers.php" );
    }
    if (strtoupper($_GET['id']) == strtoupper($_SESSION['username']))
    {
    
      header( "refresh:0;url=/pages/modifyusers.php" );
    }
    if (checkGroup(strtoupper($_GET['id'])) == 1 && checkGroup(strtoupper($_SESSION['username'])) != 1)
    {
      header( "refresh:0;url=/pages/modifyusers.php" );
    }
    else {
   	include("partial/header.php");
    ?>
    
		<div id="page-wrapper">
		 <!-- /.row -->
		 <br><br><br><br>
        <div class="container">
        <h2>Modify <?php echo $_GET['id']; ?> Permissions</h2>           
        <table class="table" border="0">
   <form class="form-horizontal" role="form" action="/scripts/updateUserGroup.php" method="post">

    <tbody>
      <tr>

        <td class="col-lg-7">
            <div class="form-group">
            <label class="col-lg-8 ">Permission Group:
            
            <select name="roles" class="form-control " type="text">
        <?php permGroupsToSelect($_GET['id']); ?>
        </select>
        </label>
        </div>
          
        </td>
        <td>
          <div>
          <center>
          <input type="hidden" name="id" value = "<?php echo $_GET['id']; ?>">
          <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="submit"  type="button" />
          </center>
          </div>
        </td>
    </tbody>
  </table>
  
  </form>
</div>
</div>

    
        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="../js/raphael.min.js"></script>
        <script src="../js/morris.min.js"></script>
                <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>
		
 

	</body>
        <?php } ?>
  <?php }  ?>
</html>