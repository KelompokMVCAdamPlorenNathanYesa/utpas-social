<?php

require_once 'Model.php';
require_once 'User.php';
require_once 'PhotoPost.php';
require_once 'PostComment.php';
require_once 'PostLike.php';

class Post extends Model {
    protected $table = 'posts';

    public $id;
    public $caption;
    public $user_id;
    public $created_at;

    /**
     * Relasi: Post milik User
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi: Post punya banyak Foto
     */
    public function photos() {
        return $this->hasMany(PostPhoto::class, 'post_id', 'id');
    }

    /**
     * Relasi: Post punya banyak Komentar
     */
    public function comments() {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    /**
     * Relasi: Post punya banyak Likes
     */
    public function likes() {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    /**
     * Hitung jumlah likes
     */
    public function countLikes() {
        return count($this->likes());
    }

    /**
     * Cek apakah user sudah like post ini
     */
    public function isLikedBy($userId) {
        return PostLike::findByPostAndUser($this->id, $userId) !== null;
    }

    /**
     * Toggle Like (Like / Unlike)
     */
    public function toggleLike($userId) {
        if ($this->isLikedBy($userId)) {
            return PostLike::deleteByPostAndUser($this->id, $userId);
        } else {
            return PostLike::create([
                'post_id' => $this->id,
                'user_id' => $userId
            ]);
        }
    }
}
