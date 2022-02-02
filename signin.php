<?php

	session_start();
	
	require_once "database.php";
	
	if(!isset($_SESSION['logged']))
	{
		if(isset($_POST['email']))
		{
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			$password = filter_input(INPUT_POST, 'password');
			$_SESSION['given_email'] = $_POST['email'];
			
			$userQuery = $db->prepare('SELECT userId, password, name FROM users WHERE email= :email');
			$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
			$userQuery->execute();
			
			$user = $userQuery->fetch();
			
			if($user && password_verify($password, $user['password']))
			{
				$_SESSION['logged'] = true;	
				
				$_SESSION['userId'] = $user['userId'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['password'] = $user['password'];
				$_SESSION['name'] = $user['name'];

				unset($_SESSION['blad']);
				header('Location: budget.php');
			}
			else
			{
				$_SESSION['blad'] = true;
				header('Location: login.php');
				exit();
			}
		}
		else
		{
			header('Location: login.php');
			exit();
		}
	}
	else
		{
			header('Location: login.php');
			exit();
		}