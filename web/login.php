<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>

    <?php

        require_once "dbconnect.php";

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)){
            exit("Login failed!\nPlease enter an username and a password");
        }
        try{
        $inst = DBHandler::getInstance();
        $conn = $inst->getConnection();
        $conn->beginTransaction();
        $sql = "SELECT count(*) FROM hashes WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $isUser = $stmt->fetchColumn();

        $sql = "SELECT password, verified FROM hashes WHERE username = :username";
        $stmt = $conn->prepare($sql);   
	    $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_DEFAULT);
        $passwordhash = $result['password'];
        $verified = $result['verified'];

        if($isUser && password_verify($password, $passwordhash) && $verified == true){
            $sql = "Select id FROM hashes WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $id = $stmt->fetchColumn();
            $_SESSION['id'] = $id;
            header('Location: user_mainpage.php');
        }else{
            echo "<h2>Login</h2> <p>The username or password is incorect</p>";
        }
        $conn->commit();
    }catch (PDOException $e){
        if (isset ($conn)) 
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    }

    ?>
</body>
</html>