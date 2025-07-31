<?php
require_once 'Model.php';
require_once 'User.php';
require_once 'Course.php';

class LearningResource extends Model {
    protected $table = 'learning_resources';

    public $id;
    public $title;
    public $description;
    public $type;
    public $file_path;
    public $link_url;
    public $course_id;
    public $user_id;
    public $created_at;

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function course() {
        return $this->belongsTo('Course', 'course_id');
    }
}