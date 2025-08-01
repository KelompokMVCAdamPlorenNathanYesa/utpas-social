<?php

require_once __DIR__ . '/../Model/Announcement.php';
require_once __DIR__ . '/Controller.php';

class AnnouncementController extends Controller{
    public function index(){
        $announcements = Announcement::all();
        self::view('announcement/index', ['announcements' => $announcements]);
    }
}