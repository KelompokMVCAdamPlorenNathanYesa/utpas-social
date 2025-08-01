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
 public static function find($id) {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}` WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika data ditemukan, buat objek baru
        if ($row) {
            $obj = new static();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            return $obj;
        }
        return null; // Jika tidak ditemukan, kembalikan null
    }

    public static function where($column, $value) {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}` WHERE `$column` = :value");
        $stmt->execute(['value' => $value]);
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

    public static function create($data) {
        $instance = new static();
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);
        $sql = "INSERT INTO `{$instance->table}` (" . implode(", ", $columns) . ")
                VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($data);
        return self::$pdo->lastInsertId();
    }

    public static function update($id, $data) {
        $instance = new static();
        $fields = implode(", ", array_map(fn($col) => "`$col` = :$col", array_keys($data)));
        $sql = "UPDATE `{$instance->table}` SET $fields WHERE id = :id";
        $data['id'] = $id;
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public static function delete($id) {
        $instance = new static();
        $stmt = self::$pdo->prepare("DELETE FROM `{$instance->table}` WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function getPdo() {
        return self::$pdo;
    }

    // Relasi One-to-Many
 public function hasMany($relatedClass, $foreignKey, $localKey = 'id') {
    $related = new $relatedClass;
    $stmt = self::$pdo->prepare("SELECT * FROM `{$related->table}` WHERE `$foreignKey` = :value");
    $stmt->execute(['value' => $this->$localKey]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $objects = [];
    foreach ($results as $row) {
        $obj = new $relatedClass;
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        $objects[] = $obj;
    }
    return $objects;
}
    public function belongsTo($relatedClass, $foreignKey, $ownerKey = 'id') {
        $related = new $relatedClass;
        $stmt = self::$pdo->prepare("SELECT * FROM `{$related->table}` WHERE `$ownerKey` = :value LIMIT 1");
        $stmt->execute(['value' => $this->$foreignKey]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $obj = new $relatedClass;
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            return $obj;
        }
        return null;
    }
    public static function with($relations) {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}`");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($rows as $row) {
            $obj = new static();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }

            // Handle relasi eager loading
            foreach ((array)$relations as $relation) {
                if (method_exists($obj, $relation)) {
                    $obj->$relation = $obj->$relation(); 
                }
            }

            $objects[] = $obj;
        }
        return $objects;
    }
    public function save() {
        $data = [];
        foreach ($this->columns as $column) {
            if (isset($this->$column)) {
                $data[$column] = $this->$column;
            }
        }

        if (isset($this->id)) {
            static::update($this->id, $data);
        } else {
            $this->id = static::create($data);
        }
    }

    


}
