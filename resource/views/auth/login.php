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
    <title>Login - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <style>
        body {
            background: url('/resource/img/pendopo.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            background-color: rgba(14, 9, 18, 0.8);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans relative">

<!-- Overlay warna ungu -->
<div class="overlay absolute inset-0"></div>

<!-- Card Ungu -->
<div class="relative bg-purple-800 text-white shadow-xl rounded-xl w-full max-w-md p-8 z-10 border-t-4 border-yellow-400">
    <div class="text-center mb-6">
        <img src="/resource/img/logo-utpas.png" alt="UTPAS" class="mx-auto h-20 mb-3">
        <h1 class="text-3xl font-bold">Login UTPAS</h1>
        <p class="text-purple-200 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Pesan Error -->
    <?php if ($error): ?>
        <div class="bg-red-600 text-white p-3 rounded mb-4 text-sm text-center">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- Form Login -->
    <form method="POST" action="/login" class="space-y-4">
        <div>
            <input type="text" name="username" placeholder="Username"
                class="w-full px-4 py-2 rounded-lg bg-purple-700 text-white placeholder-gray-300 border border-purple-600 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2 rounded-lg bg-purple-700 text-white placeholder-gray-300 border border-purple-600 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>

        <button type="submit"
            class="w-full bg-yellow-400 hover:bg-purple-500 text-white font-bold py-2 rounded-lg transition border border-yellow-400">
            Login
        </button>
    </form>

    <p class="text-center text-purple-200 text-sm mt-6">
        Belum punya akun?
        <a href="/register" class="text-yellow-400 font-semibold hover:underline">Daftar Sekarang</a>
    </p>
</div>

</body>
</html>
