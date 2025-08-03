<?php
require_once __DIR__ . '/../Model/LearningResource.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Course.php';
require_once __DIR__ . '/Controller.php';

class LearningResourceController extends Controller
{
    public function index()
    {
        $resources = LearningResource::all();

        foreach ($resources as $resource) {
            $resource->user = $resource->user();
            $resource->course = $resource->course();
        }

        self::view('learning-resources/index', ['resources' => $resources]);
    }

    public function createForm()
    {
        $courses = Course::all();
        self::view('learning-resources/create', ['courses' => $courses]);
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
        $type = $_POST['type'] ?? 'file';
        $courseId = $_POST['course_id'] ?? null;
        $filePath = null;
        $linkUrl = null;

        // --- VALIDASI DI SINI ---
        if (empty($title)) {
            $_SESSION['error'] = 'Judul sumber belajar wajib diisi!';
            header('Location: /learning-resources/create');
            exit;
        }
        // --- AKHIR VALIDASI ---

        if ($type === 'file' && isset($_FILES['file'])) {
            $targetDir = __DIR__ . "/../../resource/uploads/";
            $fileName = basename($_FILES["file"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $filePath = $fileName;
            } else {
                $_SESSION['error'] = 'Gagal mengunggah file.';
                header('Location: /learning-resources/create');
                exit;
            }
        } elseif ($type === 'link') {
            $linkUrl = trim($_POST['link_url'] ?? '');
            if (empty($linkUrl)) {
                $_SESSION['error'] = 'URL tautan tidak boleh kosong!';
                header('Location: /learning-resources/create');
                exit;
            }
        }

        // --- PROSES UPLOAD/SIMPAN DI SINI ---
        LearningResource::create([
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'file_path' => $filePath,
            'link_url' => $linkUrl,
            'course_id' => $courseId,
            'user_id' => $userId
        ]);

        $_SESSION['success'] = 'Sumber belajar berhasil dibagikan!';
        header('Location: /learning-resources');
        exit;
    }

        public function download($resourceId)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $resource = LearningResource::find($resourceId);
        if (!$resource || $resource->type !== 'file') {
            header('Location: /404');
            exit;
        }

        $filePath = __DIR__ . "/../../resource/uploads/" . $resource->file_path;
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            flush();
            readfile($filePath);
            exit;
      } else {
            $_SESSION['error'] = 'File tidak ditemukan.';
            header('Location: /learning-resources');
            exit;
        }
    }
}
