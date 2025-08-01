<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userId = $_SESSION['user']['id'] ?? null;
if (!$userId) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

<header>
    <?php include __DIR__ . "/components/navbar.php"; ?>
</header>

<main class="max-w-4xl mx-auto py-8 px-4 min-h-screen">
    <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
        <div class="flex items-center gap-4 mb-3">
            <div class="h-12 w-12 rounded-full bg-yellow-400 text-purple-800 font-bold flex items-center justify-center text-lg">
                <?= strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
            </div>
            <button id="openPostModal" class="flex-1 text-left bg-gray-100 rounded-full px-4 py-2 text-gray-500 hover:bg-gray-200">
                Mau Tanya Sesuatu, <?= htmlspecialchars($_SESSION['user']['name']); ?>?
            </button>
        </div>
    </div>

    <div id="postModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative">
            <button id="closePostModal" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl">
                <i class="bi bi-x-circle-fill"></i>
            </button>

            <h2 class="text-xl font-bold mb-4 text-purple-800">Buat Postingan</h2>

            <form action="/post/store" method="POST" enctype="multipart/form-data" id="postForm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 rounded-full bg-yellow-400 text-purple-800 font-bold flex items-center justify-center text-lg">
                        <?= strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
                    </div>
                    <span class="font-semibold"><?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                </div>

                <textarea name="caption" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 mb-4" placeholder="Apa yang Anda pikirkan?"></textarea>

                <label class="block text-purple-700 cursor-pointer mb-4 flex items-center gap-2">
                    <i class="bi bi-image-fill text-xl"></i> Tambah Foto
                    <input type="file" name="photos[]" id="photoInput" class="hidden" multiple accept="image/*">
                </label>

                <div id="previewContainer" class="grid grid-cols-3 gap-3 mb-4 hidden"></div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="closePostModalBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-lg bg-purple-700 text-white hover:bg-yellow-400 hover:text-purple-800">Post</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Post here  -->
    <?php foreach ($posts as $post): ?>
        <?php
            $comments = $post->comments();
            $totalComments = count($comments);
            $maxCommentsToShow = 5;
            $showMore = $totalComments > $maxCommentsToShow;
            $visibleComments = array_slice($comments, 0, $maxCommentsToShow);
        ?>
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center mb-4 justify-between">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($post->user->name ?? 'User') ?>&background=random"
                        class="w-12 h-12 rounded-full border-2 border-blue-400 mr-4">
                    <div>
                        <h3 class="font-semibold text-lg text-gray-900"><?= htmlspecialchars($post->user->name ?? 'User') ?></h3>
                        <p class="text-sm text-gray-500">@<?= htmlspecialchars($post->user->username ?? '-') ?></p>
                    </div>
                </div>
                <?php if ($post->user_id == $_SESSION['user']['id']): ?>
                    <div class="relative inline-block text-left">
                        <button type="button" class="text-gray-600 hover:text-gray-800 text-xl" onclick="toggleDropdown(<?= $post->id ?>)">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div id="dropdown-<?= $post->id ?>" class="absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg hidden">
                            <button onclick="openEditModal(<?= $post->id ?>, '<?= htmlspecialchars(addslashes($post->caption)) ?>')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Edit</button>
                            <form action="/post/delete/<?= $post->id ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <p class="text-gray-800 text-base mb-4 leading-relaxed"><?= htmlspecialchars($post->caption) ?></p>

            <?php $photos = $post->photos(); ?>
            <?php if (!empty($photos)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                    <?php foreach ($photos as $photo): ?>
                        <img src="/resource/uploads/post/<?= htmlspecialchars($photo->photo) ?>"
                            class="w-full h-40 object-cover rounded-xl shadow cursor-pointer post-image" />
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="border-t pt-4 mt-4 text-sm text-gray-600">
                <!-- Komentar -->
                <div class="mt-4">
                    <?php if (!empty($visibleComments)): ?>
                        <div class="space-y-4 mb-4" id="comments-container-<?= $post->id ?>">
                            <?php foreach ($visibleComments as $comment): ?>
                                <div class="flex items-start gap-3">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($comment->user()->name ?? 'U') ?>&background=random"
                                        class="w-9 h-9 rounded-full border border-gray-300">
                                    <div class="bg-gray-100 p-3 rounded-xl shadow text-sm w-full">
                                        <p class="font-semibold text-purple-700"><?= htmlspecialchars($comment->user()->name ?? 'User') ?></p>
                                        <p class="text-gray-800"><?= htmlspecialchars($comment->comment) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($showMore): ?>
                        <div id="hidden-comments-<?= $post->id ?>" class="space-y-4 mb-4 hidden">
                            <?php foreach (array_slice($comments, $maxCommentsToShow) as $comment): ?>
                                <div class="flex items-start gap-3">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($comment->user()->name ?? 'U') ?>&background=random"
                                        class="w-9 h-9 rounded-full border border-gray-300">
                                    <div class="bg-gray-100 p-3 rounded-xl shadow text-sm w-full">
                                        <p class="font-semibold text-purple-700"><?= htmlspecialchars($comment->user()->name ?? 'User') ?></p>
                                        <p class="text-gray-800"><?= htmlspecialchars($comment->comment) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button onclick="toggleComments(<?= $post->id ?>)"
                            class="text-sm text-blue-600 hover:text-yellow-500 mt-2"
                            id="toggle-btn-<?= $post->id ?>">
                            Tampilkan semua komentar (<?= $totalComments ?>)
                        </button>
                    <?php endif; ?>

                    <!-- Form Komentar -->
                    <form action="/post/comment" method="POST" class="flex items-start gap-3 mt-2">
                        <input type="hidden" name="post_id" value="<?= $post->id ?>">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name']) ?>&background=random"
                            class="w-9 h-9 rounded-full border border-gray-300">
                        <textarea name="comment" rows="1" required placeholder="Tulis komentar..."
                            class="flex-1 resize-none border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"></textarea>
                        <button type="submit" class="bg-purple-600 hover:bg-yellow-400 hover:text-purple-800 text-white rounded-lg px-4 py-2 text-sm font-medium transition">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


</main>

<?php include __DIR__ . "/components/footer.php"; ?>

<div id="imageModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="relative max-w-4xl max-h-[90vh]">
        <button id="closeImageModal" class="absolute top-4 right-4 text-white text-3xl hover:text-red-500">
            <i class="bi bi-x-circle-fill"></i>
        </button>
        <img id="modalImage" src="" class="max-h-[90vh] max-w-full rounded-lg shadow-lg" alt="Full Image">
    </div>
</div>

<div id="editPostModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl">
            <i class="bi bi-x-circle-fill"></i>
        </button>

        <h2 class="text-xl font-bold mb-4 text-purple-800">Edit Postingan</h2>

        <form action="/post/update" method="POST">
            <input type="hidden" name="post_id" id="editPostId">
            <textarea name="caption" id="editCaption" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 mb-4"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-6 py-2 rounded-lg bg-purple-700 text-white hover:bg-yellow-400 hover:text-purple-800">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>

function toggleComments(postId) {
    const hidden = document.getElementById('hidden-comments-' + postId);
    const toggleBtn = document.getElementById('toggle-btn-' + postId);

    if (hidden.classList.contains('hidden')) {
        hidden.classList.remove('hidden');
        toggleBtn.textContent = 'Sembunyikan komentar';
    } else {
        hidden.classList.add('hidden');
        toggleBtn.textContent = 'Tampilkan semua komentar';
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openPostModal');
    const closeBtns = [document.getElementById('closePostModal'), document.getElementById('closePostModalBtn')];
    const modal = document.getElementById('postModal');
    const photoInput = document.getElementById('photoInput');
    const previewContainer = document.getElementById('previewContainer');

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            previewContainer.innerHTML = '';
            previewContainer.classList.add('hidden');
            photoInput.value = '';
        });
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            previewContainer.innerHTML = '';
            previewContainer.classList.add('hidden');
            photoInput.value = '';
        }
    });

    photoInput.addEventListener('change', (e) => {
        const files = e.target.files;
        previewContainer.innerHTML = '';
        if (files.length > 0) {
            previewContainer.classList.remove('hidden');
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'w-full h-32 object-cover rounded-lg shadow';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    const postImages = document.querySelectorAll('.post-image');
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const closeImageModal = document.getElementById('closeImageModal');

    postImages.forEach(img => {
        img.addEventListener('click', () => {
            modalImage.src = img.src;
            imageModal.classList.remove('hidden');
            imageModal.classList.add('flex');
        });
    });

    closeImageModal.addEventListener('click', () => {
        imageModal.classList.add('hidden');
        imageModal.classList.remove('flex');
    });

    imageModal.addEventListener('click', (e) => {
        if (e.target === imageModal) {
            imageModal.classList.add('hidden');
            imageModal.classList.remove('flex');
        }
    });
});

function toggleDropdown(postId) {
    const dropdown = document.getElementById(`dropdown-${postId}`);
    dropdown.classList.toggle('hidden');

    // Tutup dropdown lain
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
        if (el.id !== `dropdown-${postId}`) el.classList.add('hidden');
    });

    const button = event.target.closest('button'); // tombol yang diklik

    document.addEventListener('click', function handler(e) {
        // Jangan tutup kalau klik masih di dalam dropdown atau tombol titik tiga
        if (!dropdown.contains(e.target) && !button.contains(e.target)) {
            dropdown.classList.add('hidden');
            document.removeEventListener('click', handler);
        }
    });
}

//good luck
function openEditModal(postId, caption) {
    document.getElementById('editPostId').value = postId;
    document.getElementById('editCaption').value = caption;
    document.getElementById('editPostModal').classList.remove('hidden');
    document.getElementById('editPostModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editPostModal').classList.add('hidden');
    document.getElementById('editPostModal').classList.remove('flex');
}

</script>
</body>
</html>
