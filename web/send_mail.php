<!DOCTYPE html>
 <html>
    <head>
        <meta charset = "utf-8">
        <title>test</title>
    </head>
    <body>
        <h2>Test send mail</h2>
        <?php
        $to = 'ytpensionaru@gmail.com';
        $message = "Salut\nCe faci?";
        $headers = 'From: webmaster@example.com' . "\r\n";
        if(mail($to, 'Test', $message, $headers) == true){
            echo "Mail accepted for delivery";
        }else{
            echo "Mail not accepted for delivery";
        }
        ?>

    </body>
</html>