<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
// Asumsi variabel $thread dan $posts sudah di-set dari controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($thread->title) ?> - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4">
        <a href="/forum/<?= htmlspecialchars($thread->course()->id) ?>" class="text-purple-600 hover:text-purple-800 mb-4 inline-block"><i class="bi bi-arrow-left"></i> Kembali ke Forum</a>

        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold mb-2 text-purple-800"><?= htmlspecialchars($thread->title) ?></h1>
            <div class="flex items-center mb-4 text-sm text-gray-600">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($thread->user()->name) ?>&background=random"
                     class="w-8 h-8 rounded-full mr-2">
                <span>Dibuat oleh <span class="font-semibold"><?= htmlspecialchars($thread->user()->name) ?></span> pada <?= htmlspecialchars($thread->created_at) ?></span>
            </div>
            <p class="text-gray-800"><?= htmlspecialchars($thread->content) ?></p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 text-purple-800">Tambahkan Balasan</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <form action="/thread/reply/<?= htmlspecialchars($thread->id) ?>" method="POST" class="space-y-4">
                <input type="hidden" name="thread_id" value="<?= htmlspecialchars($thread->id) ?>">
                <div>
                    <textarea name="content" rows="4" placeholder="Tulis balasan Anda di sini..." required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">Kirim Balasan</button>
                </div>
            </form>
        </div>

        <h2 class="text-xl font-bold mb-4 text-purple-800">Balasan (<?= count($posts) ?>)</h2>
        <div class="space-y-4">
            <?php if (empty($posts)): ?>
                <p class="text-gray-500">Belum ada balasan. Jadilah yang pertama!</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center mb-2 text-sm text-gray-600">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($post->user()->name) ?>&background=random"
                                 class="w-6 h-6 rounded-full mr-2">
                            <span>Oleh <span class="font-semibold"><?= htmlspecialchars($post->user()->name) ?></span> pada <?= htmlspecialchars($post->created_at) ?></span>
                        </div>
                        <p class="text-gray-800"><?= htmlspecialchars($post->content) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>