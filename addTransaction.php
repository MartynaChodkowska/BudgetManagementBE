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
	require_once "database.php";
		
	try
	{
		//add transaction to db
		$sql = "INSERT INTO transactions VALUES(NULL, '$userId', '$date', '$amount', '$group', '$type', '$note')";
		$addTransaction = $db->prepare($sql);
		if($addTransaction->execute())
		{
			$_SESSION['transactionAdded']=true;
			header('Location: lastTransactions.php');
		}
		else
		{
			throw new Exception('Database error. We are really sorry! Try again later..');
		}

	}
	catch(Exception $e)
	{
		echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
		echo '<br />Dev info: '.$e;
	}

?>