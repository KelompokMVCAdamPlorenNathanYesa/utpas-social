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

-- Seed Users
INSERT INTO users (name, username, email, status, password, unique_number, fakultas, prodi) VALUES
('Adam', 'adam123', 'adam@example.com', 'active', 'pass', 'UNQ001', 'Teknik', 'Informatika'),
('Nathan', 'nathan', 'nathan@example.com', 'active', 'pass', 'UNQ002', 'Ekonomi', 'Manajemen'),
('Ploren', 'ploren', 'ploren@example.com', 'inactive', 'pass', 'UNQ003', 'Hukum', 'Ilmu Hukum'),
('Yesa', 'yesa', 'yesa@example.com', 'inactive', 'pass', 'UNQ004', 'Hukum', 'Ilmu Hukum');

-- Seed Posts (dengan created_at otomatis)
INSERT INTO posts (caption, post_like, user_id) VALUES
-- Adam (id = 1)
('Posting 1 dari Adam', 5, 1),
('Posting 2 dari Adam', 3, 1),
('Posting 3 dari Adam', 7, 1),
('Posting 4 dari Adam', 2, 1),
('Posting 5 dari Adam', 9, 1),

-- Nathan (id = 2)
('Posting 1 dari Nathan', 4, 2),
('Posting 2 dari Nathan', 6, 2),
('Posting 3 dari Nathan', 8, 2),
('Posting 4 dari Nathan', 1, 2),
('Posting 5 dari Nathan', 5, 2),

-- Ploren (id = 3)
('Posting 1 dari Ploren', 2, 3),
('Posting 2 dari Ploren', 3, 3),
('Posting 3 dari Ploren', 6, 3),
('Posting 4 dari Ploren', 7, 3),
('Posting 5 dari Ploren', 10, 3),

-- Yesa (id = 4)
('Posting 1 dari Yesa', 1, 4),
('Posting 2 dari Yesa', 4, 4),
('Posting 3 dari Yesa', 6, 4),
('Posting 4 dari Yesa', 8, 4),
('Posting 5 dari Yesa', 9, 4);

-- Seed Post Photos
INSERT INTO post_photos (photo, post_id) VALUES
('default.png', 1), ('default.png', 2), ('default.png', 3), ('default.png', 4), ('default.png', 5),
('default.png', 6), ('default.png', 7), ('default.png', 8), ('default.png', 9), ('default.png', 10),
('default.png', 11), ('default.png', 12), ('default.png', 13), ('default.png', 14), ('default.png', 15),
('default.png', 16), ('default.png', 17), ('default.png', 18), ('default.png', 19), ('default.png', 20);

-- Seed Post Comments
INSERT INTO post_comments (comment, post_id, user_id) VALUES
('Keren banget!', 1, 2),
('Mantap postingannya', 1, 3),
('Belajar SQL itu asik!', 2, 4),
('Postingan bagus', 3, 1),
('Wah mantap!', 5, 2),
('Informasi bermanfaat', 10, 3),
('Foto bagus banget', 11, 4),
('Mantap tipsnya', 15, 2),
('Setuju banget nih', 18, 1),
('Konten luar biasa', 20, 3);

-- Seed Post Likes
INSERT INTO post_likes (post_id, user_id) VALUES
(1, 2), (1, 3), (1, 4),   -- Post 1 Adam disukai Nathan, Ploren, Yesa
(2, 3), (2, 4),           -- Post 2 Adam disukai Ploren, Yesa
(3, 1), (3, 2),           -- Post 3 Adam disukai Adam, Nathan
(5, 2),                   -- Post 5 Adam disukai Nathan
(10, 3),                  -- Post 10 Nathan disukai Ploren
(11, 4),                  -- Post 11 Ploren disukai Yesa
(15, 2),                  -- Post 15 Ploren disukai Nathan
(18, 1),                  -- Post 18 Yesa disukai Adam
(20, 3);                  -- Post 20 Yesa disukai Ploren
