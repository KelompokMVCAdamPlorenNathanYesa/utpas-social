-- Tabel Users
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

<<<<<<< HEAD
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



-- Seed awal (kamu bisa sesuaikan ID user & course sesuai data nyata)
INSERT INTO users (id, name, username, email, status, password, unique_number, fakultas, prodi) VALUES
(1, 'Adam Wahyu', 'adam', 'adam@example.com', 'active', 'password_hash_1', 'UN001', 'FTI', 'TI'),
(2, 'Ayu Lestari', 'ayu', 'ayu@example.com', 'active', 'password_hash_2', 'UN002', 'FTI', 'SI'),
(3, 'Budi Santoso', 'budi', 'budi@example.com', 'active', 'password_hash_3', 'UN003', 'FTI', 'MI');

INSERT INTO courses (id, name, description) VALUES
(1, 'Pemrograman Web', 'Belajar dasar-dasar PHP & HTML'),
(2, 'Struktur Data', 'Mengenal struktur data dasar seperti linked list'),
(3, 'Matematika Kalkulus', 'Turunan dan integral dasar');

INSERT INTO learning_resources (title, description, type, file_path, link_url, course_id, user_id) VALUES
('Materi Pertemuan 1 - PHP Dasar', 'Materi PDF untuk pertemuan pertama pemrograman web.', 'file', 'materi-pw1.pdf', NULL, 1, 1),
('Studi Kasus Linked List', 'Tautan ke artikel studi kasus implementasi linked list.', 'link', NULL, 'https://medium.com/linked-list-example', 2, 3),
('Tutorial Turunan Kalkulus', 'Tautan video YouTube tentang turunan dasar.', 'link', NULL, 'https://www.youtube.com/watch?v=turunan', 3, 2);
=======
-- Data awal (seeding) untuk Academic Events
INSERT INTO academic_events (title, description, event_date, prodi) VALUES
('Deadline Tugas Besar PW I', 'Batas akhir pengumpulan proyek akhir Pemrograman Web I.', '2025-08-31 23:59:59', 'Informatika'),
('Ujian Akhir Semester Kalkulus I', 'UAS untuk mata kuliah Kalkulus I.', '2025-08-15 08:00:00', 'Informatika'),
('Seminar Nasional Ekonomi', 'Seminar terbuka untuk seluruh mahasiswa, khususnya prodi Manajemen.', '2025-08-20 10:00:00', 'Manajemen');
>>>>>>> 1a24370 (Kalender Akademik & Profile)
