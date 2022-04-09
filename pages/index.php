<?php
    header('X-Frame-Options: GOFORIT'); 
?>

<?php 

require_once"../includes/commands.php";
require_once"../includes/charts.php";
require_once"../includes/dbinfo.php";
require_once"../includes/sessions.php";
require_once"../includes/permissions.php";
require_once"../includes/ldapFunctions.php";




if (isset($_GET['cal_id']))
{
  $cal_id = $_GET['cal_id'];
}
else
{ $cal_id = "1";}




?>






<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Extron Control Panel </title>

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
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                       
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo countRecordings(); ?></div>
                                        <div>Recordings Today!</div>
                                    </div>
                                </div>
                            </div>
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE && checkPerm('extron_view_logs'))
                             { ?>
                            
                            <a href="countlogs.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                       
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo returnLogCount(1); ?></div>
                                        <div>Logs Today!</div>
                                    </div>
                                </div>
                            </div>
                            
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE && checkPerm('extron_view_logs'))
                             { ?>
                            
                            <a href="listlogs.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                       
                                    </div>
                                    <div class="col-xs-9 text-right">
                                       <div class="huge"><?php echo returnCritCount(); ?></div>
                                        <div>Critical Logs Today!</div>
                                    </div>
                                </div>
                            </div>
                            
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE && checkPerm('permission_view_errors'))
                             { ?>
                            
                            <a href="listcritlogs.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                    
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo countAvalUpdates();?></div>
                                        <div>Updates Avaliable!</div>
                                    </div>
                                </div>
                            </div>
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE)
                             { ?>
                            
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            
                            <?php } ?>
                        </div>
                    </div>
                </div>
				
				<!-- Enod Of Top Buttons -->
            <h4> Development has been haulted until further notice </h4>
				
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Recordings Per Day
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                                data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="index.php?chartDays=7">7 Days</a>
                                            </li>
                                            <li><a href="index.php?chartDays=14">14 Days</a>
                                            </li>
                                            <li><a href="index.php?chartDays =30">30 Days</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                             
                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="col-lg-4">
                        
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Extron Control
                            </div>
                            <div class="panel-body">
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE)
                             { ?>
                            
                                <h4> Warning Buttons are Active </h4>
                                
                             <?php   } ?>
                         <!---       <form action="../scripts/recording.php" method="post" role="form" name="stream" id="stream"> -->
                                 <?php if (checkLogin() == TRUE) { ?>
                                <div class="form-group">
                                                <label>Select Extron</label>
                                               
                                                <select class="form-control" name="node" id="node">
                                                    <?php nodesToHTMLSelect(); ?>
                                                </select>
                                            
                                                
                                            </div>
                                <div class="form-group">
                                      <input class="btn btn-success submitbutton" type="submit" name="start_button" id="start_button" value="Start Recording" />
                                      <input class="btn btn-danger submitbutton" type="submit" name="stop_button" id="stop_button" value="Stop Recording" />
                                
                                </div>
                                <div class="form-group">
                                      <input class="btn btn-success submitbutton" type="submit" name="Start_Stream" id="start_stream" value="Start Live Stream" />
                                      <input class="btn btn-danger submitbutton" type="submit" name="Stop_Stream" id="stop_stream" value="Stop Live Stream" />
                                </div>
                                    <?php } ?>
                          <!--      </form> -->
                          
                            </div>
                            <!-- /.panel-body -->
                            
                        </div>
                        <!-- /.panel -->
                          <!-- /.row -->
                          </div>
                 <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE)
                             { ?>
                <div class="col-lg-8">
              
                            
                <div class="panel panel-default">
                
                            
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Google Calander
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                                data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu" id="calander_Dropdown">
                                         <?php nodesToSelectCalander(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                          
                            <?php // extron google calender showing ?>
                            <!-- /.panel-heading -->
                            <center>
                            <div class="panel-body">
                                <div class="row">
                                    <?php  if ($_SESSION['isLoggedIn'] == true) { ?>
                               
                               
                               
                               <iframe id="cal_iframe" src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=lynchburg.edu_k0aa81td4eqp65j6u83ll64uqg%40group.calendar.google.com&amp;color=%238D6F47&amp;ctz=America%2FNew_York" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                               
                               
                               
                                        <!-- /.table-responsive -->
                                    <?php } ?>
                                   </div>
                                <!-- /.row -->
                            </div>
                            </center>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                        
                        <?php } ?>
                            
                
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
              
            </div>
            
            <!-- /#page-wrapper -->

        </div>
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
		<script>
		<?php if (isset($_GET['chartDays']))
		{
			$DAYS = $_GET['chartDays'];
		}
   
		else
			$DAYS = 7;
		?>
		Morris.Area({
        element: 'morris-area-chart',
		data: JSON.parse('<?php echo formatChart($DAYS); ?>'),
		xkey: 'Date',
        ykeys: ['Count'],
        labels: ['Number Of Recordings', 'Count'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
		
		
		
		
		
		</script>

   <script>
 $('.clickMe').click(function() {
     var value = $(this).val();

     $.ajax({
         url: 'calander.php',
         type: 'post',
         data: 'cal_id=' + value,
         success: function(html) {
             $('#cal_iframe').attr('src', html);
         }
     });
 });
      




        // on form submit do add and redraw
        // on form submit do add and redraw
        
        	</script>

   <script>
    $('.clickMe').click(function(){
        var value = $(this).val();
        });
        
   $('.submitbutton').click(function() { 
   buttonpressed = $(this).attr('name');

      var node = document.getElementById("node");
      var nodeVal = node.options[node.selectedIndex].value;

    $.ajax({
             url: '/scripts/recording.php',                 
             method : 'POST',
            
             async: false,
             data: {buttonpressed :  (buttonpressed || '' ), nodeVal: (nodeVal || '') },
              // serializes the form's elements.
            success : function(data) {
              alert(data);
            },
               error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        alert(msg);
                    },    
        });
   });
   
//});
   

function message(quantity){
alert(quantity);
}

   </script>

    </body>
</html>
