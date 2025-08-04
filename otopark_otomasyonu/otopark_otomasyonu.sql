otopark_otomasyonu.sql kodu:
-- Veritabanı: `otopark_otomasyonu`
CREATE DATABASE IF NOT EXISTS `otopark_otomasyonu` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;
USE `otopark_otomasyonu`;

-- --------------------------------------------------------
-- Tablo: arac_kayit
-- --------------------------------------------------------

CREATE TABLE `arac_kayit` (
  `arac_id` int NOT NULL AUTO_INCREMENT,
  `arac_plaka` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `arac_blok` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `arac_giris_tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arac_cikis_tarih` varchar(55) COLLATE utf8mb4_turkish_ci NOT NULL,
  `adsoyad` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `telefon` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `arac_park_yeri` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`arac_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------
-- Tablo: kullanici_giris
-- --------------------------------------------------------

CREATE TABLE `kullanici_giris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `adsoyad` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `supervisor` tinyint(1) NOT NULL DEFAULT '0',
  `giris_turu` varchar(10) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `onay` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------
-- Tablo: ucretler
-- --------------------------------------------------------

CREATE TABLE `ucretler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `min_sure` int NOT NULL,
  `max_sure` int NOT NULL,
  `ucret` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;