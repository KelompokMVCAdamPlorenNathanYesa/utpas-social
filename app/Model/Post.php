<?php

require_once 'Model.php';
require_once 'User.php';
require_once 'PhotoPost.php';
require_once 'PostComment.php';

class Post extends Model {
    protected $table = 'posts';

    public $id;
    public $caption;
    public $post_like;
    public $user_id;

    // Relasi: Post milik User
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi: Post punya banyak Foto
    public function photos() {
        return $this->hasMany(PostPhoto::class, 'post_id', 'id');
    }

    // Relasi: Post punya banyak Komentar
    public function comments() {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }
}