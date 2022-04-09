<?php
	// listnodes.php
	require_once"../includes/commands.php";
 
 
  $group = "";
 
  if($_POST)
  {
    var_dump($_POST); 
    $permArr = $_POST;
    $groupid = array_pop($permArr);
    var_dump($permArr);
    echo updatePermissionsArr($permArr, $groupid);

  }
 
  if(isset($_GET['group']))
  {
    $group = $_GET['group'];
   
  
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Add and Remove Roles</title>

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
 
    <?php      if (checkAPerm('permission_modify_perm_roles') != 1)
                    {
                      header( "refresh:0;url=/pages/index.php" );
                      echo checkAPerm('permission_modify_perm_roles');
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
                    <div class="col-lg-10">
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            
                            <?php if ( $group == "")
                            { ?>
                                <i class="fa fa-bar-chart-o fa-fw"></i> All Roles 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="dataTable_wrapper">
                                            <table id="modroles" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
													<th></th>
                                                    
                                                    <th>User Role</th>
                                                    
                                                  
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
													<th></th>
                                                  
                                                    <th>User Role</th>
                                                    
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
                        
                        
                        <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Add New Role
                                <div class="pull-right">
                                  
                                      
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                
                                   <div class="row">
                                    <div class="col-lg-12">
                                    
                                    
                                    
                                   
                                     <!-- Form Goes Here -->
                                     
                                     
                                     <form class="form-inline" role="form" name="addGroup" id="addGroup" method="post" action="../scripts/addGroup.php">
                                       <center>
                                               <div class="form-group">
                                                  <label >Group Name:</label>
                                                     
                                                      <input name="nGroup" class="form-control" type="text"required/>
                                                    <div class="col-sm-3">
                                                    </div>     
                                                </div>
                                               
                                              
                                                <div class="form-group">
                                                   <input class="btn btn-primary" type="submit" name="submit" value="submit"  type="button" />
                                                </div>                                            
                                           
                                       </center>
                                       </form>
                                              <div id="server-results"><!-- For server results --></div>
                                    </div>
                                
                                
                                </div>
                                
                                
                                
                            </div>
                            <!-- /.panel-body -->
                        
                        
                        </div>
                           
                    </div>
                        
                        
                     
                        
                        
                    </div>
                <?php } else {?>
                
                
                
                                                <i class="fa fa-bar-chart-o fa-fw"></i> Modify {groupname here} permissions
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                          {Checkbox array goes here with permissions and current permissions checked. Then save button will run a bulk update}
                                          <form action="/pages/modifypermroles.php" method="post">
                                           <?php permCheckboxArr($group);?>
                                          
                                          
                                           <input type="hidden" value="<?php echo $group; ?>" name="Group" />
                                          <input type="submit" value="Update">
                                          </form>
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
                        
                        
                        <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Add New Role
                                <div class="pull-right">
                                  
                                      
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                
                                   <div class="row">
                                    <div class="col-lg-12">
                                    
                                    
                                    
                                   
                                     <!-- Form Goes Here -->
                                     
                                     
                                     <form class="form-inline" role="form" name="addGroupPerm" id="addGroupPerm" method="post" action="../scripts/addGroupPermission.php">
                                       <center>
                                               <div class="form-group">
                                                  <label >Group Permission:</label>
                                                    
                                                      <input name="nGroup" class="form-control" type="text"required/>
                                                    <div class="col-sm-3">
                                                    </div>     
                                                </div>
                                               
                                              
                                                <div class="form-group">
                                                   <input class="btn btn-primary" type="submit" name="submit" value="submit"  type="button" />
                                                </div>                                            
                                           
                                       </center>
                                       </form>
                                              <div id="server-results"><!-- For server results --></div>
                                    </div>
                                
                                
                                </div>
                                
                                
                                
                            </div>
                            <!-- /.panel-body -->
                        
                        
                        </div>
                           
                    </div>
                        
                        
                     
                        
                        
                    </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?php } ?>
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

		<script src="../js/modroles.js"></script>
   
 
   
   
	</body>

  <?php }  ?>
</html>
