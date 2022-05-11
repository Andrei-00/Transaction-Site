<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>Withdraw an amount of money</h2>

<form method="post">
    <label>Sum to be withdrawed: </label>
    <input type="text" name="withdraw">
    <input type="submit" name="Withdraw">
</form>

<?php

echo "<button onclick = \"document.location = 'user_mainpage.php'\">Main Page</button>";

require_once "dbconnect.php";

if(isset($_POST['withdraw'])){
    try{
    $inst = DBHandler::getInstance();
    $conn = $inst->getConnection();
    
    $conn->beginTransaction();
    $id = $_SESSION['id'];
    $sum = (double)$_POST['withdraw'];

    $sql = "SELECT balance FROM hashes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindparam(':id', $id);
    $stmt->execute();
    $balance = $stmt->fetchColumn();
    
    if($sum > $balance){
        echo "There is not enough money in the account!";
    }else if($sum < 0){
        echo "Please insert a positive amount!";
    }else{
        $sql = "UPDATE hashes SET balance = balance - :sum Where id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sum', $sum);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
        echo "Withdraw successful!";
        }else{
            echo "There was an error!";
        }
        $stmt = null;
        $conn->commit();
    }

    }catch (PDOException $e){
        exit ("Error: ". $e->getMessage());
    }
}



?>




</body>
</html>