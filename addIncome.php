<?php

session_start();

if(!isset($_SESSION['logged']))
{
	header('Location: index.php');
	exit();
}

unset($_SESSION['transactionAdded']);

if(isset($_POST['amount']))
{
	$_SESSION['amount']=$_POST['amount'];
	$_SESSION['date']=$_POST['date'];
	$_SESSION['group']=$_POST['selectMenu'];
	$_SESSION['comment']=$_POST['comment'];
	$_SESSION['type']='Income';

	header('Location: try.php');
}

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
			<a class="navbar-brand" href="index.php"><img src="img/logo.png" width="52" alt="logo" class="d-inline-block align-bottom mr-2 ">
			<?php
				if(isset($_SESSION['login'])) 
				{
					echo "Nice to see you, ".$_SESSION['login']."!";
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
						<a class="nav-link" href="budget.php"><i class="icon-user"></i>My account</a>
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
		<article>
			<div class="container">
				<div class="row mx-auto">
						
					<div class="addTransaction col-lg-8 bg-dark border border-secondary rounded-right mt-5">
						<h1 class="h3 col-12 mb-4"> transaction details</h1>
						<form id="addIncome" method="post">
							<div class="form-group col-6 offset-3">
								<label for="amount">Income amount</label>
								<input type="number" step="0.01" min="0.00"class="form-control" name="amount" id="amount" value=""  required>
							</div>
							<div class="form-group col-6 offset-3">
								<label for="datePicker">Income date</label>
								<input type="date" class="form-control" id="datePicker" name="date" required">
							</div>
							<div class="form-group col-6 offset-3">
								<label for="selectMenu">Income category</label>
								<select id="selectMenu" name="selectMenu" class="form-control">
									<option value="salary" selected>salary</option>
									<option value="interest">interest</option>
									<option value="selling">selling</option>
									<option value="bonus">bonus</option>
									<option value="other">other</option>
								</select> 
							</div>
							<div class="form-group col-6 offset-3">
								<label for="comment">Comment</label>
								<textarea name="comment" id="comment" rows="3" class="col-12"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" value="Add income" class="d-inline-block col-4" >
								<input type="reset" value="Cancel" class="d-inline-block col-4">
								
							</div>
						</form>
					</div>
						
					<aside class="col-lg-4 mt-4">
						<h5>Transactions review</h5>
						<ul>
							<a href="addIncome.php" class="list-group-item list-group-item-dark list-group-item-action active">add income</a>
							<a href="addExpense.php" class="list-group-item list-group-item-dark list-group-item-action">add expense</a>
							<a href="lastTransactions.php" class="list-group-item list-group-item-dark list-group-item-action">last transactions</a>
						</ul>
						<h5 class="mt-5">Balance sheets review</h5>
						<ul>
							<a href="currentMonth.php" class="list-group-item list-group-item-dark list-group-item-action">running month</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">previous month</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">running year</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">previous year</a>
						</ul>
						<h5 class="mt-5">Categories manager</h5>
						<ul>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">categories review</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">add category</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">delete category</a>
						</ul>
					</aside>
							
				</div>
			</div>
		</article>
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