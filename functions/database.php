<?php
function dbConnect(string $user, string $pass, string $db, string $host = '127.0.0.1'): PDO
{
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function addToDo(PDO $db, string $text): void
{
    $text = htmlspecialchars($text);
    $stmt = $db->prepare("INSERT INTO todos (text) VALUES (:text)");
    $stmt->bindParam(':text', $text);
    $stmt->execute();
}

function getTodos(PDO $db, bool $withTrashed = false): array
{
    if ($withTrashed) {
        $stmt = $db->query('SELECT * FROM todos');
    } else {
        $stmt = $db->query('SELECT * FROM todos WHERE deleted_at IS NULL');
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPendingCount(PDO $db): int
{
    $stmt = $db->query('SELECT COUNT(*) FROM todos WHERE done = 0 AND deleted_at IS NULL');
    return (int)$stmt->fetchColumn();
}

function getCompletedCount(PDO $db): int
{
    $stmt = $db->query('SELECT COUNT(*) FROM todos WHERE done = 1 AND deleted_at IS NULL');
    return (int)$stmt->fetchColumn();
}

function checkTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $stmt = $db->prepare('UPDATE todos SET done = 1, updated_at = :updated_at WHERE id = :id');
    $stmt->bindParam(':updated_at', $date);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function unCheckTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $stmt = $db->prepare('UPDATE todos SET done = 0, updated_at = :updated_at WHERE id = :id');
    $stmt->bindParam(':updated_at', $date);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteTodo(PDO $db, int $id): void
{
    $date = date('Y-m-d H:i:s');
    $stmt = $db->prepare('UPDATE todos SET deleted_at = :deleted_at WHERE id = :id');
    $stmt->bindParam(':deleted_at', $date);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}