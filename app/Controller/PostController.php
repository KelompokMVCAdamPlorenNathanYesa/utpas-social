<?php

require_once __DIR__ . '/../Model/Post.php';
require_once __DIR__ . '/Controller.php';


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        Controller::view('home',[
            'posts' => $posts
        ]);   
    }
}
