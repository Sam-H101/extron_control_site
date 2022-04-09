<?php
	// listnodes.php
	require_once"../includes/commands.php";
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
	
     	<?php include("partial/header.php");
    ?>
        <div id="wrapper">


		<div id="page-wrapper">
		 <!-- /.row -->
		 <br><br><br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> All Users 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="dataTable_wrapper">
                                            <table id="modusers" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
													<th></th>
                                                    
                                                    <th>User Role</th>
                                                    <th>User Name</th>
                                                  
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
													<th></th>
                                                  
                                                    <th>User Role</th>
                                                    <th>User Name</th>
                                                </tr>
                                                </tfoot>
												<tbody>
                                            </table>
                                        </div>
                                                <?php 

                                                            if(isset($_SESSION['groupError']))
                                                              {
                                                                if ($_SESSION['groupError'] != "")
                                                                {
                                                                  $alert = $_SESSION['groupError'];
                                                                  echo "<h4> $alert </h4>";
                                                                  $_SESSION['groupError'] = "";
                                                                  
                                                                }  
  
                                                               }

?>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.col-lg-4 (nested) -->
                                    <div class="col-lg-8">
                                        <div id="morris-bar-chart"></div>
                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                        
                    </div>
               
                    <!-- /.col-lg-4 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
		
		
		
		
		
        <!-- /#wrapper -->

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
		
        <script src="../js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

		<script src="../js/modusers.js"></script>
	</body>

  <?php }  ?>
</html>
