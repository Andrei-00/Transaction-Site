<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['customer_login'])){
header('Location: user_mainpahe.php');
}

?>
 <html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>test</title>
    </head>
    <body>
        <style>
            form {display: table;}
            p {display: table-row;}
            input{display: table-cell;}
            label{display: table-cell;}
        </style>
        <h2>Password test</h2>
        <form action="login.php" method="POST">
            <p>
                <label for="username">Username:</label>
                <input type="text" name="username"><br>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password"><br>
            </p>
            <input type="submit" value="Log in">
        </form>
        <button onclick="document.location = 'new_account_info.html'">Sign up</button>
    </body>
</html>

