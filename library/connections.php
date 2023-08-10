<?php

function phpmotorsconnect()
{

    $server = "localhost";
    $dbname = "phpmotors";
    $username = "IClient";
    $password = "s)EewaObKg34JAE_";
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        mysqli_connect($server, $username, $password, $dbname);
        
    } catch (Exception $e) {
        header('Location: /phpmotors/view/500.php');
        exit;
    }
}


phpmotorsconnect();
