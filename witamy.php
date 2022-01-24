<?php
	session_start();
	
	/*if(!isset($_SESSION['incomeAdded']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['incomeAdded']);
	}*/
	echo "echo ".$_SESSION['incomeAdded'];
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>

<body>
	
	Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto.<br /><br />
	
	<a href="index.php">Zaloguj się na swoje konto!</a>
	<br /><br />
	
</body>
</html>