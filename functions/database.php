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

function getTodos(PDO $db, bool $withTrashed = false): array
{
    if ($withTrashed === true) {
        $result = $db->query('SELECT * FROM todos');
    }

    if ($withTrashed === false) {
        $result = $db->query('SELECT * FROM todos WHERE deleted_at IS NULL');
    }

    return $result->fetchAll();
}

function getPendingCount(PDO $db): int
{
    $result = $db->query('SELECT count(*) FROM todos WHERE done = 0 and deleted_at IS NULL');
    return $result->fetchColumn();
}

function getCompletedCount(PDO $db): int
{
    $result = $db->query('SELECT count(*) FROM todos WHERE done = 1 and deleted_at IS NULL');
    return $result->fetchColumn();
}

function checkTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $result = $db->prepare('UPDATE todos SET done = 1, updated_at = :updated_at WHERE id = :id');
    $result->bindParam('id', $id);
    $result->bindParam('updated_at', $date);
    $result->execute();
}

function unCheckTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $result = $db->prepare('UPDATE todos SET done = 0, updated_at = :updated_at WHERE id = :id');
    $result->bindParam('id', $id);
    $result->bindParam('updated_at', $date);
    $result->execute();
}

function deleteTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $result = $db->prepare('UPDATE todos SET deleted_at = :deleted_at WHERE id =:id');
    $result->bindParam('id', $id);
    $result->bindParam('deleted_at', $date);
    $result->execute();
}