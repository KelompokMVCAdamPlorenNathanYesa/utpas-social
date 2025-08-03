<?php

require_once __DIR__ . '/../Model/Announcement.php';
require_once __DIR__ . '/../Model/Course.php';
require_once __DIR__ . '/Controller.php';

class AnnouncementController extends Controller{
    public function index(){
        $announcements = Announcement::orderBy('created_at', 'desc');
        self::view('announcement/index', ['announcements' => $announcements]);
    }

    public function createForm(){
        $course = Course::all(); 
        self::view('announcement/create', ['courses'=> $course]);
    }
    
    public function store(){
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'event_date' => $_POST['event_date'],
            'course_id' => $_POST['course_id']
        ];

        $id = Announcement::create($data);

        if ($id) {
            $_SESSION['success'] = 'Pengumuman berhasil disimpan.';
            header('Location: /announcement');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal menyimpan pengumuman.';
            header('Location: /announcement/create');
            exit;
        }
    }

    public function show($id){
        $announcement = Announcement::find($id);
        if (!$announcement) {
            $_SESSION['error'] = 'Pengumuman tidak ditemukan.';
            header('Location: /announcement');
            exit;
        }

        self::view('announcement/show', ['announcement' => $announcement]);
    }

    public function delete($id){
        $announcement = Announcement::find($id);
        if (!$announcement) {
            $_SESSION['error'] = 'Pengumuman tidak ditemukan.';
            header('Location: /announcement');
            exit;
        }

        Announcement::delete($id);

        $_SESSION['success'] = 'Pengumuman berhasil dihapus.';
        header('Location: /announcement');
        exit;
    }

    public function edit($id){
        $announcement = Announcement::find($id);
        $courses = Course::all();
        if (!$announcement) {
            $_SESSION['error'] = 'Pengumuman tidak ditemukan.';
            header('Location: /announcement');
            exit;
        }

        self::view('announcement/edit', [
            'announcement' => $announcement,
            'courses' => $courses]);
    }
    public function update()
    {
        $id = $_POST['id'] ?? null; 
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $eventDate = $_POST['event_date'] ?? '';
        $courseId = $_POST['course_id'] ?? null;

        if (!$id || !$title || !$content || !$eventDate || !$courseId) {
            $_SESSION['error'] = "Semua field wajib diisi!";
            header("Location: /announcement/edit/$id");
            exit;
        }

        $announcement = Announcement::find($id);
        if (!$announcement) {
            $_SESSION['error'] = "Pengumuman tidak ditemukan!";
            header("Location: /announcement");
            exit;
        }

        $announcement->title = $title;
        $announcement->content = $content;
        $announcement->event_date = $eventDate;
        $announcement->course_id = $courseId;
        $announcement->save();

        header("Location: /announcement");
        exit;
    }

}