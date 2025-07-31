<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}
// Asumsi variabel $courses sudah di-set dari controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Postingan Pencarian Kelompok - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-purple-800">Buat Postingan Pencarian Kelompok</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="/group-finder/store" method="POST" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Postingan</label>
                    <input type="text" id="title" name="title" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Kebutuhan</label>
                    <textarea id="description" name="description" rows="4" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2"></textarea>
                </div>

                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Mata Kuliah (opsional)</label>
                    <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= htmlspecialchars($course->id) ?>"><?= htmlspecialchars($course->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700">Kontak (Email/WhatsApp)</label>
                    <input type="text" id="contact" name="contact" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">Buat Postingan</button>
                </div>
            </form>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>