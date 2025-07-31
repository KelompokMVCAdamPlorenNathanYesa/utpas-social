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

-- Data awal (seeding) untuk Learning Resources
INSERT INTO learning_resources (title, description, type, file_path, link_url, course_id, user_id) VALUES
('Materi Pertemuan 1 - PHP Dasar', 'Materi PDF untuk pertemuan pertama pemrograman web.', 'file', 'materi-pw1.pdf', NULL, 1, 1),
('Studi Kasus Linked List', 'Tautan ke artikel studi kasus implementasi linked list.', 'link', NULL, 'https://medium.com/linked-list-example', 2, 3),
('Tutorial Turunan Kalkulus', 'Tautan video YouTube tentang turunan dasar.', 'link', NULL, 'https://www.youtube.com/watch?v=turunan', 3, 2);
