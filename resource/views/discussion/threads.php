<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskusi <?= htmlspecialchars($course->name) ?> - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4 min-h-screen">

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-4" id="flash-message">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <a href="/forum" class="text-purple-600 hover:text-purple-800 mb-4 inline-block"><i class="bi bi-arrow-left"></i> Kembali ke Forum</a>
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-purple-800">Forum: <?= htmlspecialchars($course->name) ?></h1>
            <a href="/forum/<?= htmlspecialchars($course->id) ?>/create" class="px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">
                <i class="bi bi-plus-circle-fill mr-2"></i> Buat Topik Baru
            </a>
        </div>
        <p class="text-gray-600 mt-2 mb-6"><?= htmlspecialchars($course->description) ?></p>

        <div class="space-y-4">
            <?php if (empty($threads)): ?>
                <p class="text-gray-500 text-center">Belum ada topik diskusi di mata kuliah ini. Jadilah yang pertama!</p>
            <?php else: ?>
                <?php foreach ($threads as $thread): ?>
                    <a href="/thread/<?= htmlspecialchars($thread->id) ?>" class="block bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($thread->title) ?></h2>
                            <span>Dibuat oleh: <?= htmlspecialchars($thread->user->name) ?></span>
                        </div>
                        <p class="text-gray-700 line-clamp-2"><?= htmlspecialchars($thread->content) ?></p>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>
<script src="../../resource/js/flashMsg.js"></script>
</body>
</html>