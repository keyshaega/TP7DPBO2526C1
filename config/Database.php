<?php
class Database {
    private string $host = "localhost";
    private string $db_name = "db_bakery";
    private string $username = "root";
    private string $password = "";
    private ?PDO $connection = null;

    public function connect(): PDO {
        if ($this->connection === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return $this->connection;
    }
}
