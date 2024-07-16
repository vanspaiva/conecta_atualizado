<?php

$serverName = "localhost:3307";
$dbUsername = "root";
$dbPassword = "";
$dbName = "conecta";

/* $serverName = "localhost";
$dbUsername = "u777557116_adminconecta";
$dbPassword = "YDT8HJPHc!";
$dbName = "u777557116_bdcpmhconecta"; */

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if(mysqli_connect_errno())
{
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
