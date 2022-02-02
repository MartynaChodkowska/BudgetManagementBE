<?php

session_start();

	if(isset($_POST['email']))
		{
			//validation ok
			$allOK = true;
			
			/*	
			//if login correct
			$login = $_POST['userName'];
						
			if((strlen($login)<3) || (strlen($login)>20))
			{
				$allOK = false;
				$_SESSION['e_login'] = "Login has to contain 3-20 characters.";
			}
			
			if(ctype_alnum($login) == false)
			{
				$allOK = false;
				$_SESSION['e_login'] = "Login has to contain only digits and characters (no special characters).";
			}*/
			
			//email validation
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			if(empty($email))
				{
					$_SESSION['wrongEmailFormat'] = $_POST['email'];	
					echo "dupa";
					$allOK = false;
					header('Location: index.php');
				}
			else
				$_SESSION['given_email']=$_POST['email'];
			
			
			//first name validation
			$fname = $_POST['firstName'];
			
			if((strlen($fname)<3) || (strlen($fname)>15))
			{
				$allOK = false;
				$_SESSION['e_firstname'] = "First name has to contain 3-15 characters.";
			}
			
			if(ctype_alpha($fname) == false)
			{
				$allOK = false;
				$_SESSION['e_firstname'] = "First name has to contain only characters (no special characters).";
			}
			
			//second name validation 
			//jak zrobic by akceptowało nazwisko z myślnikiem?
			$sname = $_POST['secondName'];
			
			if((strlen($sname)<3) || (strlen($sname)>20))
			{
				$allOK = false;
				$_SESSION['e_secondname']="Second name has to contain 3-20 characters.";
			}
			
			if(ctype_alpha($sname) == false)
			{
				$allOK = false;
				$_SESSION['e_secondname'] = "Second name has to contain only characters (no special characters).";
			}
			
			//passwords validation
			$pass1=$_POST['password'];
			$pass2=$_POST['confirmPassword'];
			
			if((strlen($pass1)<8) || (strlen($pass1)>20))
			{
				$allOK = false;
				$_SESSION['e_haslo']="Password has to contain 8-20 characters.";
			}
			
			if($pass1!=$pass2)
			{
				$allOK = false;
				$_SESSION['e_haslo']="Password and confirm password does not match.";
			}
					
			$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
		
			
			//if rules are accepted
			
			if(!isset($_POST['rules']))
			{
				$allOK = false;
				$_SESSION['e_rules']="Please confirm the rules.";
			}
			
			//bot or not?
			$sekret = "6LeWwvUdAAAAAHB7nbSpqExOfjpH5AF95YL7vQ0P";
			
			$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
			
			$answer = json_decode($check);
			
			if($answer->success==false)
			{
				$allOK = false;
				$_SESSION['e_bot']="Please confirm that your not a bot!";
			}
			
			//check if login does not already exist
			require_once "database.php";
		
			try
			{
				$usersQuery = $db->prepare('SELECT userId FROM users WHERE email = :email');
				$usersQuery->bindValue(':email', $email, PDO::PARAM_STR);
				$usersQuery->execute();
				
				$howManyEmails = $usersQuery->rowCount();
				
				if($howManyEmails>0)
				{
					$allOK = false;
					$_SESSION['e_email']="There is an account with this email.";
				}
					
				else if($allOK == true)
				{
					//adding user to database
					$insertUser = $db->prepare("INSERT INTO users VALUES(NULL, '$email', '$pass_hash', '$fname', '$sname')");
					if($insertUser->execute())
					{
						$_SESSION['regiOK']=true;
						header('Location: budget.php');
					}
					else
					{
						throw new Exception('something went wrong.. please try again later');
					}
					
				}
				
			}
			catch(Exception $e)
			{
				echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
				//echo '<br />Dev info: '.$e;
			}
		}
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
	
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>master yout budget!</title>
	
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;600&display=swap" rel="stylesheet">
	
	<script src="https://www.google.com/recaptcha/api.js"></script>
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->

</head>

<body>
	<header>
		<nav class="navbar navbar-light bg-piggy navbar-expand-md py-1">
			<a class="navbar-brand" href="index.php"><img src="img/logo.png"  width="52" alt="logo" class="d-inline-block align-center mr-2 ">
				<?php
				if(isset($_SESSION['given_login'])) 
				{
					echo "Nice to see you, ".$_SESSION['given_login']."!";
				}
				else 
				{
					echo "art of finance";
				}
				?>
			</a>
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navigation switcher">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a class="nav-link" href="index.php"><i class="icon-home"></i> Home</a>
					</li>
					<li class="navbar-item">
						<a class="nav-link" href="login.php"><i class="icon-login"></i> Sign in</a>
					</li>	
					<li class="navbar-item active">
						<a class="nav-link" href="regi.php" active><i class="icon-spread"></i> Join us</a>
					</li>					
					<li class="navbar-item">
						<a class="nav-link" href="#"><i class="icon-cog"></i> Settings</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
			
	<main>
		<section>
			<div class="container">
				<form id="registration" method="post">
					<h3 class="my-3">Registration</h3>
					<hr>
					<!--<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="userName">User name</label>
						<input type="text" class="form-control d-block" id="userName" name="userName" aria-descirbedby="userName" placeholder="user name" onfocus="this.placeholder=''" onblur="this.placeholder='user name'">
					</div>-->
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="email">email adress (it will be your login)</label>
						<input type="email" class="form-control d-block" id="email" name="email" aria-descirbedby="userName" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='email'"
						<?php 
						if(isset($_SESSION['given_email']))
						{	
							'value="' .$_SESSION['given_email'] .'"';
						}
						?>
						>
					</div>
					<?php
						if(isset($_SESSION['wrongEmailFormat']))
						{
							echo '<p>Wrong email format!</p>';
							unset($_SESSION['wrongEmailFormat']);
						}
					
						elseif(isset($_SESSION['e_email']))
						{
							echo $_SESSION['e_email'].'<br>';
							unset($_SESSION['e_email']);
						}
					?>
					
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="firstName">First name</label>
						<input type="text" class="form-control d-block" id="firstName" name="firstName" aria-descirbedby="firstName" placeholder="first name" onfocus="this.placeholder=''" onblur="this.placeholder='first name'">
											
					</div>
				
					<?php
						if(isset($_SESSION['e_firstname']))
						{
							echo '<div class="error">'.$_SESSION['e_firstname'].'</div>';
							unset($_SESSION['e_firstname']);
						}
					?>
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="secondName">Second name</label>
						<input type="text" class="form-control d-block" id="secondName" name="secondName" aria-descirbedby="secondName" placeholder="second name" onfocus="this.placeholder=''" onblur="this.placeholder='second name'">
					</div>
					
					<?php
						if(isset($_SESSION['e_secondname']))
						{
							echo '<div class="error">'.$_SESSION['e_secondname'].'</div>';
							unset($_SESSION['e_secondname']);
						}
					?>
					<!--<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="emailAdress">Email adress</label>
						<input type="email" class="form-control d-block" id="emailAdress" name="email" aria-desribedby="emailAdress" placeholder="email" onfocus="this.placeholder=''" onblur="this.placeholder='email'">
						<small id="emailAdress" class="form-text">We'll never share your email with anyone else.</small>
					<div>
					<br />-->
						
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 mt-2 md-0">
						<label for="password">Password</label>
						<input type="password" class="form-control d-block" id="password" name="password" aria-descirbedby="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
					</div>
					<?php
						if(isset($_SESSION['e_password']))
						{
							echo '<div class="error">'.$_SESSION['e_password'].'</div>';
							unset($_SESSION['e_password']);
						}
					?>	
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="confirmPassword">Confirm password</label>
						<input type="password" class="form-control d-block" id="confirmPassword" name="confirmPassword" aria-descirbedby="confirmPassword" placeholder="confrim password" onfocus="this.placeholder=''" onblur="this.placeholder='confirm password'">
					</div>
					<div class="form-check mt-4">
						<input type="checkbox" class="form-check-input" id="rules" name="rules">
						<label class="form-check-label" for="rules">I have read, understand, and agree to <a href="rules.php">the rules and regulations.</a></label>
					</div>
					<br />
					<?php
						if(isset($_SESSION['e_rules']))
						{
							echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
							unset($_SESSION['e_rules']);
						}
					?>
					<br />
					<div class="g-recaptcha col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" data-sitekey="6LeWwvUdAAAAAPlaEsuDT5zCWEnhixSRm3_5eecp" ></div>
					
					<input type="submit" class="d-block col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" value="register now!"/>
				</form>

			</div>
		</section>
	</main>
		
	
	
	</div>
	<footer class="text-center mt-5">
		<h6>Thanks for visiting me! &copy; All rights reserved</h6>
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<script src="jquery-3.6.0.min.js"></script>
	<script src="budget.js"></script>

</body>


</html>