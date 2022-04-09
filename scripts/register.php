 
<?php
	$firstName = $_POST['form-first-name'];
	$LastName  = $_POST['form-last-name'] ;
	$Email     = $_POST['form-email'];
	$username  = $Email;
	$Password  = $_POST['form-reg-passwd'];

	if (filter_var($Email, FILTER_VALIDATE_EMAIL)) 
		{
		  $stop = FALSE;
		}
	else
		{
			$_SESSION['bademail'] = "You Entered A Bad Email";
			$stop = TRUE;		
		}
	// login and register to the system
	require_once'../includes/dbinfo.php';
	require_once'../includes/sessions.php';
	
  global $db;
  global $user;
  global $pass;
  global $host;
	
	$conn = new mysqli($host, $user, $pass, $db);
	// if connection error, die
	if ($conn->connect_error) 
	 	die($conn->connect_error);
	
	$query_rows = "SELECT * From `$db`.`extron_users`";
	$row_run = $conn->prepare($query_rows);
	$row_run -> execute();
	$row_run_rows = $row_run-> num_rows;
	
	$row_run ->close();
	$query1 = "SELECT * From `$db`.`extron_users` where `Email` = ? ;";
	
	$run = $conn->prepare($query1);
	$run->bind_param("s", $Email);
	$run-> execute();
	$run-> store_result();
	$rows = $run->num_rows;
	if ($rows != 0 || $stop == TRUE)
		{
			if ($rows != 0)
			{
				$_SESSION['register'] = "Email already in use";
			}
			else
			{
				$_SESSION['register'] = "Invalid Email Provided";
	
			}
		}
	else
		{
			$hash = password_hash("$Password", PASSWORD_DEFAULT );
			$insertRows = $row_run_rows + 1;
			$query3 = "INSERT INTO `$db`.`extron_users`(idusers, FirstName,LastName,Email,username,Password) VALUES ($insertRows,?,?,?,?,?)";
			  		
			$stmt2 = $conn->prepare($query3);
			$stmt2->bind_param("sssss", $Fname1, $Lname1, $Email1, $users, $pass);
			$pass   = $hash;
			$Fname1 = $firstName;
			$Lname1 = $LastName;
			$Email1 = $Email;
			$users = strtoupper($username);
			if(!$stmt2->execute())
				echo $stmt2->error;
			
			$_SESSION['register'] = "Registered Succesfully.";
		}

	header( "refresh:0;url=../pages/login.php" );
?>		