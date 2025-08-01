<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center bg-gradient-to-r from-purple-900 via-purple-700 to-purple-500
">

<div class="flex w-full max-w-6xl bg-white shadow-lg rounded-xl overflow-hidden">
    <!-- Left Side (Image/Illustration) -->
    <div class="hidden md:flex w-1/2 bg-purple-700 items-center justify-center relative">
        <img src="/resource/img/pendopo.jpg" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-30">
        <div class="relative z-10 text-center text-white px-8">
            <img src="/resource/img/logo-utpas.png" alt="UTPAS" class="mx-auto mb-4 w-28">
            <h2 class="text-3xl font-bold">Selamat Datang di UTPAS</h2>
            <p class="mt-2 text-purple-200">Buat akun dan bergabung bersama komunitas kampus!</p>
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="w-full md:w-1/2 p-10">
        <h2 class="text-3xl font-bold text-purple-800 mb-6">Daftar Akun</h2>
        <div class="border-b-4 border-yellow-400 w-16 mb-6"></div>

        <!-- Form Register -->
        <form method="POST" action="/register" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="name" placeholder="Nama Lengkap"
                class="col-span-2 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="text" name="username" placeholder="Username"
                class="px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="email" name="email" placeholder="Email"
                class="px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="text" name="unique_number" placeholder="Nomor Unik"
                class="px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="text" name="fakultas" placeholder="Fakultas"
                class="px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="text" name="prodi" placeholder="Program Studi"
                class="px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <select name="status" class="col-span-2 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="admin">Admin</option>
                </select>
            <input type="password" name="password" placeholder="Password"
                class="col-span-2 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">

            <!-- Tombol -->
            <button type="submit"
                class="col-span-2 w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 rounded-lg transition mt-4">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-gray-600 text-sm text-center mt-6">
            Sudah punya akun? 
            <a href="/login" class="text-purple-700 font-semibold hover:underline">Login di sini</a>
        </p>
    </div>
</div>

</body>
</html>
