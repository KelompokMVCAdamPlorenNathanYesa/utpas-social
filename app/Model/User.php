<?php

require_once 'Model.php';

class User extends Model{
    protected $table = 'users';

    public $id;
    public $name;
    public $username;

    public function posts() {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public static function findByUsername($username)
    {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}` WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findByEmail($email)
    {
        $instance = new static();
        $stmt = self::$pdo->prepare("SELECT * FROM `{$instance->table}` WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}