-- Tabel Users
-- JANGAN DIHAPUS UNTUK REFERENSI.. BUAT .sql baru saja 
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    username TEXT UNIQUE,
    email TEXT UNIQUE,
    status TEXT,
    password TEXT,
    unique_number TEXT UNIQUE,
    fakultas TEXT,
    prodi TEXT
);

-- Tabel Posts 
CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    caption TEXT,
    post_like INTEGER DEFAULT 0, 
    user_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabel Post Photos
CREATE TABLE post_photos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    photo TEXT,
    post_id INTEGER,
    FOREIGN KEY (post_id) REFERENCES posts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabel Post Comments
CREATE TABLE post_comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    comment TEXT,
    post_id INTEGER,
    user_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabel Post Likes
CREATE TABLE post_likes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    user_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(post_id, user_id)
);

-- Tabel Courses
CREATE TABLE courses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    description TEXT
);
CREATE TABLE announcements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    course_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    content TEXT,
    event_date DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);


-- Tabel Discussion Threads
CREATE TABLE discussion_threads (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    user_id INTEGER NOT NULL,
    course_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Tabel Discussion Posts (balasan)
CREATE TABLE discussion_posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    content TEXT NOT NULL,
    user_id INTEGER NOT NULL,
    thread_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES discussion_threads(id) ON DELETE CASCADE
);

-- Tabel Learning Resources
CREATE TABLE learning_resources (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    type TEXT CHECK( type IN ('file', 'link') ) NOT NULL,
    file_path TEXT,
    link_url TEXT,
    course_id INTEGER,
    user_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);
-- Tabel Academic Events
CREATE TABLE academic_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    prodi TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE group_finder_posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    contact TEXT NOT NULL,
    course_id INTEGER,
    user_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO courses (id, name, description) VALUES
-- IT
(1, 'Pemrograman Web', 'Belajar dasar-dasar PHP & HTML'),
(2, 'Struktur Data', 'Mengenal struktur data dasar seperti linked list'),
(3, 'Matematika Kalkulus', 'Turunan dan integral dasar'),
(4, 'Algoritma dan Pemrograman', 'Dasar-dasar algoritma dan logika pemrograman'),
(5, 'Basis Data', 'Konsep database relasional dan SQL'),
(6, 'Jaringan Komputer', 'Pengenalan jaringan dan protokol TCP/IP'),
(7, 'Pemrograman Berorientasi Objek', 'Belajar OOP dengan Java'),
(8, 'Sistem Operasi', 'Konsep multitasking, proses, dan manajemen memori'),
(9, 'Keamanan Siber', 'Dasar keamanan jaringan dan enkripsi'),
(10, 'Machine Learning Dasar', 'Konsep supervised dan unsupervised learning'),
(11, 'Cloud Computing', 'Pengenalan komputasi awan dan layanan seperti AWS'),

-- Manajemen
(12, 'Manajemen Sumber Daya Manusia', 'Strategi mengelola tenaga kerja di organisasi'),
(13, 'Manajemen Pemasaran', 'Strategi pemasaran dan perilaku konsumen'),
(14, 'Manajemen Keuangan', 'Dasar-dasar akuntansi dan laporan keuangan'),
(15, 'Manajemen Operasi', 'Mengelola proses produksi dan distribusi barang'),
(16, 'Perilaku Organisasi', 'Studi tentang perilaku manusia dalam organisasi'),
(17, 'Kepemimpinan dan Pengambilan Keputusan', 'Teori kepemimpinan dan pengambilan keputusan efektif'),
(18, 'Etika Bisnis', 'Etika dan tanggung jawab sosial dalam bisnis'),
(19, 'Kewirausahaan', 'Dasar-dasar memulai dan mengelola bisnis'),
(20, 'Manajemen Proyek', 'Teknik merencanakan, melaksanakan, dan mengendalikan proyek'),
(21, 'Strategi Bisnis', 'Analisis SWOT dan perencanaan strategis perusahaan'),

-- DKV
(22, 'Dasar Desain Grafis', 'Pengenalan prinsip desain grafis dan komposisi visual'),
(23, 'Tipografi', 'Dasar-dasar pemilihan dan penggunaan huruf'),
(24, 'Ilustrasi Digital', 'Teknik menggambar digital dengan perangkat lunak'),
(25, 'Fotografi Dasar', 'Teknik dasar pengambilan gambar dan komposisi'),
(26, 'Animasi 2D', 'Dasar pembuatan animasi menggunakan frame dan keyframe'),
(27, 'Desain UI/UX', 'Prinsip antarmuka pengguna dan pengalaman pengguna'),
(28, 'Branding dan Identitas Visual', 'Membangun citra dan karakter visual merek'),
(29, 'Desain Media Interaktif', 'Merancang media interaktif berbasis web atau aplikasi'),
(30, 'Seni Rupa Kontemporer', 'Kajian seni rupa modern dan aplikasinya dalam desain'),
(31, 'Motion Graphic', 'Membuat animasi bergerak untuk keperluan presentasi dan promosi'),

-- Bahasa Inggris
(32, 'Basic English Grammar', 'Struktur kalimat, tenses, dan parts of speech'),
(33, 'English Conversation', 'Latihan berbicara dalam bahasa Inggris sehari-hari'),
(34, 'Listening Comprehension', 'Meningkatkan pemahaman terhadap percakapan berbahasa Inggris'),
(35, 'Academic Writing', 'Menulis esai dan laporan dalam bahasa Inggris formal'),
(36, 'Reading for Understanding', 'Teknik membaca untuk memahami teks akademik'),
(37, 'TOEFL Preparation', 'Persiapan menghadapi ujian TOEFL'),
(38, 'Pronunciation Practice', 'Latihan pengucapan dan intonasi bahasa Inggris'),
(39, 'Business English', 'Bahasa Inggris untuk keperluan bisnis dan korespondensi'),
(40, 'English for Tourism', 'Kosakata dan percakapan untuk dunia pariwisata'),
(41, 'Creative Writing', 'Menulis cerita fiksi dan non-fiksi dalam bahasa Inggris');

ALTER TABLE academic_events ADD COLUMN submission_link TEXT;
ALTER TABLE academic_events ADD COLUMN contact_info TEXT;