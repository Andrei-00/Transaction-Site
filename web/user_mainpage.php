<?php
session_start();
//echo $_SESSION['id'];
//$id = $_SESSION['id'];
//$_SESSION['id'] = $id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <style>

.vertical-menu{
	width: 300px;
	margin-left:auto;
	margin-right:auto;
	margin-top:auto;
	margin-bottom:auto;
}

.vertical-menu a{
	background-color:gray;
	color:black;
	display:block;
	padding:10px;

}

.vertical-menu a:hover{
	background-color:dimgray;
}

.vertical-menu a.active{
	background-color:dimgray;
	color:white;
}
</style>

</head>
<body>

<div class="vertical-menu">
    <a>Select an operation</a>
    <a href="Deposit.php">Deposit</a>
    <a href="Withdraw.php">Withdraw</a>
</div>

</body>
</html>