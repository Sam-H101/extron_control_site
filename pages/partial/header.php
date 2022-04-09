<?php require_once("../includes/sessions.php"); 
      require_once("../includes/permissions.php");?>

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Extron Recording</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

              <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE)
                             { ?>
                            
                <ul class="nav navbar-right navbar-top-links">
                   <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      
                      
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['name']; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
							
                          
                             <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            
                          
                            </li>
                        </ul>
                        
                         <?php 
                            }
                            else
                            {                             
                            ?>
                            <ul class="nav navbar-right navbar-top-links">
                               <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Login</a></li>
                            </ul> 
                            <?php } ?>
                    </li>
                </ul>
				       
				
				<!-- end of header -->
				
				
		
				
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">

			
                       


			                                          
                            <li>
                                <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            
                            
                            
                             <?php if(isset($_SESSION['isLoggedIn']))
                  
                       if ($_SESSION['isLoggedIn'] == TRUE)
                             { ?>
                            <?php if (checkPerm("permission_view_current_system")){ 
                            ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Overview<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="../phpsysinfo/index.php?disp=bootstrap">Current System</a>
                                    </li>
                              
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <?php } ?>
                      <?php if(checkPerm("permission_modify_recorders"))
                      {
                      ?>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> Node Systems<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">Add New Node</a>
                                    </li>
                                    <li>
                                        <a href="modifynode.php">Modify Node</a>
                                    </li>
                                
                                    <li>
                                        <a href="removenode.php">Delete Node</a>
                                    </li>
                                    <li>
                                        <a href="listnodes.php">List All Nodes</a>
                                    </li>
                                  </ul>
                                <!-- /.nav-second-level -->
                            </li>
							
							
                                 
                                 <?php } ?>
  <!--                   <li >            
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> Recording Information <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">Number Of Recordings</a>
                                    </li>
                                    <li>
                                        <a href="#">Recordings Per Node</a>
                                    </li>
                                    <li>
                                        <a href="#">Daily Reports</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
   <!--                          </li>
                            
							-->
							<?php 
                              if (checkPerm("permission_modify_admins")|| checkPerm("permission_modify_perm_groups") || checkPerm("permission_modify_perm_roles"))
                              {
                            
                            
                            ?>
                            <li>
                                <a href="#"><i class="fa fa-files-o fa-fw"></i> Administration<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                
                            <?php if (checkPerm("permission_modify_perm_groups"))
                            {
                            ?>  
                                  
                                    <li>
                                        <a href="/pages/modifyusers.php">Change User Roles</a>
                                    </li>

                                    <?php } ?>
                              
                              <?php if (checkPerm("permission_modify_perm_roles"))
                              {
                              
                              ?>                                    
                              
                                  
                                <li>
                              
                                
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Permission Systems<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                    <li>
                                        <a href="modifypermroles.php">Modify Permission Roles</a>
                                    </li>
                                         
				 </li>                                                                   
                               
                               
                           <?php } ?>
                           
                           
                           
                           
                                </ul>
                                <!-- /.nav-second-level -->
                           </li>
                           
                           
                           <?php } } ?>
                        </ul>
                    </div>
                </div>
            </nav>

