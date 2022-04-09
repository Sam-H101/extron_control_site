
<?php
session_start();
function SessionStop()
	{
	$_SESSION = array();
	// make it all stop and kill any cookies
	if (session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time()-2592000, '/');
	// set back to default
	$_SESSION['username'] = '';
	$userStr = '(Guest)';
	$loggedIn = FALSE;	
	
	// destroy it all
	$_SESSION = array();
  session_destroy();
	// refresh the page
	$_SESSION['isLoggedIn'] = FALSE;


	header( "refresh:0;url=/pages/index.php" );
}


// default values for when there is no login found
if (!isset($_SESSION['isLoggedIn']))
	{
		$_SESSION['isLoggedIn'] = FALSE;
		$_SESSION['username']   = '';
		$_SESSION['FirstName']  = '';
		$_SESSION['LastName']   = '';
		$_SESSION['id']         = '';
	}



function checkLogin()
{
 if ($_SESSION['isLoggedIn'] == true)
  return true;
  else return false;
}



?>