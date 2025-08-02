<?php 
session_start();
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

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-4" id="flash-message">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>


        <?php if ($_SESSION['user']['status'] == 'admin'): ?>
            <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-purple-800">Pilih Mata Kuliah</h1>
            <button id="openModalBtn" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> Tambah
            </button>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($courses as $course): ?>
                <a href="/forum/<?= htmlspecialchars($course->id) ?>" class="block bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all duration-300">
                    <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($course->name) ?></h2>
                    <p class="text-gray-600 mt-2"><?= htmlspecialchars($course->description) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modal -->
     <?php if ($_SESSION['user']['status'] == 'admin'): ?>
        <div id="courseModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden items-center justify-center z-50">
            <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6 relative">
                <h2 class="text-xl font-bold mb-4 text-purple-800">Tambah Mata Kuliah</h2>
                <form action="/course/prodi" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block font-semibold mb-1">Nama Mata Kuliah</label>
                        <input type="text" id="name" name="name" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div>
                        <label for="description" class="block font-semibold mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-600"></textarea>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" id="closeModalBtn" class="px-4 py-2 text-gray-600 hover:text-black">Batal</button>
                        <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php include __DIR__ . "/../components/footer.php"; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('courseModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        });
    });
    </script>
<script src="../../resource/js/flashMsg.js"></script>
</body>
</html>
