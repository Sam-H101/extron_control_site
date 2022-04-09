
<?php

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}
date_default_timezone_set('America/New_York'); 


$TIME_OFFSET_FOR_CRON = 2;


require_once __DIR__ . '/vendor/autoload.php';
require_once 'includes/commands.php';
require_once 'includes/dbinfo.php';

date_default_timezone_set('America/New_York');
define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR_READONLY)
));

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
 

function getClient($ip) {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH, $ip);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path, $ip) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}


//echo runCommands();
function retifSameDate($date, $ip)
{
  // Get the API client and construct the service object.
  
  $client = getClient($ip);
  
  $service = new Google_Service_Calendar($client);

  // Print the next event on the user's calendar.

  // need to setup calanders based upon different ips of machines and then call a function to get those and pipe to here

  $id = returnID($ip);

  $calendarId = selectCalanderId($id);
  $optParams = array(
    'maxResults' => 1,
    'orderBy' => 'startTime',
    'singleEvents' => TRUE,
    'timeMin' => date('c', strtotime("-3 minutes", strtotime(date('c')))),

);


  $results = $service->events->listEvents($calendarId, $optParams);

  if (count($results->getItems()) == 0) {
    print "No upcoming events found.\n"; return 0;
  } else {
      foreach ($results->getItems() as $event) {
        $start = $event->start->dateTime;
        $time = explode('T' , $start);
        if (empty($start)) {
          $start = $event->start->date;
        }
     // echo $start;
      //echo $date;
	    if ($date== $time[0])
  	  {
	    	return 1;
	    }
	    else 
		    return 0;
	    }
  }
}

function retifSimilarTime($time1, $time2)
{
  if ($time1 == $time2)
    return 1;
  else 
    return 0;
  
  
}






function runCommands($ip)
{
global $TIME_OFFSET_FOR_CRON;

// Get the API client and construct the service object.
$client = getClient($ip);
$service = new Google_Service_Calendar($client);

// Print the next event on the user's calendar.

// need to setup calanders based upon different ips of machines and then call a function to get those and pipe to here
  $id = returnID($ip);
  
  $calendarId = selectCalanderId($id);
  $optParams = array(
  'maxResults' => 1,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),

);
  $results = $service->events->listEvents($calendarId, $optParams);

  if (count($results->getItems()) == 0) {
    
    return 0;
  } else {
      foreach ($results->getItems() as $event) {
        $start = $event->start->dateTime;
        $time = explode('T' , $start);
        $time2 = explode('-', $time[1]);
        $end = $event->end->dateTime;
        $etime = explode('T' , $end);
        $etime2 = explode('-', $etime[1]);
        if (empty($start)) {
          $start = $event->start->date;
        }
  }
}
  
  $isDate = retifSameDate(date('Y-m-d'), $ip);
  $timeStart = date("H:i:s", strtotime("-$TIME_OFFSET_FOR_CRON minutes", strtotime($time2[0])));
  $timeEnd   = date("H:i:s", strtotime("-$TIME_OFFSET_FOR_CRON  minutes", strtotime($etime2[0])));

  $currentTime = date('H:i:s');
  $startEndCheck = $TIME_OFFSET_FOR_CRON ;
  echo date("H:i:s", strtotime($timeStart." +$startEndCheck minutes"));
  // if we are the correct day
  if ($isDate == 1)
  {
    echo "we will be recording today:";
    // if the current time is within the 5 min margin
     $r1 = isRecording($ip);
    $timetest = date("H:i:s", strtotime($timeStart." +$startEndCheck minutes"));
    echo "Current time, $currentTime ... start time, $timeStart /n";
    echo "last time to start is, $timetest";
    echo "time end, ...... $timeEnd";
    echo "is recording? ... $r1";
    
    echo "time.... $currentTime >= $timeEnd";

    if (($currentTime >= $timeStart) && isRecording($ip) == 0  && !($currentTime > date("H:i:s", strtotime($timeStart." +$startEndCheck minutes"))))
    {
      echo "Start Recording";
      startRec($ip);
      startRTMPrec($ip);
    }
    // if current time is over the stop time
    else if ($currentTime >= $timeEnd  && isRecording($ip) == 1 )
    {
       echo "Stop Recording";
       stopRec($ip);
       stopRTMPrec($ip);
    }

  
  }

}




