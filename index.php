<?php

require_once "worker.php";
require_once "app/Controller/PostController.php";
require_once "app/Controller/AuthController.php";
require_once "app/Controller/DiscussionController.php";
require_once "app/Controller/GroupFinderController.php"; 
require_once "app/Controller/LearningResourceController.php";
require_once "app/Controller/AcademicCalendarController.php";

$postController = new PostController();
$authController = new AuthController();
$discussionController = new DiscussionController();
$groupFinderController = new GroupFinderController();
$learningResourceController = new LearningResourceController();
$academicCalendarController = new AcademicCalendarController(); 


Route::get('/', function() use ($postController) {
    Middleware::auth();
    $postController->index();
});

Route::post('/post/store', function() use ($postController) {
    Middleware::auth();
    $postController->store();
});
Route::post('/post/comment', function() use ($postController) {
    Middleware::auth();
    $postController->storeComment();
});

Route::post('/post/delete/$id', function($id) use ($postController) {
    Middleware::auth();
    $postController->delete($id);
});
Route::post('/post/update', function () use ($postController) {
    Middleware::auth();
    $postController->update();
});


Route::get('/post/{id}', function($id) use ($postController) {
    Middleware::auth();
    $postController->show($id);
});


//




Route::get('/login', function() use ($authController) {
    Middleware::guest();
    $authController->showLoginForm();
});
Route::post('/login', function() use ($authController) {
    Middleware::guest();
    $authController->login();
});

Route::get('/register', function() use ($authController) {
    Middleware::guest();
    $authController->showRegisterForm();
});
Route::post('/register', function() use ($authController) {
    Middleware::guest();
    $authController->register();
});



Route::get('/forum', function() use ($discussionController) {
    Middleware::auth();
    $discussionController->index();
});
Route::post('/course/prodi', function() use ($discussionController) {
    Middleware::auth();
    $discussionController->storeProdi();
});


Route::get('/forum/$id', function($id) use ($discussionController) {
    Middleware::auth();
    $discussionController->showThreadsForCourse($id);
});





Route::get('/thread/$id', function($id) use ($discussionController) {
    Middleware::auth();
    $discussionController->showThreadDetail($id);
});
Route::get('/logout', function() use ($authController) {
    $authController->logout();
});
Route::get('/forum/$id/create', function($id) use ($discussionController) {
    Middleware::auth();
    $discussionController->createThreadForm($id);
});
Route::get('/profile', function() use ($authController) {
    Middleware::auth();
    $authController->showProfile();
});

Route::post('/profile/delete', function() use ($authController) {
    Middleware::auth();
    $authController->deleteAccount();
});

Route::get('/academic-calendar', function() use ($academicCalendarController) {
    Middleware::auth();
    $academicCalendarController->index();
});
Route::post('/forum/store', function() use ($discussionController) {
    Middleware::auth();
    $discussionController->storeThread();
});
Route::post('/thread/reply/$id', function($id) use ($discussionController) {
    Middleware::auth();
    $discussionController->storeReply();
});

Route::get('/group-finder', function() use ($groupFinderController) {
    Middleware::auth();
    $groupFinderController->index();
});

Route::get('/group-finder/create', function() use ($groupFinderController) {
    Middleware::auth();
    $groupFinderController->createForm();
});

Route::post('/group-finder/store', function() use ($groupFinderController) {
    Middleware::auth();
    $groupFinderController->store();
});
Route::get('/learning-resources', function() use ($learningResourceController) {
    Middleware::auth();
    $learningResourceController->index();
});
Route::get('/academic-calendar/create', function() use ($academicCalendarController) {
    Middleware::auth();
    $academicCalendarController->createForm();
});
Route::get('/learning-resources/create', function() use ($learningResourceController) {
    Middleware::auth();
    $learningResourceController->createForm();
});

Route::post('/learning-resources/store', function() use ($learningResourceController) {
    Middleware::auth();
    $learningResourceController->store();
});

Route::get('/learning-resources/download/$id', function($id) use ($learningResourceController) {
    Middleware::auth();
    $learningResourceController->download($id);
});

Route::get('/404', 'views/404.php');

?>