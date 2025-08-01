<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
// Asumsi variabel $course sudah di-set dari controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Topik Diskusi - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4 min-h-screen">
        <h1 class="text-3xl font-bold mb-6 text-purple-800">Buat Topik Diskusi Baru</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="/forum/store" method="POST" class="space-y-4">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course->id) ?>">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Topik</label>
                    <input type="text" id="title" name="title" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Isi Diskusi</label>
                    <textarea id="content" name="content" rows="6" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">Buat Topik</button>
                </div>
            </form>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>