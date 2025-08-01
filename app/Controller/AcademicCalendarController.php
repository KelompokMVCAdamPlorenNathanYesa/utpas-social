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

        $events = AcademicEvent::where('prodi', $userProdi);
        self::view('academic-calendar/index', ['events' => $events]);
    }
}