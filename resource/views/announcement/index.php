<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$user = $_SESSION['user'] ?? null;

unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50">

<?php include __DIR__ . "/../components/navbar.php"; ?>

<main class="p-6 max-w-4xl mx-auto min-h-screen space-y-10">
    <?php if ($success): ?>
        <div id="flash-message" class="bg-green-500 text-white px-4 py-3 rounded-md shadow-md transition-opacity duration-500">
            <?= htmlspecialchars($success) ?>
        </div>
        <script src="../../resource/js/flashMsg.js"></script>
    <?php endif; ?>

    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pengumuman</h1>
        <?php if ($user && ($user['status'] ?? '') === 'admin'): ?>
            <a href="/announcement/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition-all duration-200">
                <i class="bi bi-plus-circle"></i> Buat Pengumuman
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($announcements)): ?>
        <p class="text-gray-500 italic mt-4">Belum ada pengumuman yang tersedia.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($announcements as $announcement): ?>
                <div class="relative bg-white shadow-md rounded-xl p-5 border border-gray-200 hover:shadow-lg transition-all">
                    <div class="flex justify-between items-start">
                        <a href="/announcement/show/<?= $announcement->id ?>" class="group">
                            <h2 class="text-xl font-semibold text-blue-700 mb-1 group-hover:underline">
                                <?= htmlspecialchars($announcement->title) ?>
                            </h2>
                        </a>
                        <?php if ($user && ($user['status'] ?? '') === 'admin'): ?>
                        <div class="relative">
                            <button type="button" class="text-gray-500 hover:text-gray-800 focus:outline-none" onclick="toggleDropdown(this)">
                                &#8942;
                            </button>
                            <div class="dropdown-menu hidden absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                <a href="/announcement/edit/<?= $announcement->id ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                <form method="POST" action="/announcement/delete/<?= $announcement->id ?>" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php
                        $maxLength = 200;
                        $content = htmlspecialchars($announcement->content);
                        $isLong = strlen($content) > $maxLength;
                        $preview = $isLong ? mb_substr($content, 0, $maxLength) . '...' : $content;
                    ?>
                    <p class="text-gray-700 mb-2"><?= nl2br($preview) ?></p>

                    <?php if ($isLong): ?>
                        <span class="text-blue-600 text-sm font-semibold inline-flex items-center gap-1">
                            Lanjut Membaca <i class="bi bi-arrow-right"></i>
                        </span>
                    <?php endif; ?>

                    <?php if (isset($announcement->course_id)): ?>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="bi bi-book-fill"></i>
                            Mata Kuliah: <span class="font-medium"><?= htmlspecialchars($announcement->course()->name ?? 'Tidak diketahui') ?></span>
                        </p>
                    <?php endif; ?>

                    <p class="text-sm text-gray-400 mt-1">
                        <i class="bi bi-clock"></i>
                        Dibuat pada: <?= date('d M Y, H:i', strtotime($announcement->created_at)) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<script>
    function toggleDropdown(button) {
        const menu = button.nextElementSibling;
        menu.classList.toggle('hidden');

        // Tutup semua dropdown lain
        document.querySelectorAll('.dropdown-menu').forEach(el => {
            if (el !== menu) el.classList.add('hidden');
        });
    }

    window.addEventListener('click', function (e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.dropdown-menu').forEach(el => el.classList.add('hidden'));
        }
    });
</script>


<?php include __DIR__ . "/../components/footer.php"; ?>
</body>
</html>
