<?php

class Model {
    protected static $pdo;
    protected $table;
    protected $columns = [];

    public function __construct() {
        if (!self::$pdo) {
            $this->connect();
        }
        // ex: class post table posts 
        
        if (!$this->table) {
            $this->table = strtolower(get_class($this)) . 's';
        }

        $this->loadColumns();
    }

    /**
     * Connect ke database SQLite
     */
    protected function connect() {
        $dbPath = realpath(__DIR__ . '/../../database/database.db');

        if (!$dbPath) {
            throw new Exception("Database file not found.");
        }

        $dsn = "sqlite:$dbPath";
        self::$pdo = new PDO($dsn);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Load nama-nama kolom dari tabel
     */
    protected function loadColumns() {
        $stmt = self::$pdo->prepare("PRAGMA table_info(`{$this->table}`);");
        $stmt->execute();

        $this->columns = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
    }

    /**
     * Ambil semua nama kolom
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * Ambil semua data dari tabel
     */
    public function all() {
        $stmt = self::$pdo->prepare("SELECT * FROM `{$this->table}`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Dapatkan instance PDO
     */
    public static function getPdo() {
        return self::$pdo;
    }
}
