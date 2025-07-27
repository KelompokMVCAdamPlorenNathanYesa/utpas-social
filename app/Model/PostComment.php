<?php

require_once 'Model.php';
require_once 'Post.php';
require_once 'User.php';

class PostComment extends Model {
    protected $table = 'post_comments';

    public $id;
    public $comment;
    public $post_id;
    public $user_id;

    // Relasi: Komentar milik Post
    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    // Relasi: Komentar milik User
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
