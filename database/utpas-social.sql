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
    post_id INTEGER    user_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(post_id, user_id)
);

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
    course_id INTEGER NOT NUL
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

ALTER TABLE academic_events ADD COLUMN submission_link TEXT;
ALTER TABLE academic_events ADD COLUMN contact_info TEXT;

INSERT INTO academic_events (title, description, event_date, prodi, submission_link, contact_info) VALUES
('Kuis Bab 3 Struktur Data', 'Kuis online di platform E-learning kampus.', '2025-08-25 10:00:00', 'Informatika', 'https://elearning.utpas.ac.id/mod/quiz', 'Pengerjaan kuis pada jam mata kuliah.'),
('Pengumpulan Laporan Akhir Jaringan Komputer', 'Pengumpulan hardcopy laporan di meja dosen.', '2025-08-28 17:00:00', 'Informatika', NULL, 'Meja Dosen Budi, Ruang 301 Gedung FTI.'),
('Acara UKM Fotografi', 'Pameran hasil karya foto anggota UKM Fotografi.', '2025-09-01 10:00:00', NULL, NULL, 'Gedung Serbaguna Kampus.');
