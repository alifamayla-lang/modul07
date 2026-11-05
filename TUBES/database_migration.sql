USE `smart_traffic`;

ALTER TABLE `users`
  ADD COLUMN IF NOT EXISTS `role` ENUM('user','admin') NOT NULL DEFAULT 'user' AFTER `status`;

ALTER TABLE `laporan`
  ADD COLUMN IF NOT EXISTS `status_verifikasi` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'verified' AFTER `waktu_laporan`,
  ADD COLUMN IF NOT EXISTS `verified_by` VARCHAR(100) DEFAULT NULL AFTER `status_verifikasi`,
  ADD COLUMN IF NOT EXISTS `verified_at` DATETIME DEFAULT NULL AFTER `verified_by`,
  ADD COLUMN IF NOT EXISTS `catatan_admin` TEXT DEFAULT NULL AFTER `verified_at`;

ALTER TABLE `laporan`
  MODIFY `status_verifikasi` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending';

ALTER TABLE `laporan`
  ADD INDEX IF NOT EXISTS `idx_laporan_status` (`status_verifikasi`);

UPDATE `users`
SET `role` = 'admin'
WHERE `email` = 'admin@smarttraffic.id';

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
