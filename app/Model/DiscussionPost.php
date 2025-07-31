<?php
require_once 'Model.php';
require_once 'User.php';
require_once 'DiscussionThread.php';

class DiscussionPost extends Model {
    protected $table = 'discussion_posts';

    public $id;
    public $content;
    public $user_id;
    public $thread_id;
    public $created_at;

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function thread() {
        return $this->belongsTo('DiscussionThread', 'thread_id');
    }
}