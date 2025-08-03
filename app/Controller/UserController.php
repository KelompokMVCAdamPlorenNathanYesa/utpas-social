<?php

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/Controller.php';

class UserController extends Controller {
    
    public function index() {
        $users = User::all();

        self::view('user/index', ['users' => $users]);
    }
    public function changeStatus() {
        $userId = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$userId || !$status) {
            header('Location: /403');
            exit;
        }
        
        $user = User::find($userId);
        if (!$user) {
            header('Location: /403');
            exit;
        }
        
        $user->status = $status;
        $user->save();

        // ganti seession user 
        if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $userId) {
            $_SESSION['user']['status'] = $status;
        }
        header('Location: /admin/user');
        exit;
    }
}