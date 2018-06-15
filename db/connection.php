<?php
define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "auth-o");


global $pdo;

$dns = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

try {

    $pdo = new PDO($dns, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "<h1>Failed to connect to  the DataBase</h1>";
    var_dump($e->getMessage());
}
