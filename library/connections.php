<?php

function phpmotorsconnect()
{

    $server = "changethis";
    $dbname = "changethis";
    $username = "changethis";
    $password = "changethis";
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        
        return $link;
    } catch (PDOException $e) {
        header('Location: /view/500.php');
        exit;
    }
}


phpmotorsconnect();
