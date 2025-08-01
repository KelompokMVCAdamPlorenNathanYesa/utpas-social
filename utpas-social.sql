-- Tabel Academic Events
CREATE TABLE academic_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    prodi TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Data awal (seeding) untuk Academic Events
INSERT INTO academic_events (title, description, event_date, prodi) VALUES
('Deadline Tugas Besar PW I', 'Batas akhir pengumpulan proyek akhir Pemrograman Web I.', '2025-08-31 23:59:59', 'Informatika'),
('Ujian Akhir Semester Kalkulus I', 'UAS untuk mata kuliah Kalkulus I.', '2025-08-15 08:00:00', 'Informatika'),
('Seminar Nasional Ekonomi', 'Seminar terbuka untuk seluruh mahasiswa, khususnya prodi Manajemen.', '2025-08-20 10:00:00', 'Manajemen');
