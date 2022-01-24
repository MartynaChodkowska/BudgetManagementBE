<?php

	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if ($result = @$connection->query(
		sprintf("SELECT * FROM users WHERE login='%s'",
		mysqli_real_escape_string($connection,$login))))
		{
			$users_cnt = $result->num_rows;
			
			if($users_cnt>0)
			{
				$row = $result->fetch_assoc();
				
				
				if(password_verify($password, $row['password']))
				{
					$_SESSION['logged'] = true;
										
					$_SESSION['userId'] = $row['userId'];
					$_SESSION['login'] = $row['login'];
					$_SESSION['password'] = $row['password'];
					$_SESSION['name'] = $row['name'];
					$_SESSION['secondname'] = $row['secondname'];
					
					unset($_SESSION['blad']);
					$result->free_result();
					header('Location: budget.php');
				}
				else
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: login.php');
				}
			}else{
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: login.php');
			}
		}
		
		$connection->close();
	}
