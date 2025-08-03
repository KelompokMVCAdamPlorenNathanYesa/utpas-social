<?php

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/Controller.php';

class UserController extends Controller {
    
    public function index() {
        $users = User::all();

        self::view('user/index', ['users' => $users]);
    }
}