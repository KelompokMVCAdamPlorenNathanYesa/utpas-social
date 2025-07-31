<?php
require_once __DIR__ . '/../Model/GroupFinderPost.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Course.php';
require_once __DIR__ . '/Controller.php';

class GroupFinderController extends Controller
{
    public function index()
    {
        $posts = GroupFinderPost::all();

        foreach ($posts as $post) {
            $post->user = $post->user();
            $post->course = $post->course();
        }

        self::view('group-finder/index', ['posts' => $posts]);
    }

    public function createForm()
    {
        $courses = Course::all();
        self::view('group-finder/create', ['courses' => $courses]);
    }

    public function store()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $courseId = $_POST['course_id'] ?? null;
        $contact = trim($_POST['contact'] ?? '');

        if (empty($title) || empty($description) || empty($contact)) {
            $_SESSION['error'] = 'Judul, deskripsi, dan kontak wajib diisi!';
            header('Location: /group-finder/create');
            exit;
        }

        GroupFinderPost::create([
            'title' => $title,
            'description' => $description,
            'course_id' => $courseId,
            'user_id' => $userId,
            'contact' => $contact
        ]);

        $_SESSION['success'] = 'Postingan berhasil dibuat!';
        header('Location: /group-finder');
        exit;
    }
}