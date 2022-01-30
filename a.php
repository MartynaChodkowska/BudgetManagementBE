<?php

session_start();

$startdata = '2022-01-11';
$enddata = '2022-02-11';

echo $startdata."</br>";
echo $enddata."</br>";

$dataczas = new DateTime($startdata);
$dataczas1 = new DateTime($enddata);

echo $dataczas->format('Y-m-d')."</br>";
echo $dataczas1->format('Y-m-d')."</br>";

if($dataczas < $dataczas1)
{
	echo "mniejsze";
}
else if ($dataczas == $dataczas1)
{
	echo "rowne";
}
else
{
	echo "wieksze";
}

?>



$sql = "SELECT transactionGroup, SUM(amount) AS totalAmount FROM transactions WHERE userId=$id AND transactionType='Income' AND ((DAY(date) >= DAY($_POST['startBalanceDate']) AND MONTH(date)>=MONTH($_POST['startBalanceDate']) AND YEAR(date) >= YEAR($_POST['startBalanceDate'])) AND (DAY(date)<=DAY($_POST['endBalanceDate']) AND MONTH(date)<=MONTH($_POST['endBalanceDate']) AND YEAR(date) <= YEAR($_POST['endBalanceDate']))) GROUP BY transactionGroup ORDER BY totalAmount DESC";

SELECT userId, date, transactionGroup, SUM(amount) as totalAmount FROM transactions WHERE ((DAY(date) >= DAY('2022-01-05') AND MONTH(date)>=MONTH('2022-01-05') AND YEAR(date) >= YEAR('2022-01-05')) AND (DAY(date)<=DAY('2022-01-25') AND MONTH(date)<=MONTH('2022-01-25') AND YEAR(date) <= YEAR('2022-01-25'))) GROUP BY transactionGroup ORDER BY totalAmount DESC