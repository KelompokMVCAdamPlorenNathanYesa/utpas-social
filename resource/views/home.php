<?php
session_start();
$userId = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utpas Social</title>
    <link rel="stylesheet" href="/resource/css/app.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <header>
        <?php include __DIR__ . "/components/navbar.php"; ?>
    </header>

    <!-- Konten Utama -->
    <main class="max-w-4xl mx-auto py-8 px-4">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
            <div class="flex items-center gap-4 mb-3">
                <!-- Avatar -->
                <div class="h-12 w-12 rounded-full bg-yellow-400 text-purple-800 font-bold flex items-center justify-center text-lg">
                    <?= strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
                </div>
                <!-- Trigger Modal -->
                <button id="openPostModal" class="flex-1 text-left bg-gray-100 rounded-full px-4 py-2 text-gray-500 hover:bg-gray-200">
                    Mau Tanya Sesuatu, <?= htmlspecialchars($_SESSION['user']['name']); ?>?
                </button>
            </div>
        </div>

        <!-- Modal Post -->
        <div id="postModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative">
                <!-- Tombol Close -->
                <button id="closePostModal" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-2xl">
                    <i class="bi bi-x-circle-fill"></i>
                </button>

                <h2 class="text-xl font-bold mb-4 text-purple-800">Buat Postingan</h2>
                
                <form action="/post/create" method="POST" enctype="multipart/form-data" id="postForm">
                    <!-- Avatar + Name -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-full bg-yellow-400 text-purple-800 font-bold flex items-center justify-center text-lg">
                            <?= strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
                        </div>
                        <span class="font-semibold"><?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                    </div>

                    <!-- Caption -->
                    <textarea name="caption" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 mb-4" placeholder="Apa yang Anda pikirkan?"></textarea>
                    
                    <!-- Upload -->
                    <label class="block text-purple-700 cursor-pointer mb-4 flex items-center gap-2">
                        <i class="bi bi-image-fill text-xl"></i> Tambah Foto
                        <input type="file" name="photos[]" id="photoInput" class="hidden" multiple accept="image/*">
                    </label>

                    <!-- Preview Gambar -->
                    <div id="previewContainer" class="grid grid-cols-3 gap-3 mb-4 hidden"></div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3">
                        <button type="button" id="closePostModalBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-purple-700 text-white hover:bg-yellow-400 hover:text-purple-800">Post</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Post List -->
        <?php foreach ($posts as $post): ?>
            <div class="bg-white rounded-2xl shadow-md p-6 mb-6 hover:shadow-xl transition-all duration-300">
                <!-- Header Post -->
                <div class="flex items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($post->user()['name']) ?>&background=random"
                        class="w-12 h-12 rounded-full border-2 border-blue-400 mr-4">
                    <div>
                        <h3 class="font-semibold text-lg text-gray-900">
                            <?= htmlspecialchars($post->user()['name']) ?>
                        </h3>
                        <p class="text-sm text-gray-500">
                            @<?= htmlspecialchars($post->user()['username']) ?>
                        </p>
                    </div>
                </div>

                <!-- Caption Post -->
                <p class="text-gray-800 text-base mb-4 leading-relaxed">
                    <?= htmlspecialchars($post->caption) ?>
                </p>

                <!-- Semua Foto Postingan -->
                <?php $photos = $post->photos(); ?>
                <?php if (!empty($photos)): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                        <?php foreach ($photos as $photo): ?>
                            <img src="/resource/uploads/<?= htmlspecialchars($photo['photo']) ?>"
                                class="w-full h-40 object-cover rounded-xl shadow cursor-pointer post-image" />
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Footer/Post Actions -->
                <div class="flex items-center justify-between text-sm text-gray-600 border-t pt-4">
                    <div class="flex items-center gap-6">
                        <!-- Tombol Like -->
                        <button 
                            class="like-btn flex items-center gap-2 text-gray-700 hover:text-red-500 <?= $post->isLikedBy($userId) ? 'text-red-500' : '' ?>" 
                            data-post-id="<?= $post->id ?>">
                            <i class="bi bi-heart-fill"></i> <span class="like-count"><?= $post->countLikes() ?></span>
                        </button>

                        <!-- Komentar -->
                        <button class="flex items-center gap-2 text-gray-700 hover:text-blue-500">
                            <i class="bi bi-chat-left-text-fill"></i> <?= count($post->comments()) ?> Komentar
                        </button>
                    </div>
                    <a href="/post?id=<?= $post->id ?>" class="text-blue-600 hover:text-yellow-400 flex items-center gap-1 font-semibold">
                        <i class="bi bi-arrow-right-circle"></i> Lihat Detail
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . "/components/footer.php"; ?>

    <!-- Modal Full Image -->
    <div id="imageModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
        <div class="relative max-w-4xl max-h-[90vh]">
            <button id="closeImageModal" class="absolute top-4 right-4 text-white text-3xl hover:text-red-500">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <img id="modalImage" src="" class="max-h-[90vh] max-w-full rounded-lg shadow-lg" alt="Full Image">
        </div>
    </div>

    <!-- Script Modal & Preview & Like -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const openBtn = document.getElementById('openPostModal');
        const closeBtns = [document.getElementById('closePostModal'), document.getElementById('closePostModalBtn')];
        const modal = document.getElementById('postModal');
        const photoInput = document.getElementById('photoInput');
        const previewContainer = document.getElementById('previewContainer');

        // Open modal post
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        // Close modal post
        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                previewContainer.innerHTML = '';
                previewContainer.classList.add('hidden');
                photoInput.value = '';
            });
        });

        // Close modal when click outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                previewContainer.innerHTML = '';
                previewContainer.classList.add('hidden');
                photoInput.value = '';
            }
        });

        // Preview images
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

        // Modal Full Image
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeImageModal = document.getElementById('closeImageModal');
        const postImages = document.querySelectorAll('.post-image');

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
    </script>

</body>
</html>
