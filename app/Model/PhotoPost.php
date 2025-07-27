<?php

require_once 'Model.php';
require_once 'Post.php';

class PostPhoto extends Model {
    protected $table = 'post_photos';

    public $id;
    public $photo;
    public $post_id;

    // Relasi: Foto milik Post
    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
