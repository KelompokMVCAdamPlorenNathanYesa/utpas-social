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
    <title>Profil <?= htmlspecialchars($user['name']) ?> - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <?php include __DIR__ . "/components/navbar.php"; ?>

    <main class="max-w-xl mx-auto py-8 px-4">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col items-center mb-6">
                <div class="flex flex-col items-center mb-6">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&size=128&background=random"
                        class="w-32 h-32 rounded-full border-4 border-purple-400 mb-4">
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($user['name']) ?></h1>
                    <p class="text-gray-600">@<?= htmlspecialchars($user['username']) ?></p>
                    <p class="text-gray-600 font-semibold mt-1">Status: <span class="text-purple-800"><?= htmlspecialchars(ucfirst($user['status'])) ?></span></p>
                </div>
                <p class="text-gray-600">@<?= htmlspecialchars($user['username']) ?></p>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Email</p>
                    <p class="text-lg text-gray-800"><?= htmlspecialchars($user['email']) ?></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500">Nomor Unik (NIM/NIP)</p>
                    <p class="text-lg text-gray-800"><?= htmlspecialchars($user['unique_number']) ?></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500">Fakultas</p>
                    <p class="text-lg text-gray-800"><?= htmlspecialchars($user['fakultas']) ?></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500">Program Studi</p>
                    <p class="text-lg text-gray-800"><?= htmlspecialchars($user['prodi']) ?></p>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end space-x-4">
                <a href="/logout" class="px-4 py-2 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition-colors duration-300">
                    <i class="bi bi-box-arrow-right mr-2"></i> Logout
                </a>
                <form action="/profile/delete" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.');">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300">
                        <i class="bi bi-trash-fill mr-2"></i> Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . "/components/footer.php"; ?>

</body>
</html>