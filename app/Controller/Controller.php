<?php

class Controller{

    /*
    * Ini view sejatinya berada di resource/views
    * Jadi kita bisa memanggilnya dengan view('home');
    * OR dashboard/index
    * dan mengirimkan data di param 2
    * Contoh: view('home', ['posts' => $posts]);
    * 'post' untuk di view phpnya $posts dari variable di atasnya 
    * $posts = Post::all();
    *    Controller::view('home',[
    *       'posts' => $posts
    *    ]);  
    *    contoh di atas ini dari postController.php
    * Jadi $post mengambil data semua dari table posts 
    * dan diteruskan oleh 'posts' di view php 
    */
    public static function view($view, $data = []){
        extract($data);
        include_once __DIR__ . "/../../resource/views/{$view}.php";
    }
}