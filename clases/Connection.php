<?php
class Connection {
    protected $pdo;

    public function __construct() {
        $conf = json_decode(file_get_contents(__DIR__ . '/../conf.json'), true);
        $dsn = "mysql:host={$conf['host']};dbname={$conf['dbname']};charset=utf8";
        try {
            $this->pdo = new PDO($dsn, $conf['user'], $conf['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
