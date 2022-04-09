<?php
	// listnodes.php
	require_once"../includes/commands.php";
	require_once"../includes/nodes.php";
  require_once"../includes/permissions.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Startmin - Bootstrap Admin Theme</title>

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
    <body>

        <div id="wrapper">

		<?php include("partial/header.php"); ?>
		<div id="page-wrapper">
		 <!-- /.row -->
		 <br><br><br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- /.panel -->
                        
                        <?php 
                        // get request for the ip you want to delete, if found do something else
                        if(!isset($_GET['ip'])){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> All Extron Recorders 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="dataTable_wrapper">
                                            <table id="removeRecorders" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
													<th></th>
                                                    
                                                    <th>Panel IP</th>
                                                    <th>Panel Location</th>
                                                    <th>Panel Common Name</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
													<th></th>
                                                  
                                                    <th>Panel IP</th>
                                                    <th>Panel Location</th>
                                                    <th>Panel Common Name</th>
                                                </tr>
                                                </tfoot>
												<tbody>
                                            </table>
                                        </div>
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
                        <?php 
                        // end if there is a get ip request
                        }
                        else
                        { 
                          if (checkPerm('permission_delete_Node')){
                        	  echo deleteNode($_GET['ip']);
                        	}
                          else
                          {
                            echo "You Do not have permission to preform requested action.";
                          }
                        ?>
                        
                        
                        
                        <?php } ?>
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

		<script src="../js/removenodes.js"></script>
	</body>
</html>