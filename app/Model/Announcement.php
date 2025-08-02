<?php
require_once 'Model.php';

class Announcement extends Model {
    protected $table = 'announcements';

    public $id;
    public $course_id;
    public $title;
    public $content;
    public $created_at; 
    public $event_date;

    public function course(){
        return $this->belongsTo('Course', 'course_id');
    }
}