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
			<a class="navbar-brand" href="#"><img src="img/pigybank1.jpg" width="52" alt="logo" class="d-inline-block align-bottom mr-2 ">feed the piggy</a>
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navigation switcher">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a class="nav-link" href="#"><i class="icon-home"></i> Home</a>
					</li>
					<li class="navbar-item">
						<a class="nav-link" href="#"><i class="icon-login"></i> Sign in</a>
					</li>	
					<li class="navbar-item active">
						<a class="nav-link" href="#"><i class="icon-spread"></i> Join us</a>
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
				
				<form id="registration">
					<h3 class="my-3">Registration</h3>
					<hr>
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="userName">User name</label>
						<input type="text" class="form-control d-block" id="userName" aria-descirbedby="userName" placeholder="username" onfocus="this.placeholder=''" onblur="this.placeholder='username'">
					</div>
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="firstName">First name</label>
						<input type="text" class="form-control d-block" id="firstName" aria-descirbedby="firstName" placeholder="first name" onfocus="this.placeholder=''" onblur="this.placeholder='first name'">
					</div>	
					<div class="form-group col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<label for="emailAdress">Email adress</label>
						<input type="email" class="form-control d-block" id="emailAdress" aria-desribedby="emailAdress" placeholder="email" onfocus="this.placeholder=''" onblur="this.placeholder='email'">
						<small id="emailAdress" class="form-text">We'll never share your email with anyone else.</small>
					<div>
					<div class="form-group col-12 mt-2">
						<label for="password">Password</label>
						<input type="password" class="form-control d-block" id="password" aria-descirbedby="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
					</div>
					<div class="form-group col-12">
						<label for="confirmPassword">Confirm password</label>
						<input type="password" class="form-control d-block" id="confirmPassword" aria-descirbedby="confirmPassword" placeholder="confrim password" onfocus="this.placeholder=''" onblur="this.placeholder='confirm password'">
					</div>
					<div class="form-check mt-4">
						<input type="checkbox" class="form-check-input" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">Check me out</label>
					</div>
					<input type="submit" class="d-block col-12" value="register now!">
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