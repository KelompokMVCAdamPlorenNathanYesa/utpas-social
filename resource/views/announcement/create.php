<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="">
<?php include __DIR__ . "/../components/navbar.php"; ?>


<main class="min-h-screen bg-gray-50 p-6">

        
    <form action="/announcement/store" method="POST" class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-lg space-y-4">
        <?php if ($error): ?>
            <div class="bg-red-600 text-white p-4 rounded mb-6" id="flash-message">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <h1 class="text-2xl font-bold text-purple-700 mb-4">Buat Pengumuman</h1>

        <div>
            <label for="title" class="block font-semibold text-purple-700 mb-1">Judul Pengumuman</label>
            <input
                type="text"
                name="title"
                placeholder="Judul Pengumuman"
                class="w-full p-3 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                required>
        </div>

        <div>
            <label for="content" class="block font-semibold text-purple-700 mb-1">Isi Pengumuman</label>
            <textarea
                name="content"
                rows="5"
                placeholder="Isi Pengumuman"
                class="w-full p-3 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 h-48"
                required></textarea>
        </div>

        <div>
            <label for="event_date" class="block font-semibold text-purple-700 mb-1">Tanggal Mulai</label>
            <input
                type="datetime-local"
                name="event_date"
                class="w-full p-3 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                required>
        </div>

        <div>
            <label for="course" class="block font-semibold text-purple-700 mb-1">Mata Kuliah</label>
            <select
                name="course_id"
                id="course"
                class="w-full p-3 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                required>
                <option value="0" disabled selected>Pilih Matakuliah</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course->id ?>"><?= htmlspecialchars($course->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-right">
            <button
                type="submit"
                class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded-lg transition-all duration-200 cursor-pointer">
                Simpan
            </button>
            <a href="/announcement" class="ml-2 text-yellow-400 hover:text-yellow-300 font-semibold">
                Batal
            </a>
        </div>
    </form>

</main>

<script src="../../resource/js/flashMsg.js"></script>

<?php include __DIR__ . "/../components/footer.php"; ?>
</body>
</html>
