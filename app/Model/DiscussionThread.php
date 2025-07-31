<?php
require_once 'Model.php';
require_once 'User.php';
require_once 'Course.php';

class DiscussionThread extends Model {
    protected $table = 'discussion_threads';

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $course_id;
    public $created_at;

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function course() {
        return $this->belongsTo('Course', 'course_id');
    }

    public function posts() {
        return $this->hasMany('DiscussionPost', 'thread_id');
    }
}