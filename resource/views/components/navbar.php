<?php require_once __DIR__ . '/../../../activeClass.php'; ?>

<nav class="bg-purple-800 text-white shadow-md">
  <div class="max-w-6xl mx-auto px-4 flex justify-between items-center h-19">

    <div class="flex items-center space-x-3">
      <img src="/resource/img/logo-utpas.png" class="h-14" alt="Logo UTPAS">
      <span class="font-bold text-2xl sm:block">UTPAS Social</span>
    </div>

    <div class="hidden sm:flex space-x-10 text-3xl">
      <a href="/" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/') ?>">
        <i class="bi bi-house-door-fill"></i>
        <span class="text-sm mt-1">Home</span>
      </a>
      <a href="/forum" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/forum') ?>">
        <i class="bi bi-chat-dots-fill"></i>
        <span class="text-sm mt-1">Prodi</span>
      </a>
      <a href="/gallery" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/gallery') ?>">
        <i class="bi bi-megaphone-fill"></i>
        <span class="text-sm mt-1">Pengumuman</span>
      </a>
      <a href="/group-finder" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/group-finder') ?>">
        <i class="bi bi-people-fill"></i>
        <span class="text-sm mt-1">Kelompok</span>
      </a>
      <a href="/academic-calendar" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/academic-calendar') ?>">
        <i class="bi bi-calendar-event-fill"></i>
        <span class="text-sm mt-1">Akademik</span>
      </a>
      <a href="/learning-resources" class="hover:text-yellow-400 flex flex-col items-center <?= activeClass('/learning-resources') ?>">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span class="text-sm mt-1">Belajar</span>
      </a>

    </div>

    <div class="hidden sm:block relative">
      <button id="profileBtn" class="focus:outline-none flex items-center space-x-3">
        <div class="h-12 w-12 rounded-full bg-yellow-400 text-purple-800 font-bold text-lg flex items-center justify-center">
          <?= strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
        </div>
        <i class="bi bi-caret-down-fill text-lg"></i>
      </button>
      <div id="profileDropdown" class="hidden absolute right-0 mt-4 w-48 bg-white text-gray-800 rounded-lg shadow-lg overflow-hidden text-lg">
        <a href="/profile" class="block px-4 py-3 hover:bg-gray-100 flex items-center">
          <i class="bi bi-person me-2"></i> Lihat Profil
        </a>
        <form action="/logout" method="GET">
          <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 flex items-center">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
          </button>
        </form>
      </div>
    </div>

    <div class="sm:hidden">
      <button id="menuBtn" class="text-4xl focus:outline-none">
        <i class="bi bi-list"></i>
      </button>
    </div>
  </div>

  <div id="mobileMenu" class="hidden sm:hidden bg-purple-700 text-white px-6 py-4 space-y-4 text-xl">
    <a href="/" class="block hover:text-yellow-400 <?= activeClass('/') ?>"><i class="bi bi-house-door-fill me-2"></i> Home</a>
    <a href="/forum" class="block hover:text-yellow-400 <?= activeClass('/forum') ?>"><i class="bi bi-chat-dots-fill me-2"></i> Forum</a>
    <a href="/gallery" class="block hover:text-yellow-400 <?= activeClass('/gallery') ?>"><i class="bi bi-images me-2"></i> Gallery</a>
    <a href="/group-finder" class="block hover:text-yellow-400 <?= activeClass('/group-finder') ?>"><i class="bi bi-people-fill me-2"></i> Rekan Kelompok</a>
    <a href="/academic-calendar" class="block hover:text-yellow-400 <?= activeClass('/academic-calendar') ?>"><i class="bi bi-calendar-event-fill me-2"></i> Kalender Akademik</a>
    <a href="/learning-resources" class="block hover:text-yellow-400 <?= activeClass('/learning-resources') ?>"><i class="bi bi-journal-bookmark-fill me-2"></i> Sumber Belajar</a>

    <hr class="border-gray-500">
    <a href="/profile" class="block hover:text-yellow-400"><i class="bi bi-person me-2"></i> Lihat Profil</a>
    <form action="/logout" method="GET">
      <button type="submit" class="w-full text-left hover:text-yellow-400 flex items-center">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </button>
    </form>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');

  menuBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    mobileMenu.classList.toggle('hidden');
  });

  profileBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('hidden');
  });

  document.addEventListener('click', () => {
    profileDropdown?.classList.add('hidden');
    mobileMenu?.classList.add('hidden');
  });
});
</script>
