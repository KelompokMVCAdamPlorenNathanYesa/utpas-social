<?php
require_once 'Model.php';

class Course extends Model {
    protected $table = 'courses';

    public $id;
    public $name;
    public $description;

    public function threads() {
        return $this->hasMany('DiscussionThread', 'course_id', 'id');
    }
    public function Annoucements() {
        return $this->hasMany('Announcement', 'course_id', 'id');
    }
}