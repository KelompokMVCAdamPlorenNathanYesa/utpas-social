<?php

require_once "./worker.php";
require_once "app/Controller/PostController.php";
require_once "app/Model/Post.php";

$postController = new PostController();

Route::get('/', [$postController, 'index']);