<?php

require_once 'app/Model/Post.php';
require_once 'app/Model/PhotoPost.php';
require_once 'app/Model/PostComment.php';
require_once 'app/Model/User.php';
require_once __DIR__ . '/Controller.php';

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->user = $post->user();       
            $post->photos = $post->photos();
            $post->user = $post->user();  
        }

        // Urutkan berdasarkan ID descending
        usort($posts, fn($a, $b) => $b->id <=> $a->id);
        self::view('home', ['posts' => $posts]);
    }

    public function store()
    {
        $caption = $_POST['caption'] ?? '';
        $userId = $_SESSION['user']['id'];

        $post = new Post();
        $post->caption = $caption;
        $post->user_id = $userId;
        $post->post_like = 0;
        $post->save();

        // Simpan foto jika ada yang diupload
        if (isset($_FILES['photos']) && $_FILES['photos']['error'][0] === 0) {
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                $fileName = uniqid() . '_' . $_FILES['photos']['name'][$key];
                $destination = 'resource/uploads/post/' . $fileName;
                move_uploaded_file($tmp_name, $destination);

                $photo = new PostPhoto();
                $photo->photo = $fileName;
                $photo->post_id = $post->id;
                $photo->save();
            }
        }

        header('Location: /');
        exit;
    }

   public function storeComment()
    {
        session_start(); 

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            http_response_code(401);
            echo "Unauthorized. Please login first.";
            exit;
        }

        // Ambil data dari form
        $postId = $_POST['post_id'] ?? null;
        $commentText = trim($_POST['comment'] ?? '');

        // Validasi 
        if (!$postId || $commentText === '') {
            http_response_code(400);
            echo "Komentar tidak boleh kosong.";
            exit;
        }

        // Simpan ke database
        $comment = new PostComment();
        $comment->post_id = $postId;
        $comment->user_id = $userId;
        $comment->comment = $commentText;

        $comment->save();

       header("Location: " . $_SERVER['HTTP_REFERER'] . '#post-' . $postId);
        exit;
    }




    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post || $post->user_id != $_SESSION['user']['id']) {
            http_response_code(403);
            echo "Unauthorized or post not found.";
            return;
        }

        $photos = PostPhoto::where('post_id', $id); // Pastikan ini mengembalikan array/iterable

        foreach ($photos as $photo) {
            $path = dirname(__DIR__, 2) . '/resource/uploads/post/' . $photo->photo;

            if (file_exists($path)) {
                unlink($path); // Hapus file dari storage
            }

            PostPhoto::delete($photo->id);
        }

        Post::delete($id);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function update()
    {
        session_start();

        $postId = $_POST['post_id'] ?? null;
        $caption = trim($_POST['caption'] ?? '');
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$postId || $caption === '' || !$userId) {
            http_response_code(400);
            // echo "Data tidak lengkap";
            return;
        }

        $post = Post::find($postId);

        if (!$post || $post->user_id != $userId) {
            http_response_code(403);
            echo "Unauthorized atau post tidak ditemukan.";
            return;
        }

        // Update caption
        $post->caption = $caption;
        $post->save();

        // Redirect kembali
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }



    public function show($id)
    {
        $post = Post::with('user', 'photos', 'comments')->find($id);
        if (!$post) {
            http_response_code(404);
            echo "Post not found.";
            return;
        }

        require 'views/post/show.php';
    }
}
