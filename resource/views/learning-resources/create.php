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
    <title>Tambah Sumber Belajar - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-purple-800">Tambah Sumber Belajar</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="/learning-resources/store" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Sumber Belajar</label>
                    <input type="text" id="title" name="title" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2"></textarea>
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
                    <label class="block text-sm font-medium text-gray-700">Tipe Sumber Belajar</label>
                    <div class="mt-1 flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="file" checked class="form-radio">
                            <span class="ml-2">Unggah File</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="type" value="link" class="form-radio">
                            <span class="ml-2">Tautan Eksternal</span>
                        </label>
                    </div>
                </div>

                <div id="file-upload-section">
                    <label for="file" class="block text-sm font-medium text-gray-700">File</label>
                    <input type="file" id="file" name="file" class="mt-1 block w-full">
                </div>

                <div id="link-url-section" class="hidden">
                    <label for="link_url" class="block text-sm font-medium text-gray-700">URL Tautan</label>
                    <input type="url" id="link_url" name="link_url" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">Bagikan Sumber Belajar</button>
                </div>
            </form>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

    <script>
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const fileSection = document.getElementById('file-upload-section');
        const linkSection = document.getElementById('link-url-section');

        typeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'file') {
                    fileSection.classList.remove('hidden');
                    linkSection.classList.add('hidden');
                } else {
                    fileSection.classList.add('hidden');
                    linkSection.classList.remove('hidden');
                }
            });
        });
    </script>

</body>
</html>