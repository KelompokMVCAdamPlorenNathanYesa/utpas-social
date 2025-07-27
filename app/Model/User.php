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
}