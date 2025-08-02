<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($announcement->title) ?> - Detail Pengumuman</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main class="max-w-4xl mx-auto p-6 min-h-screen">
    <a href="/announcement" class="inline-flex items-center text-blue-600 hover:underline mb-6">
        <i class="bi bi-arrow-left mr-2"></i> Kembali ke daftar pengumuman
    </a>

    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-blue-700 mb-2"><?= htmlspecialchars($announcement->title) ?></h1>

        <p class="text-sm text-gray-400 mb-4">
            <i class="bi bi-clock"></i> 
            Dibuat pada: <?= date('d M Y, H:i', strtotime($announcement->created_at)) ?>
        </p>

        <?php if ($announcement->event_date): ?>
            <p class="text-sm text-red-500 mb-4">
                <i class="bi bi-calendar-event"></i> Tanggal Acara: <?= date('d M Y', strtotime($announcement->event_date)) ?>
            </p>
        <?php endif; ?>

        <?php if (isset($announcement->course_id)): ?>
            <p class="text-sm text-gray-500 mb-4">
                <i class="bi bi-book-fill"></i>
                Mata Kuliah:
                <span class="font-medium"><?= htmlspecialchars($announcement->course()?->name ?? 'Tidak diketahui') ?></span>
            </p>
        <?php endif; ?>

        <div class="text-gray-800 leading-relaxed whitespace-pre-line">
            <?= nl2br(htmlspecialchars($announcement->content)) ?>
        </div>
    </div>
</main>

</body>
</html>
