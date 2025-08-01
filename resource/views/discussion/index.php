<?php 
// Pastikan sesi sudah dimulai
session_start();
// Pastikan user sudah login
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
    <title>Forum Diskusi - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4 min-h-screen">
        <h1 class="text-3xl font-bold mb-6 text-purple-800">Pilih Mata Kuliah</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($courses as $course): ?>
                <a href="/forum/<?= htmlspecialchars($course->id) ?>" class="block bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all duration-300">
                    <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($course->name) ?></h2>
                    <p class="text-gray-600 mt-2"><?= htmlspecialchars($course->description) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>