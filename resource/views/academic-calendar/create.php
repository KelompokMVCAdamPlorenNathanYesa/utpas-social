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
    <title>Tambah Acara Akademik - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">
    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-xl mx-auto py-8 px-4 min-h-screen">
        <h1 class="text-3xl font-bold mb-6 text-purple-800">Tambah Acara Akademik Baru</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="/academic-calendar/store" method="POST" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Acara</label>
                    <input type="text" id="title" name="title" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2"></textarea>
                </div>
                
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
                    <input type="datetime-local" id="event_date" name="event_date" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi Terkait (opsional)</label>
                    <input type="text" id="prodi" name="prodi" placeholder="Misal: Informatika" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>
                
                <div>
                    <label for="submission_link" class="block text-sm font-medium text-gray-700">Tautan Pengumpulan (opsional)</label>
                    <input type="url" id="submission_link" name="submission_link" placeholder="Contoh: https://elearning.utpas.ac.id/submit" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div>
                    <label for="contact_info" class="block text-sm font-medium text-gray-700">Kontak atau Metode Pengumpulan (opsional)</label>
                    <input type="text" id="contact_info" name="contact_info" placeholder="Contoh: Kirim via email ke dosen@email.com" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-2">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">Tambahkan Acara</button>
                </div>
            </form>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>
</body>
</html>