<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
// Asumsi variabel $posts sudah di-set dari controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Kelompok - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-purple-800">Pencarian Rekan Kelompok</h1>
            <a href="/group-finder/create" class="px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">
                <i class="bi bi-plus-circle-fill mr-2"></i> Buat Postingan Baru
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if (empty($posts)): ?>
                <p class="text-gray-500 text-center">Belum ada postingan pencarian kelompok.</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($post->title) ?></h2>
                                <p class="text-sm text-gray-500">
                                    Mata Kuliah: <?= htmlspecialchars($post->course()->name) ?? 'Umum' ?>
                                </p>
                            </div>
                            <span class="text-sm text-gray-500"><?= htmlspecialchars($post->created_at) ?></span>
                        </div>
                        <p class="text-gray-800 mb-4"><?= htmlspecialchars($post->description) ?></p>

                        <div class="flex items-center text-sm text-gray-600">
                            <i class="bi bi-person-circle mr-2"></i>
                            <span class="font-semibold">Diposting oleh: <?= htmlspecialchars($post->user()->name) ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <i class="bi bi-envelope mr-2"></i>
                            <span class="font-semibold">Kontak: <?= htmlspecialchars($post->contact) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>