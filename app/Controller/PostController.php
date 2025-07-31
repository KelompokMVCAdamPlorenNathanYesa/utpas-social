<?php
require_once __DIR__ . '/../Model/Post.php';
require_once __DIR__ . '/Controller.php';

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        Controller::view('home', [
            'posts' => $posts
        ]);
    }
     public function toggleLike($postId)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            exit;
        }

        $userId = $_SESSION['user']['id'];


        
        $post = Post::find($postId); 

        $isLiked = $post->isLikedBy($userId);
        $post->toggleLike($userId);

        $newLikeCount = $post->countLikes();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'isLiked' => !$isLiked,
            'newLikeCount' => $newLikeCount
        ]);
        exit;

    echo "postId: " . $postId . ", userId: " . $_SESSION['user']['id'];
    exit;
    }
}
