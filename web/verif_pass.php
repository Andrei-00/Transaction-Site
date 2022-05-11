<!DOCTYPE html>
 <html>
    <head>
        <meta charset = "utf-8">
        <title>test</title>
    </head>
    <body>
        <h2>Password test</h2>
        <?php
        $hash = password_hash('parola', PASSWORD_DEFAULT);
        if(password_verify('parola', $hash)){
            echo 'Parola e buna';
        }else{
            echo 'Nu mai fura';
        }
        ?>
    </body>
</html>