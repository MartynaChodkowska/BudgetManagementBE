<?php
session_start();
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
	
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge" >
	<title>master yout budget!</title>
	
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;600&display=swap" rel="stylesheet">
	
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->

</head>

<body>
	<header>
		<nav class="navbar navbar-light bg-piggy navbar-expand-md py-1">
			<a class="navbar-brand" href="index.php"><img src="img/logo.png"  width="52" alt="logo" class="d-inline-block align-bottom mr-2 ">
				<?php
				if(isset($_SESSION['login'])) 
				{
					echo "Nice to see you, ".$_SESSION['login']."!";
				}
				else 
				{
					echo "feed the piggy";
				}
				?>
			</a>
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navigation switcher">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item active">
						<a class="nav-link" href="index.php" active><i class="icon-home"></i> Home</a>
					</li>
					<li class="navbar-item">
						<a class="nav-link" href="signin.php"><i class="icon-login"></i> Sign in</a>
					</li>	
					<li class="navbar-item">
						<a class="nav-link" href="regi.php"><i class="icon-spread"></i> Join us</a>
					</li>
					<li class="navbar-item">
						<a class="nav-link" href="logout.php"><i class="icon-logout"></i> Sign out</a>
					</li>					
					<li class="navbar-item">
						<a class="nav-link" href="#"><i class="icon-cog"></i> Settings</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
		
	<main>	
		<section class="west">
			<div class="container">
				<header>
					<h1  class="display-5 my-4">feed the piggy and become a master of your budget!</h1>
				</header>
				
				<div class="intro col-sm-12">
					<div class="card-deck">
						<div class="card col-xs-12 col-lg-6 bg-piggy">
							<img class="card-img-top my-2"  src="img/messyhead.png" alt="">
							<div class="card-body bg-piggy">
								<p class="card-text">
									<p>too little incomes, too little spendings?</p>
									<p>too little incomes, too much spendings?</p>
									<p>too much incomes, too much spendings?</p>		
									<p>too much incomes, too little spendings?<p/>
									<h5 class="card-title">don't let your head explode!</h5>
								</p>
							</div>
						</div>		
						<div class="card col-xs-12 col-lg-6 bg-piggy">
							<img class="card-img-top my-2"  src="img/clear.png" alt="headExplode">
							<div class="card-body bg-piggy">
								<h5 class="card-title">let's keep it simple</h5>
								<p class="card-text">& make it the best possible way -
									<span class="d-block">clear, plain & beautiful!</span>
								</p>
							</div>
						</div>
					</div>	
						<div class="card logCard col-12 bg-piggy mt-4">
							<div class="card-body bg-piggy">
								<h5 class="display-4 card-title my-3">let's start</h5>
								<p class="card-text">
									<form id="logIn" action="signin.php" method="post">
										<div class="form-group">
											<label for="userName"></label>
											<input type="text" name="login"class="d-block col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" placeholder="username" onfocus="this.placeholder=''" onblur="this.placeholder='username'">
										</div>
										<div class="form-group">
											<label for="password"></label>
											<input type="password" name="password" class="d-block col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
										</div>
										<input type="submit" class="d-block col-sm-6 offset-sm-3 col-md-4 offset-md-4 col-lg-4 offset-lg-4 my-5" value="enter">
									</form>
									<hr>
									<div class="goToRegistration d-block mt-4">
										or click <a href="regi.php">here</a> if you haven't signed up yet
									</div>
								</p>
							</div>
						</div>
							
				</div>
			</div>
<?php

	if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
?>
		</section>
	</main>	
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