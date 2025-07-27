<?php

class Model {
    protected static $pdo;
    protected $table;
    protected $columns = [];

    public function __construct() {
        if (!self::$pdo) {
            $this->connect();
        }

        if (!$this->table) {
            $this->table = strtolower(get_class($this)) . 's';
        }

        $this->loadColumns();
    }

    protected function connect() {
        $dbPath = realpath(__DIR__ . '/../../database/database.db');

        if (!$dbPath) {
            throw new Exception("Database file not found.");
        }

        $dsn = "sqlite:$dbPath";
        self::$pdo = new PDO($dsn);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function loadColumns() {
        $stmt = self::$pdo->prepare("PRAGMA table_info(`{$this->table}`);");
        $stmt->execute();
        $this->columns = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'name');
    }

    public function getColumns() {
        return $this->columns;
    }

    public static function all() {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}`");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($results as $row) {
            $obj = new static();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $objects[] = $obj;
        }
        return $objects;
    }



    public static function getPdo() {
        return self::$pdo;
    }

    // Relasi One-to-Many
    public function hasMany($relatedClass, $foreignKey, $localKey = 'id') {
        $related = new $relatedClass;
        $stmt = self::$pdo->prepare("SELECT * FROM `{$related->table}` WHERE `$foreignKey` = :value");
        $stmt->execute(['value' => $this->$localKey]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Relasi Many-to-One
    public function belongsTo($relatedClass, $foreignKey, $ownerKey = 'id') {
        $related = new $relatedClass;
        $stmt = self::$pdo->prepare("SELECT * FROM `{$related->table}` WHERE `$ownerKey` = :value LIMIT 1");
        $stmt->execute(['value' => $this->$foreignKey]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
