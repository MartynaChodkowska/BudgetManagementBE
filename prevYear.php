<?php
session_start();

if(!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}
	
require_once 'database.php';

try
	{
		$id = $_SESSION['userId'];
			
		$sql = "SELECT transactionGroup, SUM(amount) AS totalAmount FROM transactions WHERE userId= :userId AND YEAR(date) = YEAR(now() - INTERVAL 1 YEAR) AND transactionType='Income' GROUP BY transactionGroup ORDER BY totalAmount DESC";
		$incomesQuery = $db->prepare($sql);
		$incomesQuery->bindValue(':userId', $id, PDO::PARAM_STR);
		if($incomesQuery->execute())
		{
			$incomesQnty = $incomesQuery->rowCount();
			$incomesRows = $incomesQuery->fetchAll();
		}
		else
		{
			throw new Exception('Database error. We are really sorry! Try again later..');
		}
			
		$sql = "SELECT transactionGroup, SUM(amount) as totalAmount FROM transactions WHERE userId= :userId AND YEAR(date) = YEAR(now() - INTERVAL 1 YEAR) AND transactionType='Expense' GROUP BY transactionGroup ORDER BY totalAmount DESC";
		$expensesQuery = $db->prepare($sql);
		$expensesQuery->bindValue(':userId', $id, PDO::PARAM_STR);
		if($expensesQuery->execute())
		{
			$expensesQnty = $expensesQuery->rowCount();
			$expensesRows = $expensesQuery->fetchAll();	
		}
		else
		{
			throw new Exception('Database error. We are really sorry! Try again later..');
		}	
		
	}
catch(Exception $e)
	{
		echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
		//echo '<br />Dev info: '.$e;
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
			<a class="navbar-brand" href="index.php"><img src="img/logo.png"  width="52" alt="logo" class="d-inline-block align-center mr-2 ">
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
				
				<div class="row mt-5 mx-auto">
					<div class="buttons col-lg-8 bg-dark border border-secondary rounded-right">
						<h4 class="mt-2"><strong>previous year balance sheet</strong></h4>
						<table class="table table-sm table-striped table-dark table-hover mt-3 mx-auto text-center">
							<thead class="thead-dark">
								<tr><th colspan="2" scope="col" class="p-2 text-success border-bottom">INCOMES</th></tr>
								<tr><th scope="col">category</th><th scope="col">amount</th></tr>
							</thead>
							<tbody>
								<?php
								$totalIncomes=0;
								if(isset($incomesQnty))
								{
									if ($incomesQnty > 0)
									{
										foreach($incomesRows as $incomeRow)
										{
												$roundedIncAmount = round($incomeRow['totalAmount'], 2);
												echo"<tr><td>{$incomeRow['transactionGroup']}</td><td>{$roundedIncAmount} PLN</td></tr>";
												$totalIncomes+=$incomeRow['totalAmount'];
										}
									}
									else
									{
										echo "<tr><td colspan='2'>there are no incomes</td></tr>";
									}
									$roundedTotalIncAmount = round($totalIncomes,2);
									echo "<tr class='text-success'><th>total</th><th>$roundedTotalIncAmount PLN</th></tr>";
								}
								else
								{
									echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
								}
								?>
							</tbody>
						</table>
						<hr>
						<table class="table table-sm table-striped table-dark table-hover mt-3 mx-auto text-center">
							<thead>
								<tr><th colspan="2" scope="col" class="p-2 text-danger border-bottom">EXPENSES</th></tr>
								<tr><th scope="col">category</th><th scope="col">amount</th></tr>
							</thead>
							<tbody>
								<?php
								$totalExpenses=0;
								if(isset($expensesQnty))
								{
									if ($expensesQnty > 0)
									{
										foreach($expensesRows as $expenseRow)
										{
											$roundedExpAmount = round($expenseRow['totalAmount'],2);
											echo"<tr><td>{$expenseRow['transactionGroup']}</td><td>{$roundedExpAmount} PLN</td></tr>";
											$totalExpenses+=$expenseRow['totalAmount'];
										}
									}
									else
									{
										echo "<tr><td colspan='2'>there are no expenses</td></tr>";
									}
									$roundedTotalExpAmount = round($totalExpenses,2);
									echo "<tr class='text-danger'><th>total</th><th>$roundedTotalExpAmount PLN</th></tr>";
								}
								else
								{
									echo '<span class="error"> Server error! We apologize for the inconvenience. Please try again later.</span>';
								}
								?>
							</tbody>
						</table>
						<hr>
						<table class="table table-sm table-striped table-dark table-hover mt-3 mx-auto text-center">
							<thead>
								<tr><th scope="col" colspan="2" class="p-2 text-warning border-bottom">SUMMARY</th></tr>
							</thead>
							<tbody>
								<tr>
									<td scope="row">total Incomes</td>
									<?php
									echo "<td class='text-success'>$roundedTotalIncAmount PLN</td>";
									?>
								</tr>
								<tr>
									<td scope="row">total Expenses</td>
									<?php
									echo "<td class='text-danger'>$roundedTotalExpAmount PLN</td>";
									?>
								</tr>
								<tr class="text-warning">
									<th scope="row">Result</th>
									<?php
									$result = $roundedTotalIncAmount-$roundedTotalExpAmount;
																		
									echo "<th>$result PLN</th>";
									?>
								</tr>							
							</tbody>
						</table>
						<hr>
						<div class="p-3">
							<?php
							if($incomesQnty!=0 OR $expensesQnty!=0)
							{
								if($result > 0)
								{
									echo "<h1 style='color: ForestGreen; font-weight: 900;'>You are doing great job!</h1>";
								}
								else if($result < 0)
								{
									echo "<h1 style='color: FireBrick; font-weight: 900;'>Whoaa! Slow down with your expenses..</h1>";
								}
								else
								{
									echo "<h1 style='color: gold; font-weight: 900;'>well... could be worse, but still - try to make an effort to make some savings</h1>";
								}
							}
							else
							{
								echo "there are no transactions";
							}
							?>
						</div>
						</br></br>
					</div>
					
					<aside class="col-lg-4">
						<h5>Transactions review</h5>
						<ul>
							<a href="addIncome.php" class="list-group-item list-group-item-dark list-group-item-action">add income</a>
							<a href="addExpense.php" class="list-group-item list-group-item-dark list-group-item-action">add expense</a>
							<a href="lastTransactions.php" class="list-group-item list-group-item-dark list-group-item-action">last transactions</a>
						</ul>
						<h5 class="mt-5">Balance sheets review</h5>
						<ul>
							<a href="currentMonth.php" class="list-group-item list-group-item-dark list-group-item-action">running month</a>
							<a href="prevMonth.php" class="list-group-item list-group-item-dark list-group-item-action">previous month</a>
							<a href="currentYear.php" class="list-group-item list-group-item-dark list-group-item-action ">running year</a>
							<a href="prevYear.php" class="list-group-item list-group-item-dark list-group-item-action active">previous year</a>
							<a href="customDates.php" class="list-group-item list-group-item-dark list-group-item-action">custom dates</a>
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