<?php

require_once "./worker.php";
require_once "app/Controller/PostController.php";
require_once "app/Controller/AuthController.php";

$postController = new PostController();
$authController = new AuthController();

Route::get('/', function() use ($postController) {
    // make middleware kaya gini - Cek di worker.php
    Middleware::auth();
    $postController->index();
});


// Login-Things
Route::get('/login', function() use ($authController) {
    Middleware::guest();
    $authController->showLoginForm();
});

Route::post('/login', [$authController, 'login']);

Route::get('/register', function() use ($authController) {
    Middleware::guest();
    $authController->showRegisterForm();
});

Route::post('/register', [$authController, 'register']);

// Logout
Route::get('/logout', [$authController, 'logout']);
