<!DOCTYPE html>
 <html>
    <head>
        <meta charset = "utf-8">
        <title>test</title>
    </head>
    <body>

        <?php
        //fibonacci
        $first = 0;
        $second = 1;
        $n = 20;
        for($i = 0; $i < $n; $i++){
            echo $first."<br>";
            $aux = $second;
            $second = $first + $second;
            $first = $aux;
        }
        ?>

    </body>
</html>