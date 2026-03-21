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

function addToDo(PDO $db, string $text): void
{
    $text = htmlspecialchars($text);
    $statement = $db->prepare("INSERT INTO todos (text) VALUES (:text)");
    $statement->bindParam(':text', $text);
    $statement->execute();
}

function getTodos(PDO $db): array
{
    $result = $db->query('SELECT * FROM todos');
    return $result->fetchAll();
}

function getPendingCount(PDO $db): int
{
    $result = $db->query('SELECT count(*) FROM todos WHERE done = 0');
    return $result->fetchColumn();
}

function getCompletedCount(PDO $db): int
{
    $result = $db->query('SELECT count(*) FROM todos WHERE done = 1');
    return $result->fetchColumn();
}

function checkTodo(PDO $db, int $id): void
{
    $result = $db->prepare('UPDATE todos SET done = 1 WHERE id = :id');
    $result->bindParam('id', $id);
    $result->execute();
}

function unCheckTodo(PDO $db, int $id): void
{
    $result = $db->prepare('UPDATE todos SET done = 0 WHERE id = :id');
    $result->bindParam('id', $id);
    $result->execute();
}

function deleteTodo(PDO $db, int $id): void
{
    $result = $db->prepare('DELETE FROM todos WHERE id = :id');
    $result->bindParam('id', $id);
    $result->execute();
}