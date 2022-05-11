<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a new account</title>
</head>
<body>
    <h2>Create an account</h2>
    <?php
    require_once "dbconnect.php";
    
    function sendConfirmationCode(string $email){
        $code = "";
        for($i = 0; $i < 4; $i++){
            $code .= rand(0, 9);
        }
        $to = "$email";
        $message = "Confirmation code: $code";
        $headers = 'From: webmaster@example.com' . "\r\n";
        if(mail($to, 'Test', $message, $headers) == false){
            echo "The mail was not sent! Please check the email-address or try again later.";
        }
        return $code;
    }
   
    try{
        //get the dbconnect 
        $inst = DBHandler::getInstance();
        $conn = $inst->getConnection();
        //begin transaction
        $conn->beginTransaction();
        if(!isset($_POST['submit'])){
        //we are connected to the database
        echo "Connected successfully<br>";
        //get form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpass = $_POST['confirmpass'];
        $email = $_POST['email'];
        
        $username = trim($username);
            
        //validate form data
        if(empty($username) || empty($password) || empty($email))
        {   
            exit("Registration failed!\n Please enter an username, a password and an email");
        }

        if(strcmp($password, $confirmpass) != 0)
        {   
            exit("Entered passwords are not the same!");
        }

        $sql = "SELECT count(*) FROM hashes WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $isUser = $stmt->fetchColumn();
        if($isUser){
            exit("Username already taken!");
        }
        

        //hash the password
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        //prepare statement
        $sql = "INSERT INTO hashes (username, password) VALUES(:username, :passwordhash)";
        $stmt = $conn->prepare($sql);
        //bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwordhash', $passwordhash);
        //execute statement
        if ($stmt->execute()) {
            echo "Executed querry successfully.\n";
        } else {
            echo "Couldn't execute querry.\n";
        }
        $stmt = null;
        $conn->commit();
        //send confirmation code
        $code = sendConfirmationCode($email);
            //getcode
        $_SESSION['code'] = $code;
        $_SESSION['username'] = $username;
        echo '<form method="post">
            <label>Confirmation code:</label>
            <input type="text" name="code">
            <input type="submit" name="submit">
            </form>';
        }else{
            //after introducing the code
            //verify the code
            $generatedcode = $_SESSION['code'];
            $username = $_SESSION['username'];
            if($_POST['code'] == $generatedcode){
                //if the code is corect then verify the account
                $sql = "UPDATE hashes SET verified = 1 WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                if ($stmt->execute()) {
                    echo "Executed querry successfully.\n";
                } else {
                    echo "Couldn't execute querry.\n";
                }
                $conn->commit();
                echo "Account created successfully!";
            }else{
                //if the code is incorect then don't verify the account and delete the entry from the database
                $sql = "DELETE FROM hashes WHERE username = :username";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':username', $username);
                if ($stmt->execute()) {
                    echo "Executed querry successfully.\n";
                } else {
                    echo "Couldn't execute querry.\n";
                }
                $conn->commit();
                echo "The confirmation code is incorect! Couldn't create new account.";
            }
        }
    }catch (PDOException $e){
    exit ("Error: " . $e->getMessage());
    }   
    //terminate the session  
    //session_destroy();
    ?>

</body>
</html> 