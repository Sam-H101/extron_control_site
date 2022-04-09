<?php
	// Created by Sam Hudnall 
	// as a command list file for EXTRON SMP 351 RECORDERS
	// this will have the commands and take the proper arguments for each to work.
	
	// TODO: 
	//
	date_default_timezone_set('America/New_York');
	$date_command = date('m/d/Y h:i:s a', time());
	require_once'Net/SSH2.php';
	require_once'dbinfo.php';
	require_once'updates.php';
	require_once'charts.php';
  require_once'sessions.php';
  require_once'permissions.php';
	// add this to a seperate php file
	$GLOBALS['class'] = '';
 
 



    set_include_path(__DIR__ . '/' . PATH_SEPARATOR . get_include_path());

	// dates
	$dtime = date('y-m-d h:i:s A', strtotime('+4 hours'));
	$d     = date('y-m-d');
   
 
    // system commands
  $startRecording = 'wY1RCDR|';
	$stopRecording  = 'wY0RCDR|';
	$topInput       = '1*1!';
	$bottomInput    = '3*2!';
 
  $password = "";
 
 
 
  $StartRTMPStream = 'WE3*1RTMP|';
  $StopRTMPStream  = 'WE3*0RTMP|';
 
 
	$GLOBALS['room'] = 'ROOMUNKNOWN';

	$name = "w$room"."CN" . '|';
	$cnum = $GLOBALS['class'];
		
	$title 		= "$room" ."_$dtime";
	$course 	= "$room" ."_$cnum";
	$format 	= "m4v";
	$creator	= "system";
	$Lang 		= "en";
	$subj 		= "Class Reading";
	
	// creator
 
 
	$metadata[0]="wM2*$creator" ."RCDR|";
		
	// date
	$metadata[1]="wM3*$d"."RCDR|";
	
	// format
	$metadata[2]="wM5*$format"."RCDR|";
	
	// lang
	$metadata[3]="wM7*$Lang"."RCDR|";
	
	// subj
	$metadata[4]= "wM12*$subj"."RCDR|";
	
	// title
	//$metadata[5]= "wM14*$title"."RCDR|";
	
	// global variables becuase who does not like the ability to send something globally
	// ***Outdated method kept for reference use Global $variablename now
 
  $GLOBALS['name']    = $name;
	$GLOBALS['meta']    = $metadata;
	$GLOBALS['TI']      = $topInput;
	$GLOBALS['BI']      = $bottomInput;
	$GLOBALS['Srec']    = $startRecording;
	$GLOBALS['Stoprec'] = $stopRecording;

  
###################################################################################################
############################           API FUNCTIONS BEGIN          ###############################
###################################################################################################
#	function connect();
#	function findByIP($ip);
#	function returnError($c);
# function returnPass($ip);
# function returnLocation($ip);
# function returnAllNodes();
# function nodesToHTMLSelect();
# function nodesToSelectCalander();
# function checkCalanderPerms();
# function returnPanelUsername($ip);
# function returnPanelPassword($ip);
# function getPorts($ip);

 	function connect()
 	{
 		global $host; global $user; global $pass;
 		$conn = new mysqli($host,$user,$pass);
 		return $conn;	
 	}
	
	function returnError($c)
	{
		$error = "";
		if($c -> connect_error)
			{
				$error = $c->connect_error;
			}
			
		if($c -> error)
			{
				LogError("SQL ERROR: " . $c->error);
				$error = $c->error;
			}
		return $error;
	} 
 
 	function returnAllNodes()
  {
    global $db;
    $conn = connect();
    $sql = "SELECT * from `$db`.`extron_panels`;";
    $result = $conn->query($sql);
    if ($result != TRUE)
    {
      echo returnError($conn);
      $conn->close();
    }
    else
    {
      $conn ->close();
      return $result;
    }
  }
  function returnNode($ip)
  {
    $res1 = returnAllNodes();
    
    $location = "";
    while($res = $res1 -> fetch_assoc())
    {
      
      if ($res['ipaddr'] == $ip) {
      
        return $res;
        //$location = $res['location'];
          
      }
    }
    return $location;


  }
  
  function getPorts($ip)
  {
    global $db;
    $node = returnNode($ip);
    
    $id = $node['id_panels'];
    
    
    $conn = connect();
    $sql = "SELECT * from `$db`.`extron_panelSettings` WHERE id = $id;";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
  }
  
  
  function returnLocation($ip)
  
  {
    $node = returnNode($ip);
    $location = $node['location'];
    return $location;
  }
  
  
  function returnPanelUsername($ip)
  {
    $node = returnNode($ip);
    $user = $node['telnetuser'];
    return $user;
  
  }
  
  function returnPanelPassword($ip)
  {
    $node = returnNode($ip);
    $pass = $node['telnetpass'];
    return $pass;
  
  
  }
    
  function nodesToHTMLSelect()
  {
    $res1 = returnAllNodes();
    
    while($res = $res1 -> fetch_assoc())
    {
      $option = $res['id_panels'];
      $view   = $res['ipaddr'];
      $view2  = $res['commonname'];
      $build  = $res['BUILDING'];
      
      // update as needed for building locations
      if (checkPerm('permission_control_all_extron') == 1){
            echo "<option value=" . '"' . $option .'"' . ">$view - $view2 </option>";
            
      }
      else if ($build == "DPT")
      {
          if (checkPerm('permission_control_dpt_extron') == 1)
            echo "<option value=" . '"' . $option .'"' . ">$view - $view2 </option>";
      
      }
      else if ($build == "PA")
      {
          if (checkPerm('permission_control_pa_extron') == 1)
            echo "<option value=" . '"' . $option .'"' . ">$view - $view2 </option>";
      }
      else if ($build == "SHWL")
      {
          if (checkPerm('permission_control_SHWL_extron') == 1)
            echo "<option value=" . '"' . $option .'"' . ">$view - $view2 </option>";
      }
      else if ($build == "HALL")
      {
          if (checkPerm('permission_control_BALLROOM_extron') == 1)
          {
             echo "<option value=" . '"' . $option .'"' . ">$view - $view2 </option>";
          }
      }
      
    }
  }
  function checkAPerm($perm)
  {
    return checkPerm($perm);
  
  }
  
  
  function checkCalanderPerms($build, $eres)
  {
        if ($build == "DPT")
      {
          if (checkPerm('permission_control_dpt_extron') == 1){
          
            
            return true;
            }else{
            return false;}
      
      }
      else if ($build == "PA")
      {
          if (checkPerm('permission_control_pa_extron') == 1){
          
            return true;
            }else{
            return false;}
      }
      else if ($build == "SHWL")
      {
          if (checkPerm('permission_control_SHWL_extron') == 1){
           
            return true;
            }else{
            return false;}
      }
      else if ($build == "HALL")
      {
          if (checkPerm('permission_control_BALLROOM_extron') == 1){
           
            return true;
            }else{
            return false;}
      }
      
      else 
      {
        if (checkPerm('permission_control_all_extron') == 1){
        
        return true;
        }else{
        return false; }
      
      }
      
    
       
    }

  function nodesToSelectCalander()
  {
     $res = returnAllNodes();
     
     $nodeArr = array();
     while($result = $res->fetch_assoc()) 
     {
         $calander = $result['id_panels'];
         $location = $result['commonname'];
         
         
         //$nodeArr = array("calander" => $calander, "location" => $location);
         
        //echo "<li><a href=" . '"' . "index.php?cal_id=$calander". '"' . ">$location</a></li>";
         echo "<li class='clickMe' id='cal_$calander' value='$calander'><a >$location</a></li>";
         
     }   
  }
  
  function findbyID($id)
  {
  	global $db;
 		$conn = connect();
 		if (!returnError($conn))
 			{
 			
 				$sql = "select `ipaddr` from `$db`.`extron_panels` where id_panels = $id ;";				
 				$result = $conn->query($sql);
 				if ($result == TRUE)
 				{
 					if ($result->num_rows > 0)
             {  
               $res = $result->fetch_assoc();
               return $res['ipaddr'];
             }		
 				}
 				else
 				{
 					echo returnError($conn);
 					$conn->close();
 				}
 			}
  }
  
 	function findByIP($ip)
 	{
 		global $db;
 		$conn = connect();
 		if (!returnError($conn))
 			{
 				$ip = (string)$ip;
 				$sql = "select * from `$db`.`extron_panels` where ipaddr = '$ip' ;";				
 				$result = $conn->query($sql);
 				if ($result == TRUE)
 				{
 					if ($result->num_rows > 0){ $conn->close(); return $result;} else { return false; }
 					
 				}
 				else
 				{
 					echo returnError($conn);
 					$conn->close();
 				}
 			}
 	}

  function updateNode( $ip, $loc, $Building, $u, $p , $in1, $in2, $oldip)
  {
   
    global $db;
    $conn = connect();
   	if (!returnError($conn))
 			{
      // verify we have a string here
      
        $passUpdate = setPassword($p, $oldip);
        
        if (!($passUpdate == true))
        {
          return false;
        }
      
      $sql = "UPDATE  `$db`.`extron_panels` SET `ipaddr`=?,`location`=?,`BUILDING`=?,`telnetpass`=?,`telnetuser`=? WHERE `ipaddr` LIKE ? ";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssss", $ip, $loc, $Building, $p, $u, $oldip);
      
      $stmt->execute();
      $stmt->close();
      
      
      
      $node = returnNode($ip);
      $id = $node['id_panels'];
      
      
      $sql = "UPDATE  `$db`.`extron_panelSettings` SET `topPort`= $in1,`bottomPort`= $in2 WHERE `id` = $id";
      
      
      $result = $conn->query($sql);
      if ($result == true)
      {
        
        echo "Successful Update";
        return "Success";
      
      }
      else return "failed";
      
      }
  }

  function checkNodeExist($ip)
  {
    $found = findByIP($ip);
    if ($found == false ) return false;
    else return true;
  
  }
	function findInputs($ip)
	{
		global $db;
		$conn = connect();
		$id = returnID($ip);
		$sql = "Select * from `$db`.extron_panelSettings;";
		$result = $conn->query($sql);
		if ($result == true)
		{
			if ($result->num_rows > 0) {$conn->close(); return $result;}
		}
		else
		{
			echo returnError($conn);
			$conn->close();
		}
		
	}

	function returnInputs($ip)
	{
		$res = findInputs($ip);
		$in = $res->fetch_assoc();
		$ret['top'] = $in['topPort'];
		$ret['bottom'] = $in['bottomPort'];
		return $ret;
	}
 
 	function returnPass($ip)
 	{
 		$res = findByIP($ip);
 		$in = $res->fetch_assoc();
 		return $in['telnetpass'];
 	}
	
	function returnID($ip)
	{
		$res = findByIP($ip);
		$in = $res->fetch_assoc();
		return $in['id_panels'];
	}
 
 	// dont know if useful yet tho will see as time comes around
  	function setInputsForIP($ip)
  	{
  		$inputs = returnInputs($ip);
  		
  		selectInput($inputs['top']);
  		selectInput($inputs['bottom']);
  	
  	
  	}
 	#################################
 	#### RECORDING LOG FUNCTIONS ####
 	################################# 
 	
  function ReturnLogCountLogs()
  {
  
    global $db;
    $conn = connect();
    $sql = "SELECT `id`, `ipaddr`, `recCount`, `timestamp` FROM `$db`.`extron_numRecordings` JOIN  `$db`.`extron_panels` where`id_panels` = `id`;";
    $result =$conn->query($sql);
    if ($result == TRUE)
    {
      // process the data here and encode  
        $rows = array();
        if ($result ->num_rows == 0)
        {
          return'';
          
        }
        while ($res = $result->fetch_assoc())
        {
            $rows[] = $res;
        }
        $conn->close();
        $json = json_encode($rows);
        return $json;
    } 
    else
    {
      echo $conn->error;
    }
  }
 
  function ReturnLogs()
  {
  
    global $db;
    $conn = connect();
    $sql = "SELECT `logid`, `Date`, `log_desc` from `$db`.`extorn_log` WHERE `log_crit` = 0;";
    $result =$conn->query($sql);
    if ($result == TRUE)
    {
      // process the data here and encode  
        $rows = array();
        while ($res = $result->fetch_assoc()){
          $rows[] = $res;     
        }
        $conn->close();
        $json = json_encode($rows);
        return $json;
    } 
    else
    {
      echo $conn->error; 
    }
  }
  
 function ReturnCritLogs()
 {
 
   
    global $db;
    $conn = connect();
    $sql = "SELECT `logid`, `Date`, `log_desc` from `$db`.`extorn_log` WHERE `log_crit` = 1;";
    $result =$conn->query($sql);
    if ($result == TRUE)
    {
      // process the data here and encode  
        $rows = array();
        while ($res = $result->fetch_assoc()){
          $rows[] = $res;     
        }
        $conn->close();
        $json = json_encode($rows);
        return $json;
    } 
    else
    {
      echo $conn->error; 
    }
  }

 	function LogCommand($log)
 	{
 		global $db;
 		$conn = connect();
 		$sql = "INSERT INTO `$db`.`extorn_log` (`logid`, `Date`, `log_desc`,`log_supr`,`log_crit`) VALUES ('', CURRENT_TIMESTAMP, " . '"' . $log . '"' .", 0 , 0);";
 		$result = $conn->query($sql);
 				if ($result == true)
		{
   
	  	$conn->close(); return $result;
		}
		else
		{
			echo returnError($conn);
			$conn->close();
		}
 	}
 
  	function LogError($log)
 	{
 		global $db;
 		$conn = connect();
    echo $log;
    echo "<br> <br> <br>";
 		$sql = "INSERT INTO `$db`.`extorn_log` (`logid`, `Date`, `log_desc`,`log_supr`,`log_crit`) VALUES ('', CURRENT_TIMESTAMP, " . '"' . $log . '"' .", 0 , 1);";

 		$result = $conn->query($sql);
    if($result == true)
		{
	  	$conn->close(); return $result;
		}
		else
		{
			echo returnError($conn);
			$conn->close();
		}
 	}

 	function returnCritCount()
 	{
 		global $db;
 		$conn = connect();
 		$sql = "SELECT COUNT(*) as cnt from `$db`.`extorn_log` where `Date` > CURDATE() and `log_crit` = 1;";
		$result = $conn->query($sql);
 		if ($result == true)
 		{	
 			$res = $result->fetch_assoc();
 			$res = $res['cnt'];
 			$conn->close();
 			return $res;
 		}
 		else
 		{
 			return returnError($conn);
 		}

 	}
 
 	function returnLogCount($days)
 	{
 		global $db;
 		$conn = connect();
 		$sql = "SELECT COUNT(*) as cnt from `$db`.`extorn_log` where `Date` > CURDATE();";
 		$result = $conn->query($sql);
 		if ($result == true)
 		{	
 			$res = $result->fetch_assoc();
 			$res = $res['cnt'];
 			$conn->close();
 			return $res;
 		}
 		else
 		{
 			return returnError($conn);
 		}
 	}
 	function supressLog($logid)
	{
		$conn = connect();
		$sql = "UPDATE `$db`.`extorn_log` SET log_supr = 1 WHERE logid = $logid;";
		$res = $conn->query($sql);
		if ($res == TRUE)
		{
			return 1;
		}
		else
		{
			return returnError($conn);
		}
	}
 	function returnUnsupressedLogs()
 	{
		global $db;
		$conn = connect();
		$sql = "SELECT * FROM `$db`.`extorn_log` where log_supr = 0;";
		$res = $conn->query($sql);
		if ($res == true)
		{	
			$i = 0;
			$Retresult = array();
			while ($result = $res ->fetch_assoc())
			{
				
				$Retresult[$i] = $result;
				$i = $i + 1;
			}
			$conn->close();
			return $Retresult;
		}
		else
		{
			echo returnError($conn);
			$conn->close();
		}
 	
 	}

 
 	function returnCriticalLogs()
 	{
    return returnCritLogs();
 	}
 	
 	function cronDailyResetCount($ip)
 	{
 		global $db;
 		$conn = connect();
 		$id = returnID($ip);
 		$sql = "Select * from `$db`.`extron_numRecordings` where id = $id;";
 		$res = $conn ->query($sql);
 		
 		
 		$result = $res ->fetch_assoc();
 		if ($result == NULL)
 		{
 				return 0;
 		}
 		else if (date('Y-m-d') > $result['timestamp'])
 		{
	 		updateChartTable($ip, $result['recCount']);

 			truncateRecordingCount($ip);
		}
 	 
 	}
 	
 	
 	function resetAllRecLogs()
 	{
 		global $db;
 		$conn = connect();
 		$sql = "select `ipaddr` from `$db`.`extron_panels`;";
 		$res = $conn->query($sql);
 		while ($result = $res->fetch_assoc())
 		{
 			cronDailyResetCount($result['ipaddr']);
 		}
 		$conn->close();
 	
 	}
 	
 	function updateRecordingCount($ip)
 	{
 		global $db;
		// normal y-m-d date 	
		global $d;
	
 		$conn = connect();
 		$id = returnID($ip);
 		$sql = "Select * from `$db`.`extron_numRecordings` where id = $id;";
 		$res = $conn ->query($sql);
 		
 		
 		$result = $res ->fetch_assoc();
 		if (date('Y-m-d') > $result['timestamp'])
 		{
	 		updateChartTable($ip, $result['recCount']);

 			truncateRecordingCount($ip);
 			
			$sql = "INSERT into `$db`.`extron_numRecordings` (`id`, `recCount`, `timestamp`) VALUES ( $id, 1,  CURRENT_TIMESTAMP());";
			if (!$conn ->query($sql))
				echo returnError($conn);
 		}
 		else
 		{
 		
			$count = $result['recCount'];
      echo $count . ' ' ;
			$count = $count +1;
      echo $count;
			$sql1 = " UPDATE `$db`.`extron_numRecordings` set `recCount` = $count, `timestamp` =  CURRENT_TIMESTAMP() where `id` = $id;";
		
			if(!$conn->query($sql1))
        returnError($conn);
   
      
      
		}		
		$conn->close();
		
 	}
 	
 	function countRecordings()
 	{
 		global $db;
 		global $host; global $user; global $pass;
 		$conn = new mysqli($host,$user,$pass);
 		$sql = "Select SUM(`recCount`) as cnt from `$db`.`extron_numRecordings` where `timestamp` >= CURDATE();";
 		$res = $conn ->query($sql);
 		$result = $res ->fetch_assoc();
		$conn->close();
		if ($result['cnt'] != NULL)
			return $result['cnt'];
		else return 0;
 	
 	}
 	
 	function truncateRecordingCount($ip)
 	{
 		global $db;
 		$conn = connect();
 		$id = returnID($ip);
 		$sql = "DELETE FROM `$db`.`extron_numRecordings` where `id` = $id;";
 		if (!$conn->query($sql))
 			echo returnError($conn);
 		$conn->close();
 	}
 	
 	
 	
 	#################################
 	#### END RECORDING FUNCTIONS ####
 	################################# 

###################################################################################################
############################         EXTRON FUNCTIONS BEGIN         ###############################
###################################################################################################

  function setPassword($password, $addr)
  {
    if(strlen($password) > 12)
    {
      return false;
    }
    else 
    {
      if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))
      {
        return false;
      }
      
      
      else
      {
      // we are good to reset if we are here
        $password = 'w'. $password . 'CA|';
        logCommand($addr . " Settings Updated");
        sendCommand($password, 1, $addr);
      
        return true;
      
      
      
      
      }
    }
  
  }


 	function selectInput($input)
 	{
 		switch($input){
 			case 1:
 				$GLOBALS['TI'] = '1*1!';
 				break;
 			case 2:
 				$GLOBALS['TI'] = '2*1!';
 				break;
 			case 3:
 				$GLOBALS['BI'] = '3*2!';
 				break;
 			case 4:
 				$GLOBALS['BI'] = '4*2!';
 				break;

 		
 		}
 		$return = array();
 		$return['TOP'] = $GLOBALS['TI'];
 		$return['BOTTOM'] = $GLOBALS['BI'];
 		
		return $return; 
 	
 	}

	
	
	function sendCommand1($Command, $size, $addr, $port, $user, $pass)
  	{
		$ssh = new Net_SSH2($addr, $port);
   $failed = 0;
		if (!$ssh->login($user, $pass))
		{
    	  	$failed = 1;
 		}
    else if ($failed == 1)
    {
      return "Login Failed For " . $addr . " using user " . $user;
    }
   		else
    	{
         $commands = "";
    		if ($size > 1)
    		{
    			for ($i = 0 ; $i < $size ; $i++)
    			{	
    				$ssh->exec($Command[$i]);
    				sleep(.5);
    				//echo $ssh->read('');
    				//echo "<br/>";
            $commands = $commands . " , ". $Command[$i];
    			}
				    			
				return "Executed " . $commands;					
			}
			else
   				 $ssh->exec($Command);
   				//echo $ssh->read('');
   				//echo "<br/>";
   				return "Executed Command On " . $addr;
    	}


	}

	function sendCommand($command, $size, $addr)
	{
		
		$pass = returnPass($addr);
    $pass = str_replace(' ','',$pass);
    $addr = str_replace(' ','',$addr);
		logCommand(sendCommand1($command, $size, $addr ,'22023', 'admin', $pass)); 
	
	}

	function meta($addr)
	{
		$metaSize = 5;
		$metadata = $GLOBALS['meta'];
		sendCommand($metadata, $metaSize, $addr);
	}
	
  
  function CheckRTMP($add)
  {
    global $db;
 		$conn = connect();
 		$sql = "SELECT count(*) as `RTMP` FROM `$db`.`extron_panels` JOIN `$db`.`extron_panelSettings` where `id_panels` = `id` AND `ipaddr`= '$add' AND `RTMP_STREAM` = 1";
 		$res = $conn ->query($sql);
 		$result = $res ->fetch_assoc();
		$conn->close();
		if ($result['RTMP'] == 1) {return true;}else {return false;}

  }
  
  
   
  function startRTMPrec($addr)
  {
    if (CheckRTMP($addr) == TRUE)
    {
        global  $StartRTMPStream;
        sendCommand($StartRTMPStream, 1, $addr);
        LogCommand("$addr started RTMP Stream");
        return ;
    }
      LogCommand("$addr: NO RTMP Stream setup");

  }
		
  function stopRTMPrec($addr)
  {
    if (CheckRTMP($addr) == TRUE)
    {
        global  $StopRTMPStream;
        sendCommand($StopRTMPStream, 1, $addr);
         LogCommand("$addr stopped RTMP Stream");
         return;
    }
      LogCommand("$addr: NO RTMP Stream setup");
  
  }
	function startRec($addr)
	{
		global $date_command;
   
    $inputs = setInputsForIP($addr);
    $topInput = $inputs['TI'];
    $bottomInput = $inputs['BI'];
    
		$startRecording = $GLOBALS['Srec'];
		$name           = $GLOBALS['name'];
		meta($addr);
		sleep(1);
		$values[0] = $name;
		$values[1] = $topInput;
		$values[2] = $bottomInput;
		$values[3] = $startRecording;
		
		sendCommand($values, 4 , $addr);
		LogCommand("Started Recording '$addr' dateon '$date_command'");
		updateRecordingCount($addr);
    setRec($addr, 1);
	}
	
	
	function stopRec($addr)
	{
		global $date_command;
		$stopRecording = $GLOBALS['Stoprec'];
		sendCommand($stopRecording, 1, $addr);
		LogCommand("Stopped Recording '$addr' on '$date_command'");
    setRec($addr, 0);
	}
	
 
 
function isRecording($ip)
{
  global $db;
  $conn = connect();

  $sql = "SELECT `isRec` from `$db`.`extron_panels` where ipaddr = '$ip';";
  $res = $conn->query($sql);
  if ($res == TRUE)
  {
    $results = $res->fetch_assoc();
    return $results['isRec'];
  }
  else
  echo $conn->error;

}

function setRec($ip, $status)
{
  global $db;
  $conn = connect();

  $sql = "UPDATE `$db`.`extron_panels` SET `isRec` = '$status' WHERE ipaddr = '$ip';";
  if(!$conn->query($sql))
    {
      // return error code here
      return $conn->error;
      
    }
  else
    return true;

}

 
 
	function setroom($room)
	{
		$GLOBALS['room'] = $room;
	}

	
	function setClass($class)
	{
		$GLOBALS['class'] = $class;
	
	}


  function selectCalanderId($id)
  {
    global $db;
    $conn = connect();
    $sql = "SELECT `cal_id` FROM `$db`.`extron_calendars` WHERE `ex_id` = $id;";
    if ($query = $conn->query($sql))
    {
      $results = $query->fetch_assoc();
      return $results['cal_id'];
    }
    else
      echo returnError($conn);

  }




?>