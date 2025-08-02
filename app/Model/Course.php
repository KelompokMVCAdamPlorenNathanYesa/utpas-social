<?php
require_once 'Model.php';
require_once 'Announcement.php';

class Course extends Model {
    protected $table = 'courses';

    public $id;
    public $name;
    public $description;

    public function threads() {
        return $this->hasMany('DiscussionThread', 'course_id', 'id');
    }
    public function announcements() {
        return $this->hasMany('Announcement', 'course_id', 'id');
    }
}