<?php

function dbConnect(string $user, string $pass, string $db, string $host = '127.0.0.1'): PDO
{
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}