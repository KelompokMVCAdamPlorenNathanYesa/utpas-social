<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manajemen User - Utpas Social</title>
  <link rel="stylesheet" href="/resource/css/app.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>
  <style>
    :root {
      --primary-color: #6D28D9; 
      --secondary-color: #FACC15; 
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

<?php include __DIR__ . "/../components/navbar.php"; ?>

<main class="max-w-6xl mx-auto py-10 px-4 min-h-screen">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-[var(--primary-color)]">Manajemen Pengguna</h1>
  </div>

  <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-200">
    <table class="min-w-full text-sm text-left">
      <thead class="bg-[var(--secondary-color)] text-gray-900 uppercase text-xs font-semibold tracking-wider">
        <tr>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Nama</th>
          <th class="px-4 py-3">Username</th>
          <th class="px-4 py-3">Email</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Unique #</th>
          <th class="px-4 py-3">Fakultas</th>
          <th class="px-4 py-3">Prodi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php foreach ($users as $user): ?>
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3"><?= htmlspecialchars($user->id) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->name) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->username) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->email) ?></td>
          <td class="px-4 py-3">
            <form action="/admin/user/change-status" method="POST">
              <input type="hidden" name="id" value="<?= $user->id ?>">
              <select name="status" onchange="this.form.submit()" class="bg-gray-100 border border-gray-300 text-sm rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
                <option value="mahasiswa" <?= $user->status === 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                <option value="admin" <?= $user->status === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="dosen" <?= $user->status === 'dosen' ? 'selected' : '' ?>>Dosen</option>
              </select>
            </form>
          </td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->unique_number) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->fakultas) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($user->prodi) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include __DIR__ . "/../components/footer.php"; ?>
<script src="../../resource/js/flashMsg.js"></script>
</body>
</html>
