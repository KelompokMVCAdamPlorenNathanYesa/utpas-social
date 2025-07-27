<?php

require_once __DIR__ . '/../Model/Post.php';

class PostController
{
    public function index()
    {
        $posts = Post::all();
        include_once __DIR__ . '/../../resource/views/home.php';
    }
}
