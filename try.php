<?php

session_start();
	$_SESSION['transactionAdded']=false;
	$userId = $_SESSION['userId'];
	$date = $_SESSION['date'];
	$amount = $_SESSION['amount'];
	$group = $_SESSION['group'];
	$type = $_SESSION['type'];
	$note = $_SESSION['comment'];
	
	//połącz z bazą
	require_once "connect.php";
		
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			//add transaction to db
			if($connection->query("INSERT INTO transactions VALUES(NULL, '$userId', '$date', '$amount', '$group', '$type', '$note')"))
			{
				$_SESSION['transactionAdded']=true;
				$connection->close();
				header('Location: lastTransactions.php');
			}
			else
			{
				throw new Exception($connection->error);
			}
						
			
		}
	}
	catch(Exception $e)
	{
		echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
		echo '<br />Dev info: '.$e;
	}

?>