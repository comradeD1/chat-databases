<?php
require_once __DIR__.'/config.php';

function connectToDatabase($config) {
    $host = $config['host'];
    $dbname = $config['dbname'];
    $user = $config['user'];
    $password = $config['pass'];

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return null;
    }
}

$connect = connectToDatabase(MYSQL_OPTS);

?>