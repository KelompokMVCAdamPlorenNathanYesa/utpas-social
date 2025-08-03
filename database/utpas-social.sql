DROP TABLE IF EXISTS post_photos;

-- Buat ulang tabel dengan ON DELETE CASCADE
CREATE TABLE post_photos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    photo TEXT,
    post_id INTEGER,
    user_id INTEGER, -- Tambahkan kolom ini
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
