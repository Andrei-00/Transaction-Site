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

<h2>Deposit an amount of money</h2>

<form method="post">
    <label>Sum to be deposited: </label>
    <input type="text" name="deposit">
    <input type="submit" name="Deposit">
</form>

<?php

echo "<button onclick = \"document.location = 'user_mainpage.php'\">Main Page</button>";

require_once "dbconnect.php";

if(isset($_POST['deposit'])){
    try{
    $inst = DBHandler::getInstance();
    $conn = $inst->getConnection();
    
    $conn->beginTransaction();
    $id = $_SESSION['id'];
    $sum = (double)$_POST['deposit'];
    
    if($sum < 0){
        echo "Please insert a positive amount!";
    }else{
        $sql = "UPDATE hashes SET balance = balance + :sum Where id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sum', $sum);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
        echo "Deposit successful!";
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