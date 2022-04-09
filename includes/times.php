<?php

	/*	Created By Sam Hudnall for the purpose of automating Extron SMP 351 AV Recorders
	*	Built on the SSH2 PHP Classes provided under General Use 
	*	The purpose and scope of this file is to parse Brian's Lecture Capture Scripts for the dates/ time/ and info needed to record
	*
	*	To Run - Requires php-cgi to be installed. ex. php-cgi times.php ip=161.115.189.240 room=SHWL232 days=75
	*
	*	To Run: GET CRONJOB REQUEST with ip, room, and days are required
	*   	Optional: topin and bottomin 
	*
	*/
	set_time_limit(0);
	date_default_timezone_set("America/New_York");
	require_once'commands.php';
	
	$GLOBALS['startRecording'] = true;
	$GLOBALS['stopRecording'] = false;
	
	
	$CRON_OFFSET = 15;
	
	
	// static for now, have sql database with roomloc that determines the ip.

	// get requests for running the script correctly.
	
	
	
	if (isset($_GET['ip']))
		$GLOBALS['addr'] = $_GET['ip'];
	else
		//die("need IP Address");
		$GLOBALS['addr'] = '161.115.1.1';
		
	if (isset($_GET['room']))
		$room = $_GET['room'];
	else 
		//die("need room location");
		$room = 'SHWL232';
	
	if (isset($_GET['days']))
		$days = $_GET['days'];
	else
		$days = 75;
	
	if (isset($_GET['topin']))
		$topInput = $_GET['topin'];
	else
		$topInput = '1';
	
	if (isset($_GET['bottomin']))
		$bottomInput = $_GET['bottomin'];
	else
		$bottomInput = '3';
		
	
	$link = 'http://apps.lynchburg.edu/campus/system/data/captureschedule/?room=' . $room . '&days=' . $days . '&format=raw';
	$file = new SplFileObject($link);

	// Loop until we reach the end of the file.
	while (!$file->eof()) {
		$time  = date('h:i:s A');
		$hour  = date('h');
		$min   = date('i');
		$sec   = date('s');
		$tday  = date('A');
		$day   = date('d');	
		$year  = date('y'); 
		$month = date('m');

		$data=array();
		 // get the next line in the file or in this case text page
		$data = $file->fgets();
       	if ($data[0] != '#')
    	{
    	
    		// explode the array to get the data in individual array colums
    		$data_array = explode('|', $data);	     	  	
    	  	// explode on space to get the date 
    		$date = explode(' ', $data_array[1]);
    		// the time is the 2nd part of the date
    		$time = $date[1];
    		
    		// get if am or pm
    		$ampm = explode(' ', $date[2]);
    		// get the actual time
     		$time = explode(':', $time);
     		
     		// get the actual date
    		$date = explode('/', $date[0]);
    		
    		// get all the start values from the exploded arrays
			$monthStart = $date [0];
			$dayStart   = $date [1];
			$yearStart  = $date [2];
			$hourStart  = $time [0];
			$minStart   = $time [1];
			$secStart   = $time [2]; 	
			$tdayStart  = $ampm [0];				
			
			// repeat for the stop arrays
			$date1 = explode(' ', $data_array[2]);
    		$time1 = $date1[1];
     		$time1 = explode(':', $time1);
     		$ampm1 = explode(' ', $date1[2]);
    		$date1 = explode('/', $date1[0]);
    		
			$monthStop = $date1 [0];
			$dayStop   = $date1 [1];
			$yearStop  = $date1 [2];
			$hourStop  = $time1 [0];
			$minStop   = $time1 [1];
			$secStop   = $time1 [2]; 	
			$tdayStop  = $ampm1 [0];

			
			
			
			// correct for the year 
			$yearToStart = '20' . (string)$year;
			$year = (int)$yearToStart;
			
			// if the year, month, and day are the same
			if (($yearStart == $year) && ($monthStart == $month) && ($dayStart == $day))
				{
					// echo "same year, month, and day";
					// cronjob offset incase it only runs this X minutes.
					

					// if the hours are the same and minutes are 5 min early and its the correct am or pm.
					if (($hour == $hourStart) && ($min - 30 <= $minStart) && ($tday == $tdayStart))
					{
						// if the hour and minutes are the same
						// send start command
						$course = $data_array[0];
    	  				$instructor = $data_array[5];
						
						// starting the command to start recording
						//echo "starting";
						startRec($GLOBALS['addr']);
					}
					
					// set to stop and allow for cornjob of 15 min delay.
					else if (($hour == $hourStop) && (($min >= $minStop) && $min - $minStop < $CRON_OFFSET) && ($tday == $tdayStop))
					{
						// send stop command
						//echo "stopping";
						stopRec($GLOBALS['addr']);
					}
				}
				 
    	} 	
	}


	
	$file = null;
	//echo '<br/>';

?>