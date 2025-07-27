<?php

require_once 'Model.php';

class PostLike extends Model {
    protected $table = 'post_likes';

    public $id;
    public $post_id;
    public $user_id;
    public $created_at;

    // Cari berdasarkan post & user
    public static function findByPostAndUser($postId, $userId) {
        $stmt = self::getPdo()->prepare("SELECT * FROM post_likes WHERE post_id = :post_id AND user_id = :user_id LIMIT 1");
        $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    // Hapus berdasarkan post & user
    public static function deleteByPostAndUser($postId, $userId) {
        $stmt = self::getPdo()->prepare("DELETE FROM post_likes WHERE post_id = :post_id AND user_id = :user_id");
        return $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
    }
}
