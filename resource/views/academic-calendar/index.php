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
    <title>Kalender Akademik - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/../components/navbar.php"; ?>

    <main class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-purple-800">Kalender Akademik</h1>
            <?php if ($_SESSION['user']['status'] === 'admin' || $_SESSION['user']['status'] === 'dosen'): ?>
                <a href="/academic-calendar/create" class="px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-yellow-400 hover:text-purple-800 transition-colors duration-300">
                    <i class="bi bi-plus-circle-fill mr-2"></i> Tambah Acara
                </a>
            <?php endif; ?>
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
            <?php if (empty($events)): ?>
                <p class="text-gray-500 text-center">Tidak ada acara akademik yang tersedia untuk prodi Anda.</p>
            <?php else: ?>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $now = new DateTime();
                ?>
                <?php foreach ($events as $event): ?>
                    <?php
                    $eventDate = new DateTime($event->event_date);
                    $isOverdue = $now > $eventDate;
                    ?>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all duration-300 <?= $isOverdue ? 'border-l-4 border-red-500 opacity-70' : 'border-l-4 border-purple-500' ?>">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($event->title) ?></h2>
                                <p class="text-sm text-gray-500">
                                    Prodi: <?= htmlspecialchars($event->prodi) ?? 'Umum' ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-gray-700">
                                    <?= $eventDate->format('d F Y') ?>
                                </span>
                                <p class="text-xs text-gray-500">
                                    Pukul: <?= $eventDate->format('H:i') ?>
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-800 mb-4"><?= htmlspecialchars($event->description) ?></p>

                        <?php if (!empty($event->submission_link)): ?>
                            <a href="<?= htmlspecialchars($event->submission_link) ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-yellow-400 hover:text-purple-800">
                                <i class="bi bi-link-45deg mr-2"></i> Kunjungi Tautan Pengumpulan
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($event->contact_info)): ?>
                            <div class="mt-2 text-sm text-gray-600">
                                <i class="bi bi-info-circle mr-1"></i> Metode Pengumpulan: <?= htmlspecialchars($event->contact_info) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($isOverdue): ?>
                            <div class="mt-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full">
                                    Deadline Sudah Lewat
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . "/../components/footer.php"; ?>

</body>
</html>