
// Get the API client and construct the service object.
$client = getClient($ip);
$service = new Google_Service_Calendar($client);

// Print the next event on the user's calendar.

// need to setup calanders based upon different ips of machines and then call a function to get those and pipe to here
$calendarId = 'lynchburg.edu_k0aa81td4eqp65j6u83ll64uqg@group.calendar.google.com';
$optParams = array(
  'maxResults' => 1,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),

);

