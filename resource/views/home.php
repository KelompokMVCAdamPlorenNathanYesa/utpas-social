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
    <header>
        <?php include __DIR__ . "/components/navbar.php"; ?>
    </header>
    <div class="max-w-4xl mx-auto py-10">
        <div class="flex justify-end mb-6">
            <form action="/logout" method="GET">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <h1 class="text-4xl font-bold text-center mb-8 text-blue-600">Forum Diskusi</h1>

        <?php foreach ($posts as $post): ?>
            <div class="bg-white rounded-xl shadow p-6 mb-6 hover:shadow-lg transition">
                <!-- Header -->
                <div class="flex items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($post->user()['name']) ?>&background=random" 
                         class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($post->user()['name']) ?></h3>
                        <p class="text-sm text-gray-500">@<?= htmlspecialchars($post->user()['username']) ?></p>
                    </div>
                </div>

                <!-- Caption -->
                <p class="text-gray-800 text-lg mb-3"><?= htmlspecialchars($post->caption) ?></p>

                <!-- Photos -->
                <?php $photos = $post->photos(); ?>
                <?php if (!empty($photos)): ?>
                    <div class="flex gap-2 mb-4">
                        <?php foreach ($photos as $photo): ?>
                            <img src="/uploads/<?= htmlspecialchars($photo['photo']) ?>" 
                                 class="w-24 h-24 object-cover rounded-lg">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Footer -->
                <div class="flex items-center justify-between text-sm text-gray-600 border-t pt-4">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1">
                            <i class="bi bi-heart-fill text-red-500"></i> <?= $post->post_like ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="bi bi-chat-left-text-fill text-blue-500"></i> <?= count($post->comments()) ?> Komentar
                        </span>
                    </div>
                    <button class="text-blue-500 hover:underline flex items-center gap-1">
                        <i class="bi bi-arrow-right-circle"></i> Lihat Detail
                    </button>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    
        <?php include __DIR__ . "/components/footer.php"; ?>
</body>
</html>
