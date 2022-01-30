<?php

session_start();

$totalIncomes=0;
if(isset($_SESSION['incomesQnty']))
{
	if($_SESSION['incomesQnty'] > 0)
	{
		
		foreach($_SESSION['incomesRows'] as $incomeRow)
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
}
$roundedTotalIncAmount = round($totalIncomes,2);
echo "<tr class='bg-success'><th scope='row'>grand total</th><td>$roundedTotalIncAmount PLN</td>
</tr>"
?>