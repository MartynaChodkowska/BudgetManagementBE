<?php
session_start();

if(!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}
	
require_once 'connect.php';

mysqli_report(MYSQLI_REPORT_STRICT);


if(isset($_POST['startBalanceDate']))
{
	unset($_SESSION['errorDate']);			

	$st=$_POST['startBalanceDate'];
	$en=$_POST['endBalanceDate'];
	
	if($st > $en)
	{	
		$_SESSION['errorDate'] = '<span style="color:red">Wrong range of dates!</span>';
		header('Location: balanceSheet.php');
	}
	else
	{
		try
			{
				$link = @new mysqli($host, $db_user, $db_password, $db_name);

				if($link->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
				else
				{
					$id = $_SESSION['userId'];
					
					$sql = "SELECT transactionGroup, SUM(amount) AS totalAmount FROM transactions WHERE userId=$id AND transactionType='Income' AND (date BETWEEN '$st' AND '$en') GROUP BY transactionGroup ORDER BY totalAmount DESC";
										
					if($result = @$link->query($sql))
					{
						$incomesQnty = $result->num_rows;
						$incomesRows = $result->fetch_all(MYSQLI_ASSOC);
						$result->free_result();
					}
					else
					{
						throw new Exception(mysqli_connect_errno());
					}
					
					$sql = "SELECT transactionGroup, SUM(amount) as totalAmount FROM transactions WHERE userId=$id AND transactionType='Expense' AND (date BETWEEN '$st' AND '$en') GROUP BY transactionGroup ORDER BY totalAmount DESC";
					
					if($result = @$link->query($sql))
					{
						$expensesQnty = $result->num_rows;
						$expensesRows = $result->fetch_all(MYSQLI_ASSOC);
						$result->free_result();
					}
					else
					{
						throw new Exception(mysqli_connect_errno());
					}
					$link->close();
				}
			}
		catch(Exception $e)
			{
				echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
				echo '<br />Dev info: '.$e;
			}
	}
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
			<a class="navbar-brand" href="#"><img src="img/pigybank1.jpg" width="52" alt="logo" class="d-inline-block align-bottom mr-2 ">feed the piggy</a>
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navigation switcher">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a class="nav-link" href="index.php"><i class="icon-home"></i> Home</a>
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
						
					<div class="balanceSheet col-lg-8 bg-dark border border-secondary rounded-right mt-5">
						<form id="displayBalanceSheet" method="post">
							<div class="form-group col-6 offset-3">
								<legend>choose period of time</legend>
								
								<label for="startBalanceDate" id="timePeriod">start date</label>
								<input type="date" class="form-control" required id="startBalanceDate" name="startBalanceDate" min="" max="">
								<hr>
								<label for="endBalanceDate" id="timePeriod">end date</label>
								<input type="date" class="form-control" required id="endBalanceDate" name="endBalanceDate" min="" max="">
								<?php
									if(isset($_SESSION['errorDate'])) echo $_SESSION['errorDate'];
								?>
							</div>
							<div class="form-group">
								<input type="submit" value="check balance" class="d-inline-block col-4" >
								<input type="reset" value="Cancel" class="d-inline-block col-4">
							</div>
						</form>
						<hr>
						<div class="table-responsive-sm">
							<table class="table incomesTable table-hover table-sm mt-3">
								<thead class="thead-dark">
									<tr>
										<th colspan="2" scope="col">Incomes Summary</th>
									</tr>
								</thead>
								<thead>
									<tr>
										<th scope="col">category</th>
										<th scope="col">total</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$totalIncomes=0;
								if(isset($incomesQnty))
								{
									if($incomesQnty > 0)
									{
										
										foreach($incomesRows as $incomeRow)
										{
											$roundedIncAmount = round($incomeRow['totalAmount'], 2);
											echo "<tr><th scope='row'>{$incomeRow['transactionGroup']}</th><td>{$roundedIncAmount} PLN</td></tr>";
											$totalIncomes+=$incomeRow['totalAmount'];
										}
									}
									else
									{
										echo "<tr><td colspan='2'>there is no incomes</td></tr>";
									}
								
								$roundedTotalIncAmount = round($totalIncomes,2);
								echo "<tr class='bg-success'><th scope='row'>grand total</th><td>$roundedTotalIncAmount PLN</td>
								</tr>"
								}
								?>
								</tbody>
							</table>
						</div>
						<hr>
						<div class="table-responsive-sm">
							<table class="table expensesTable table-hover table-sm  mt-3">
								<thead class="thead-dark">
									<tr>
										<th colspan="2" scope="col">Expenses Summary</th>
									</tr>
								</thead>
								<thead>
									<tr>
										<th scope="col">category</th>
										<th scope="col">total</th>
									</tr>
								</thead>
								<tr>
									<th scope="row">cat 1</th>
									<td>total</td>
								</tr>
								<tr>
									<th scope="row">cat 2</th>
									<td>total</td>
								</tr>
								<tr>
									<th scope="row">cat 3</th>
									<td>total</td>
								</tr>
								<tr>
									<th scope="row">cat 4</th>
									<td>total</td>
								</tr>
								<tr class="bg-danger">
									<th scope="row">grand total</th>
									<td> 1234 PLN </td>
								</tr>
							</table>
						</div>
						<hr>
						<div class="balanceSummary">
							<div class="card col-12 bg-piggy">
								<div class="card-body bg-piggy">
									<h5 class="display-4 card-title my-3">result:</h5>
									<p class="card-text display-4">
										0 PLN
									</p>
									<p class="card-text h4">
										be careful!	there is no savings at all!						
										<a class="btn btn-info mt-3 d-block mx-auto" data-toggle="collapse" href="#collapseChart" role="button" aria-expanded="false" aria-controls="#collapseChart">
											want to see how it looks like?
										</a>
									</p>
									<div class="collapse mx-auto" id="collapseChart">
											<div class="piechart mx-auto"></div>
									</div>
										
											
								</div>
							</div>
						</div>
					
					</div>
						
					<aside class="col-lg-4 mt-4">
						<h5>Transactions review</h5>
						<ul>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">add income</a>
							<a href="#" class="list-group-item list-group-item-dark list-group-item-action">add expense</a>
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