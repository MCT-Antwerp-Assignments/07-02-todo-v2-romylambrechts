<?php

class Todo
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getTodos(bool $withTrashed = false): array
    {
        if ($withTrashed) {
            $stmt = $this->db->query('SELECT * FROM todos');
        } else {
            $stmt = $this->db->query('SELECT * FROM todos WHERE deleted_at IS NULL');
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(string $text): void
    {
        $text = htmlspecialchars($text);
        $stmt = $this->db->prepare('INSERT INTO todos (text) VALUES (:text)');
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function check(int $id): void
    {
        $date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare('UPDATE todos SET done = 1, updated_at = :updated_at WHERE id = :id');
        $stmt->bindParam(':updated_at', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function uncheck(int $id): void
    {
        $date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare('UPDATE todos SET done = 0, updated_at = :updated_at WHERE id = :id');
        $stmt->bindParam(':updated_at', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare('UPDATE todos SET deleted_at = :deleted_at WHERE id = :id');
        $stmt->bindParam(':deleted_at', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getPendingCount(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) FROM todos WHERE done = 0 AND deleted_at IS NULL');
        return (int)$stmt->fetchColumn();
    }

    public function getCompletedCount(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) FROM todos WHERE done = 1 AND deleted_at IS NULL');
        return (int)$stmt->fetchColumn();
    }
}