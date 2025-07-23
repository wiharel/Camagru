<?php

class Database {
    private $host = 'db';
    private $db_name = 'camagru';
    private $username = 'camagru_user';
    private $password = 'camagru_pass';
    public $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }
}
