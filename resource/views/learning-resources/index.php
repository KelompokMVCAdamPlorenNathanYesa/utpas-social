<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
// Asumsi variabel $resources sudah di-set dari controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumber Belajar - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-purple-800">Sumber Belajar</h1>
            <a href="/learning-resources/create" class="px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">
                <i class="bi bi-upload mr-2"></i> Tambah Sumber Belajar
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if (empty($resources)): ?>
                <p class="text-gray-500 text-center">Belum ada sumber belajar yang dibagikan.</p>
            <?php else: ?>
                <?php foreach ($resources as $resource): ?>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($resource->title) ?></h2>
                                <p class="text-sm text-gray-500">
                                    Mata Kuliah: <?= htmlspecialchars($resource->course()->name) ?? 'Umum' ?>
                                </p>
                            </div>
                            <span class="text-sm text-gray-500"><?= htmlspecialchars($resource->created_at) ?></span>
                        </div>
                        <p class="text-gray-800 mb-4"><?= htmlspecialchars($resource->description) ?></p>

                        <div class="flex items-center text-sm text-gray-600">
                            <i class="bi bi-person-circle mr-2"></i>
                            <span class="font-semibold">Dibagikan oleh: <?= htmlspecialchars($resource->user()->name) ?></span>
                        </div>
                        <div class="mt-4">
                            <?php if ($resource->type === 'file'): ?>
                                <a href="/learning-resources/download/<?= htmlspecialchars($resource->id) ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-yellow-400 hover:text-purple-800">
                                    <i class="bi bi-download mr-2"></i> Unduh File
                                </a>
                            <?php elseif ($resource->type === 'link'): ?>
                                <a href="<?= htmlspecialchars($resource->link_url) ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-400 hover:bg-purple-600">
                                    <i class="bi bi-box-arrow-up-right mr-2"></i> Kunjungi Tautan
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>