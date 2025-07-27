<?php

require_once "./worker.php";
require_once "app/Controller/PostController.php";
require_once "app/Controller/AuthController.php";

$postController = new PostController();
$authController = new AuthController();

Route::get('/', [$postController, 'index']);

// Login 
Route::get('/login', [$authController, 'showLoginForm']);
Route::post('/login', [$authController, 'login']);

Route::get('/register', [$authController, 'showRegisterForm']);
Route::post('/register', [$authController, 'register']);

Route::get('/logout', [$authController, 'logout']);
