<?php
require_once __DIR__ . '/../config/Database.php';

abstract class BaseModel {
    protected PDO $db;
    protected string $table;
    protected array $fillable = [];

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Seluruh operasi database menggunakan prepared statement.
    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $columns = $this->fillable;
        $columnList = implode(', ', $columns);
        $placeholders = implode(', ', array_map(fn($column) => ':' . $column, $columns));
        $sql = "INSERT INTO {$this->table} ({$columnList}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $params = [];
        foreach ($columns as $column) {
            $params[':' . $column] = $data[$column] ?? null;
        }
        return $stmt->execute($params);
    }

    public function update(int $id, array $data): bool {
        if ($this->find($id) === null) {
            return false;
        }

        $setParts = array_map(fn($column) => "{$column} = :{$column}", $this->fillable);
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $params = [':id' => $id];
        foreach ($this->fillable as $column) {
            $params[':' . $column] = $data[$column] ?? null;
        }
        return $stmt->execute($params);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
