<?php
require_once __DIR__ . '/../Model/AcademicEvent.php';
require_once __DIR__ . '/Controller.php';

class AcademicCalendarController extends Controller
{

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userProdi = $_SESSION['user']['prodi'];

        $academicEventInstance = new AcademicEvent(); 

        $pdo = AcademicEvent::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM academic_events WHERE prodi = :prodi OR prodi IS NULL ORDER BY event_date");
        $stmt->execute(['prodi' => $userProdi]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($results as $row) {
            $obj = new AcademicEvent();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $events[] = $obj;
        }

        self::view('academic-calendar/index', ['events' => $events]);
    }
  
    public function createForm()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || ($_SESSION['user']['status'] !== 'admin' && $_SESSION['user']['status'] !== 'dosen')) {
            $_SESSION['error'] = 'Anda tidak memiliki hak akses untuk halaman ini!';
            header('Location: /academic-calendar');
            exit;
        }

        self::view('academic-calendar/create');
    }

    public function store()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || ($_SESSION['user']['status'] !== 'admin' && $_SESSION['user']['status'] !== 'dosen')) {
            header('Location: /academic-calendar');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $eventDate = trim($_POST['event_date'] ?? '');
        $prodi = trim($_POST['prodi'] ?? '');
        $submissionLink = trim($_POST['submission_link'] ?? '');
        $contactInfo = trim($_POST['contact_info'] ?? '');

        if (empty($title) || empty($eventDate)) {
            $_SESSION['error'] = 'Judul dan tanggal acara wajib diisi!';
            header('Location: /academic-calendar/create');
            exit;
        }

        AcademicEvent::create([
            'title' => $title,
            'description' => $description,
            'event_date' => $eventDate,
            'prodi' => $prodi,
            'submission_link' => $submissionLink,
            'contact_info' => $contactInfo
        ]);

        $_SESSION['success'] = 'Acara baru berhasil ditambahkan!';
        header('Location: /academic-calendar');
        exit;
    }
}