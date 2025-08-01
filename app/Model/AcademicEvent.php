<?php
require_once 'Model.php';

class AcademicEvent extends Model {
    protected $table = 'academic_events';

    public $id;
    public $title;
    public $description;
    public $event_date;
    public $prodi;
    public $created_at;
}