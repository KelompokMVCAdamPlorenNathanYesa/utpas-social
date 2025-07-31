<?php
require_once 'Model.php';
require_once 'User.php';
require_once 'Course.php';

class GroupFinderPost extends Model {
    protected $table = 'group_finder_posts';

    public $id;
    public $title;
    public $description;
    public $course_id;
    public $user_id;
    public $contact;
    public $created_at;

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function course() {
        return $this->belongsTo('Course', 'course_id');
    }
}