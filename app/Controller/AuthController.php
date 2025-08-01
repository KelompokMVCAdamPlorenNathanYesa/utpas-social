<?php
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/Controller.php';

class AuthController extends Controller
{
    public function showLoginForm()
    {
        Controller::view('auth/login');
    }

    public function login()
    {
        session_start();

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Username dan password wajib diisi!';
            header('Location: /login');
            exit;
        }

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = 'Username atau password salah!';
            header('Location: /login');
            exit;
        }
    }

    public function showRegisterForm()
    {
        Controller::view('auth/register');
    }

    public function register()
    {
        session_start();

        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $unique_number = trim($_POST['unique_number'] ?? '');
        $fakultas = trim($_POST['fakultas'] ?? '');
        $prodi = trim($_POST['prodi'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$name || !$username || !$email || !$password || !$unique_number) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: /register');
            exit;
        }

        if (User::findByUsername($username)) {
            $_SESSION['error'] = 'Username sudah digunakan!';
            header('Location: /register');
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $status = 'active';

        User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'status' => $status,
            'password' => $hashedPassword,
            'unique_number' => $unique_number,
            'fakultas' => $fakultas,
            'prodi' => $prodi
        ]);

        $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
        header('Location: /login');
        exit;
    }
    public function showProfile()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        self::view('profile', ['user' => $user]);
    }
    public function deleteAccount()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        User::delete($userId);

        session_destroy();
        header('Location: /login');
        exit;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
