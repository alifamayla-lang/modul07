-- Smart Traffic Finder - CodeIgniter 3 database setup
-- Jalankan file ini di phpMyAdmin atau MySQL CLI.

CREATE DATABASE IF NOT EXISTS `smart_traffic`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `smart_traffic`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `telepon` VARCHAR(20) DEFAULT '-',
  `lokasi` VARCHAR(100) DEFAULT '-',
  `status` VARCHAR(100) DEFAULT 'Pengguna Aktif',
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `laporan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_pelapor` VARCHAR(100) NOT NULL,
  `lokasi` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `foto` VARCHAR(255) NOT NULL DEFAULT '',
  `waktu_laporan` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_verifikasi` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `verified_by` VARCHAR(100) DEFAULT NULL,
  `verified_at` DATETIME DEFAULT NULL,
  `catatan_admin` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_laporan_waktu` (`waktu_laporan`),
  KEY `idx_laporan_pelapor` (`nama_pelapor`),
  KEY `idx_laporan_status` (`status_verifikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_messages_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `laporan_id` INT(11) NOT NULL,
  `user_nama` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_likes_laporan_user` (`laporan_id`, `user_nama`),
  KEY `idx_likes_laporan` (`laporan_id`),
  CONSTRAINT `fk_likes_laporan`
    FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `laporan_id` INT(11) NOT NULL,
  `user_nama` VARCHAR(100) NOT NULL,
  `komentar` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_comments_laporan` (`laporan_id`),
  CONSTRAINT `fk_comments_laporan`
    FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User default:
-- Email: admin@smarttraffic.id
-- Password: admin123
INSERT INTO `users` (`nama_lengkap`, `email`, `password`, `role`) VALUES
('Administrator', 'admin@smarttraffic.id', '$2y$10$67D028TMUPduol3pDWHGNOOusx4WH4u85Veo9RWUOkgot30xU4.t2', 'admin')
ON DUPLICATE KEY UPDATE
  `password` = VALUES(`password`),
  `role` = VALUES(`role`);
