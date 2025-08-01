<?php
require_once __DIR__ . '/../Model/DiscussionThread.php';
require_once __DIR__ . '/../Model/DiscussionPost.php';
require_once __DIR__ . '/../Model/Course.php';
require_once __DIR__ . '/Controller.php';

class DiscussionController extends Controller
{
    /**
     * Menampilkan daftar semua mata kuliah
     */
    public function index()
    {
        $courses = Course::all();
        self::view('discussion/index', ['courses' => $courses]);
    }

    public function storeProdi(){
        $namaProdi = $_POST['name'] ?? '';
        $deskripsiProdi = $_POST['description'] ?? '';

        if (empty($namaProdi) || empty($deskripsiProdi)) {
            $_SESSION['error'] = 'Nama mata kuliah tidak boleh kosong!';
            header('Location: /forum');
            exit;
        }

        Course::create([
            'name' => $namaProdi,
            'description' => $deskripsiProdi
        ]);
        $_SESSION['success'] = 'Mata kuliah berhasil ditambahkan!';
        header('Location: /forum');
        exit;
        
    }

    /**
     * Menampilkan daftar thread untuk mata kuliah tertentu
     */
       public function showThreadsForCourse($courseId)
    {
        $course = Course::find($courseId);
        if (!$course) {
            header('Location: /404');
            exit;
        }

        $threads = DiscussionThread::where('course_id', $courseId);

        foreach ($threads as $thread) {
            $thread->user = $thread->user();
        }

        self::view('discussion/threads', [
            'course' => $course,
            'threads' => $threads
        ]);
    }

    /**
     * Menampilkan detail thread dan post di dalamnya
     */
    public function showThreadDetail($threadId)
    {
        $thread = DiscussionThread::find($threadId);
        if (!$thread) {
            header('Location: /404');
            exit;
        }

        $thread->user = $thread->user();
        $posts = $thread->posts();

        foreach ($posts as $post) {
            $post->user = $post->user();
        }

        self::view('discussion/show', [
            'thread' => $thread,
            'posts' => $posts
        ]);
    }

public function createThreadForm($courseId)
{
    $course = Course::find($courseId);
    if (!$course) {
        header('Location: /404');
        exit;
    }
    self::view('discussion/create', ['course' => $course]);
}

public function storeThread()
{
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $courseId = $_POST['course_id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    // Validasi sederhana
    if (!$courseId || empty($title) || empty($content)) {
        // Set error message dan redirect kembali
        $_SESSION['error'] = 'Judul dan konten tidak boleh kosong!';
        header('Location: /forum/' . $courseId);
        exit;
    }

    // Simpan thread baru ke database
    DiscussionThread::create([
        'title' => $title,
        'content' => $content,
        'user_id' => $userId,
        'course_id' => $courseId
    ]);

    $_SESSION['success'] = 'Topik diskusi berhasil dibuat!';
    header('Location: /forum/' . $courseId);
    exit;
}

// ... di dalam class DiscussionController ...

/**
 * Memproses dan menyimpan balasan baru
 */
public function storeReply()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $threadId = $_POST['thread_id'] ?? null;
    $content = trim($_POST['content'] ?? '');

    // Validasi
    if (!$threadId || empty($content)) {
        $_SESSION['error'] = 'Isi balasan tidak boleh kosong!';
        header('Location: /thread/' . $threadId);
        exit;
    }

    // Simpan balasan ke database
    DiscussionPost::create([
        'content' => $content,
        'user_id' => $userId,
        'thread_id' => $threadId
    ]);

    $_SESSION['success'] = 'Balasan berhasil dikirim!';
    header('Location: /thread/' . $threadId);
    exit;
}
}