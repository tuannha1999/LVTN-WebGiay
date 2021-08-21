-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2021 at 07:55 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgiay1`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tieude` varchar(250) CHARACTER SET utf8 NOT NULL,
  `name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `trangthai` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `tieude`, `name`, `trangthai`, `id_user`, `created_at`, `updated_at`) VALUES
(7, 'NT store', '60fbc97cc2c16.png', 1, 4, '2021-07-24 08:40:57', '2021-07-24 01:40:57'),
(13, 'NT store', '60fd18f7c3a57.png', 1, 4, '2021-08-05 16:39:51', '2021-08-05 16:39:51'),
(15, 'Khuyến mãi', '610ade4e29b48.png', 1, 4, '2021-08-20 17:50:33', '2021-08-20 17:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdondathang`
--

DROP TABLE IF EXISTS `chitietdondathang`;
CREATE TABLE IF NOT EXISTS `chitietdondathang` (
  `id_dh` bigint(20) UNSIGNED NOT NULL,
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `soluong` int(11) NOT NULL,
  `giaban` int(11) NOT NULL,
  `size` varchar(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `fk_ddh` (`id_dh`),
  KEY `fk_sanpham` (`id_sp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chitietdondathang`
--

INSERT INTO `chitietdondathang` (`id_dh`, `id_sp`, `soluong`, `giaban`, `size`, `img`, `created_at`, `updated_at`) VALUES
(100299, 202181, 1, 2500000, '42', '610c227e03a7d.jpg', '2021-08-20 16:42:56', NULL),
(100300, 202113, 1, 1500000, '43', '60f1aa278580e.jpg', '2021-08-20 16:45:55', NULL),
(100302, 202117, 1, 3500000, '42', '60f1ab87ca7ef.jpg', '2021-08-20 16:49:36', NULL),
(100302, 202123, 1, 3500000, '41', '60f1b5b3607c1.jpg', '2021-08-20 16:49:36', NULL),
(100303, 202113, 1, 1500000, '42', '60f1aa278580e.jpg', '2021-08-20 16:57:52', NULL),
(100303, 202180, 1, 3500000, '40', '610c21c5ece53.jpg', '2021-08-20 16:57:53', NULL),
(100308, 202178, 1, 4500000, '41', '610c1fd753eab.jpg', '2021-08-20 17:22:18', NULL),
(100312, 202114, 1, 4500000, '41', '60f1aa9981a33.jpg', '2021-08-20 17:58:46', NULL),
(100312, 202114, 1, 4500000, '42', '60f1aa9981a33.jpg', '2021-08-20 17:58:46', NULL),
(100313, 202179, 1, 3000000, '42', '610c20edc97e2.jpg', '2021-08-21 07:07:42', NULL),
(100313, 202122, 1, 3250000, '41', '60f1b55f96200.jpg', '2021-08-21 07:07:43', NULL),
(100314, 202115, 1, 4000000, '42', '60f1ab00720e9.jpg', '2021-08-21 07:09:47', NULL),
(100314, 202123, 1, 3500000, '41', '60f1b5b3607c1.jpg', '2021-08-21 07:09:47', NULL),
(100315, 202125, 1, 3200000, '44', '60f1b6af57b87.jpg', '2021-08-21 07:11:11', NULL),
(100315, 202115, 1, 4000000, '42', '60f1ab00720e9.jpg', '2021-08-21 07:11:11', NULL),
(100316, 202116, 1, 4200000, '44', '60f1ab50b3f8c.jpg', '2021-08-21 07:34:41', NULL),
(100316, 202114, 1, 4500000, '44', '60f1aa9981a33.jpg', '2021-08-21 07:34:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieunhap`
--

DROP TABLE IF EXISTS `chitietphieunhap`;
CREATE TABLE IF NOT EXISTS `chitietphieunhap` (
  `id_pn` bigint(20) UNSIGNED NOT NULL,
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `soluong` int(11) NOT NULL,
  `gianhap` int(11) NOT NULL,
  `size` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `fk_pn` (`id_pn`),
  KEY `fk_masp_pn` (`id_sp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chitietphieunhap`
--

INSERT INTO `chitietphieunhap` (`id_pn`, `id_sp`, `soluong`, `gianhap`, `size`, `created_at`, `updated_at`) VALUES
(100031, 202112, 5, 4200000, '42', '2021-07-19 09:36:28', NULL),
(100037, 202123, 15, 3000000, '41', '2021-07-22 17:07:41', NULL),
(100038, 202112, 99, 4300000, '45', '2021-07-22 17:16:33', NULL),
(100052, 202176, 10, 100000, 'default', '2021-08-05 15:13:31', NULL),
(100053, 202176, 10, 90000, 'default', '2021-08-05 15:16:08', NULL),
(100054, 202181, 10, 1500000, '42', '2021-08-05 17:45:08', NULL),
(100054, 202181, 10, 1500000, '44', '2021-08-05 17:45:08', NULL),
(100054, 202180, 10, 2500000, '44', '2021-08-05 17:45:08', NULL),
(100054, 202179, 20, 2000000, '44', '2021-08-05 17:45:08', NULL),
(100054, 202178, 30, 3000000, '44', '2021-08-05 17:45:09', NULL),
(100055, 202182, 10, 10000, 'default', '2021-08-18 17:53:38', NULL),
(100056, 202181, 13, 1500000, '44', '2021-08-18 18:16:36', NULL),
(100057, 202181, 11, 1500000, '43', '2021-08-19 17:10:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieutra`
--

DROP TABLE IF EXISTS `chitietphieutra`;
CREATE TABLE IF NOT EXISTS `chitietphieutra` (
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `id_pt` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(250) NOT NULL,
  `soluong` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `fk_masp_pt` (`id_sp`),
  KEY `fk_id_pt` (`id_pt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chitietphieutra`
--

INSERT INTO `chitietphieutra` (`id_sp`, `id_pt`, `size`, `soluong`, `created_at`, `updated_at`) VALUES
(202114, 73, '41', 1, '2021-08-20 17:04:24', NULL),
(202116, 75, '44', 1, '2021-08-20 17:25:13', NULL),
(202112, 76, '43', 1, '2021-08-20 17:26:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dondathang`
--

DROP TABLE IF EXISTS `dondathang`;
CREATE TABLE IF NOT EXISTS `dondathang` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hoten` varchar(250) NOT NULL,
  `diachi` varchar(250) DEFAULT NULL,
  `sdt` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `trangthai` int(1) NOT NULL,
  `ghichu` varchar(250) DEFAULT NULL,
  `ptthanhtoan` int(11) NOT NULL,
  `dathanhtoan` int(11) NOT NULL,
  `tongtien` int(11) NOT NULL,
  `ngaydat` date NOT NULL,
  `id_kh` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users(KH)` (`id_kh`)
) ENGINE=InnoDB AUTO_INCREMENT=100317 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dondathang`
--

INSERT INTO `dondathang` (`id`, `hoten`, `diachi`, `sdt`, `created_at`, `trangthai`, `ghichu`, `ptthanhtoan`, `dathanhtoan`, `tongtien`, `ngaydat`, `id_kh`, `updated_at`) VALUES
(100299, 'Nguyễn Văn B', 'Phạm Hùng, Quận 8, Tp HCM', '0376449983', '2021-08-20 16:42:56', 3, NULL, 0, 1, 2500000, '2021-08-20', NULL, '2021-08-20 17:25:12'),
(100300, 'Ngoan', 'Tạ Quang Bửu, Quận 8, Tp HCM', '0376440051', '2021-08-20 16:45:55', 3, NULL, 0, 1, 1500000, '2021-08-20', NULL, '2021-08-20 17:04:24'),
(100302, 'Đức Quí', 'Hưng Phú, P9, Quận 8, TP HCM', '0376338872', '2021-08-20 16:49:36', 3, NULL, 0, 1, 7000000, '2021-08-20', NULL, '2021-08-20 17:27:21'),
(100303, 'Thái Tuấn Nhã', 'Nguyễn thị thập, Quận 7, Tp HCM', '0376440059', '2021-08-20 16:57:52', 3, NULL, 0, 1, 5000000, '2021-08-20', 100059, '2021-08-20 16:57:52'),
(100308, 'Tấn Lộc', NULL, '0376338874', '2021-08-20 17:22:18', 3, NULL, 0, 1, 4500000, '2021-08-21', 100063, '2021-08-20 17:26:15'),
(100312, 'Văn C', 'Quận 7', '0376440058', '2021-08-20 17:58:46', 3, NULL, 0, 1, 9000000, '2021-08-21', NULL, '2021-08-20 17:59:04'),
(100313, 'Chiến', 'Nguyễn thị thập, Quận 7, Tp HCM', '0356447763', '2021-08-21 07:07:41', 0, NULL, 0, 0, 6250000, '2021-08-21', NULL, '2021-08-21 07:07:41'),
(100314, 'Văn Sơn', 'Nguyễn thị thập, Quận 7, Tp HCM', '0856567765', '2021-08-21 07:09:47', 0, NULL, 0, 0, 7500000, '2021-08-21', NULL, '2021-08-21 07:09:47'),
(100315, 'Dũng', 'Trần Xuân Soạn, Quận 7, Tp HCM', '0376440053', '2021-08-21 07:11:11', 0, NULL, 0, 0, 7200000, '2021-08-21', NULL, '2021-08-21 07:11:11'),
(100316, 'Huy', 'Cao lỗ, Quận 8, Tp HCM', '0376338874', '2021-08-21 07:34:41', 3, NULL, 0, 1, 8700000, '2021-08-21', NULL, '2021-08-21 07:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinhanh`
--

DROP TABLE IF EXISTS `hinhanh`;
CREATE TABLE IF NOT EXISTS `hinhanh` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `avt` int(11) NOT NULL,
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_masp` (`id_sp`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hinhanh`
--

INSERT INTO `hinhanh` (`id`, `url`, `name`, `avt`, `id_sp`, `created_at`, `updated_at`) VALUES
(134, 'http://localhost8000/img/sanpham/60f1a54845941.jpg', '\"60f1a54845941.jpg\"', 0, 202112, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(135, 'http://localhost8000/img/sanpham/60f1a548543e2.jpg', '\"60f1a548543e2.jpg\"', 0, 202112, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(136, 'http://localhost8000/img/sanpham/60f1a5485dd47.jpg', '\"60f1a5485dd47.jpg\"', 1, 202112, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(137, 'http://localhost8000/img/sanpham/60f1a54867360.jpg', '\"60f1a54867360.jpg\"', 0, 202112, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(141, 'http://localhost8000/img/sanpham/60f1aa99610c0.jpg', '\"60f1aa99610c0.jpg\"', 0, 202114, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(142, 'http://localhost8000/img/sanpham/60f1aa997819d.jpg', '\"60f1aa997819d.jpg\"', 0, 202114, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(143, 'http://localhost8000/img/sanpham/60f1aa9981a33.jpg', '\"60f1aa9981a33.jpg\"', 1, 202114, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(145, 'http://localhost8000/img/sanpham/60f1ab00584fe.jpg', '\"60f1ab00584fe.jpg\"', 0, 202115, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(146, 'http://localhost8000/img/sanpham/60f1ab00720e9.jpg', '\"60f1ab00720e9.jpg\"', 1, 202115, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(147, 'http://localhost8000/img/sanpham/60f1ab50a50f5.jpg', '\"60f1ab50a50f5.jpg\"', 0, 202116, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(148, 'http://localhost8000/img/sanpham/60f1ab50b3f8c.jpg', '\"60f1ab50b3f8c.jpg\"', 1, 202116, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(149, 'http://localhost8000/img/sanpham/60f1ab50cb077.jpg', '\"60f1ab50cb077.jpg\"', 0, 202116, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(150, 'http://localhost8000/img/sanpham/60f1ab87b0d4e.jpg', '\"60f1ab87b0d4e.jpg\"', 0, 202117, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(151, 'http://localhost8000/img/sanpham/60f1ab87ca7ef.jpg', '\"60f1ab87ca7ef.jpg\"', 1, 202117, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(152, 'http://localhost8000/img/sanpham/60f1ab87e4636.jpg', '\"60f1ab87e4636.jpg\"', 0, 202117, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(153, 'http://localhost8000/img/sanpham/60f1abfe975db.jpg', '\"60f1abfe975db.jpg\"', 0, 202118, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(154, 'http://localhost8000/img/sanpham/60f1abfea0c07.jpg', '\"60f1abfea0c07.jpg\"', 1, 202118, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(158, 'http://localhost8000/img/sanpham/60f1b55f96200.jpg', '\"60f1b55f96200.jpg\"', 1, 202122, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(159, 'http://localhost8000/img/sanpham/60f1b55faa61d.jpg', '\"60f1b55faa61d.jpg\"', 0, 202122, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(160, 'http://localhost8000/img/sanpham/60f1b55fb3bc1.jpg', '\"60f1b55fb3bc1.jpg\"', 0, 202122, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(161, 'http://localhost8000/img/sanpham/60f1b5b34aee8.jpg', '\"60f1b5b34aee8.jpg\"', 0, 202123, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(162, 'http://localhost8000/img/sanpham/60f1b5b3607c1.jpg', '\"60f1b5b3607c1.jpg\"', 1, 202123, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(163, 'http://localhost8000/img/sanpham/60f1b5b36a22f.jpg', '\"60f1b5b36a22f.jpg\"', 0, 202123, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(164, 'http://localhost8000/img/sanpham/60f1b63905ae7.jpg', '\"60f1b63905ae7.jpg\"', 0, 202124, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(165, 'http://localhost8000/img/sanpham/60f1b6391466d.jpg', '\"60f1b6391466d.jpg\"', 0, 202124, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(167, 'http://localhost8000/img/sanpham/60f1b6aee469d.jpg', '\"60f1b6aee469d.jpg\"', 0, 202125, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(168, 'http://localhost8000/img/sanpham/60f1b6af01c4b.jpg', '\"60f1b6af01c4b.jpg\"', 0, 202125, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(169, 'http://localhost8000/img/sanpham/60f1b6af57b87.jpg', '\"60f1b6af57b87.jpg\"', 1, 202125, '2021-07-17 07:08:07', '0000-00-00 00:00:00'),
(174, 'http://localhost8000/img/sanpham/60f386bb252e7.jpg', '\"60f386bb252e7.jpg\"', 1, 202124, '2021-07-18 01:41:37', '2021-07-17 18:41:37'),
(215, 'http://localhost8000/img/sanpham/61004a34c80da.jpg', '\"61004a34c80da.jpg\"', 1, 202176, '2021-07-27 11:02:28', '2021-07-27 11:02:28'),
(216, 'http://localhost8000/img/sanpham/61081ed5aafa9.jpg', '\"61081ed5aafa9.jpg\"', 1, 202177, '2021-08-02 09:35:33', '2021-08-02 09:35:33'),
(217, 'http://localhost8000/img/sanpham/61081ed5b4777.jpg', '\"61081ed5b4777.jpg\"', 0, 202177, '2021-08-02 09:35:33', '2021-08-02 09:35:33'),
(218, 'http://localhost8000/img/sanpham/61081ed5bf670.jpg', '\"61081ed5bf670.jpg\"', 0, 202177, '2021-08-02 09:35:33', '2021-08-02 09:35:33'),
(219, 'http://localhost8000/img/sanpham/610c1fd74a8b8.jpg', '\"610c1fd74a8b8.jpg\"', 0, 202178, '2021-08-05 17:41:08', '2021-08-05 17:41:08'),
(220, 'http://localhost8000/img/sanpham/610c1fd753eab.jpg', '\"610c1fd753eab.jpg\"', 1, 202178, '2021-08-05 17:41:06', '2021-08-05 17:41:06'),
(221, 'http://localhost8000/img/sanpham/610c1fd76030e.jpg', '\"610c1fd76030e.jpg\"', 0, 202178, '2021-08-05 17:28:55', '2021-08-05 17:28:55'),
(222, 'http://localhost8000/img/sanpham/610c20edbd4c8.jpg', '\"610c20edbd4c8.jpg\"', 0, 202179, '2021-08-05 17:40:56', '2021-08-05 17:40:56'),
(223, 'http://localhost8000/img/sanpham/610c20edc97e2.jpg', '\"610c20edc97e2.jpg\"', 1, 202179, '2021-08-05 17:40:56', '2021-08-05 17:40:56'),
(224, 'http://localhost8000/img/sanpham/610c21c5ece53.jpg', '\"610c21c5ece53.jpg\"', 1, 202180, '2021-08-05 17:37:09', '2021-08-05 17:37:09'),
(225, 'http://localhost8000/img/sanpham/610c21c602213.jpg', '\"610c21c602213.jpg\"', 0, 202180, '2021-08-05 17:37:10', '2021-08-05 17:37:10'),
(226, 'http://localhost8000/img/sanpham/610c21c6195cc.jpg', '\"610c21c6195cc.jpg\"', 0, 202180, '2021-08-05 17:37:10', '2021-08-05 17:37:10'),
(227, 'http://localhost8000/img/sanpham/610c227dda001.jpg', '\"610c227dda001.jpg\"', 0, 202181, '2021-08-05 17:40:38', '2021-08-05 17:40:38'),
(228, 'http://localhost8000/img/sanpham/610c227df0f86.jpg', '\"610c227df0f86.jpg\"', 0, 202181, '2021-08-05 17:40:13', '2021-08-05 17:40:13'),
(229, 'http://localhost8000/img/sanpham/610c227e03a7d.jpg', '\"610c227e03a7d.jpg\"', 1, 202181, '2021-08-05 17:40:38', '2021-08-05 17:40:38'),
(230, 'http://localhost8000/img/sanpham/611d48143a3a7.jpg', '\"611d48143a3a7.jpg\"', 1, 202182, '2021-08-18 17:49:08', '2021-08-18 17:49:08'),
(231, 'http://localhost8000/img/sanpham/6120ad909bfcc.jpg', '\"6120ad909bfcc.jpg\"', 0, 202113, '2021-08-21 07:38:56', '2021-08-21 07:38:56'),
(232, 'http://localhost8000/img/sanpham/6120ad90a8231.jpg', '\"6120ad90a8231.jpg\"', 1, 202113, '2021-08-21 07:39:07', '2021-08-21 07:39:07'),
(233, 'http://localhost8000/img/sanpham/6120ad90b173e.jpg', '\"6120ad90b173e.jpg\"', 0, 202113, '2021-08-21 07:38:56', '2021-08-21 07:38:56'),
(234, 'http://localhost8000/img/sanpham/6120ae779aa59.jpg', '\"6120ae779aa59.jpg\"', 1, 202183, '2021-08-21 07:42:47', '2021-08-21 07:42:47'),
(235, 'http://localhost8000/img/sanpham/6120aeb861d34.jpg', '\"6120aeb861d34.jpg\"', 1, 202184, '2021-08-21 07:43:52', '2021-08-21 07:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
--

DROP TABLE IF EXISTS `khuyenmai`;
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenkm` varchar(250) NOT NULL,
  `macode` varchar(250) NOT NULL,
  `ngaybd` date NOT NULL,
  `ngaykt` date NOT NULL,
  `trangthai` int(11) NOT NULL,
  `dieukien` int(11) NOT NULL,
  `tiengiam` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_maqtv_km` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`id`, `tenkm`, `macode`, `ngaybd`, `ngaykt`, `trangthai`, `dieukien`, `tiengiam`, `id_user`, `created_at`, `updated_at`) VALUES
(9, 'Khuyến mãi Noel', 'acdsdgb', '2021-07-17', '2021-09-11', 1, 1000000, 50000, 4, '2021-08-20 07:26:26', '2021-08-20 07:26:26'),
(12, 'Khuyến mãi Hè', 'VCGG100K', '2021-07-27', '2021-08-27', 1, 1500000, 100000, 4, '2021-08-08 17:28:56', '2021-08-08 17:28:56'),
(14, 'Khuyến mãi Hè', 'VCGG200K', '2021-08-05', '2021-09-05', 1, 1500000, 200000, 4, '2021-08-08 18:09:50', '2021-08-08 18:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `loaisanpham`
--

DROP TABLE IF EXISTS `loaisanpham`;
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenloai` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100028 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loaisanpham`
--

INSERT INTO `loaisanpham` (`id`, `tenloai`, `slug`, `created_at`, `updated_at`) VALUES
(100001, 'Giày', 'giay', '2021-07-22 10:57:32', '2021-07-22 03:57:32'),
(100026, 'Phụ kiện', 'phu-kien', '2021-07-23 11:35:47', '2021-07-23 11:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_06_21_081837_add_column_user_table', 2),
(5, '2020_01_01_000001_create_provinces_table', 3),
(6, '2020_01_01_000002_create_districts_table', 3),
(7, '2020_01_01_000003_create_wards_table', 3),
(9, '2021_07_19_170416_add_colunm_yeuthich_into_users_table', 4),
(10, '2021_07_19_171804_add_colunm_yeuthich_into_users_table', 5),
(11, '2021_07_29_082054_alter_column_code_and_time_code_in_table_users', 6),
(12, '2021_07_30_154349_alter_column_active_and_code_active_in_users', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

DROP TABLE IF EXISTS `nhacungcap`;
CREATE TABLE IF NOT EXISTS `nhacungcap` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenncc` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `diachi` varchar(250) NOT NULL,
  `sdt` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000009 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`id`, `tenncc`, `email`, `diachi`, `sdt`, `created_at`, `updated_at`) VALUES
(100000, 'Nhà Phân Phối Giày Nike VN', 'giaynikevn@gmail.com', 'Quận 1', '0376876654', '2021-07-18 17:43:28', '0000-00-00 00:00:00'),
(100002, 'Giày sneaker HCM', 'sneakerhcm@gmail.com', 'Quận 7', '0356447764', '2021-07-18 17:43:34', '0000-00-00 00:00:00'),
(1000004, 'Giày Adidas HCM', 'adidashcm@gmail.com', 'Quận 9', '0456567765', '2021-07-21 15:05:45', '2021-07-21 08:05:45'),
(1000008, 'Phụ kiện giày HCM', 'pkghcm@gmail.com', 'Quận 3', '0379307957', '2021-08-04 16:50:24', '2021-08-04 09:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieunhaphang`
--

DROP TABLE IF EXISTS `phieunhaphang`;
CREATE TABLE IF NOT EXISTS `phieunhaphang` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ngaynhap` date NOT NULL,
  `ghichu` varchar(250) DEFAULT NULL,
  `id_ncc` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `trangthai` int(11) NOT NULL,
  `thanhtoan` int(11) NOT NULL,
  `nhapkho` int(11) NOT NULL,
  `tongtien` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nhacungcap` (`id_ncc`),
  KEY `fk_maqtv` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=100058 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phieunhaphang`
--

INSERT INTO `phieunhaphang` (`id`, `ngaynhap`, `ghichu`, `id_ncc`, `id_user`, `trangthai`, `thanhtoan`, `nhapkho`, `tongtien`, `created_at`, `updated_at`) VALUES
(100031, '2021-06-30', '', 100002, 4, 1, 1, 1, 21000000, '2021-07-19 09:39:22', '2021-07-19 02:39:22'),
(100037, '2021-07-16', '', 1000004, 4, 1, 1, 1, 45000000, '2021-07-27 15:02:19', '2021-07-27 08:02:19'),
(100038, '2021-07-17', '', 1000004, 4, 1, 1, 1, 425700000, '2021-07-27 17:19:00', '2021-07-27 10:19:00'),
(100052, '2021-08-05', '', 100002, 4, 1, 1, 1, 1000000, '2021-08-05 15:13:31', '2021-08-05 15:13:31'),
(100053, '2021-08-05', '', 100000, 4, 1, 1, 1, 900000, '2021-08-05 15:16:08', '2021-08-05 15:16:08'),
(100054, '2021-08-05', '', 100002, 4, 1, 1, 1, 185000000, '2021-08-05 17:45:07', '2021-08-05 17:45:07'),
(100055, '2021-08-19', '', 100000, 4, 1, 1, 1, 100000, '2021-08-18 17:55:17', '2021-08-18 17:55:17'),
(100056, '2021-08-19', '', 100002, 4, 1, 1, 1, 19500000, '2021-08-18 18:16:36', '2021-08-18 18:16:36'),
(100057, '2021-08-20', '', 1000008, 4, 1, 1, 1, 16500000, '2021-08-19 17:10:13', '2021-08-19 17:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `phieutrahang`
--

DROP TABLE IF EXISTS `phieutrahang`;
CREATE TABLE IF NOT EXISTS `phieutrahang` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ghichu` varchar(250) DEFAULT NULL,
  `trangthai` int(11) NOT NULL,
  `hoantien` int(1) NOT NULL,
  `nhanhang` int(11) NOT NULL,
  `tongtien` int(11) NOT NULL,
  `lydo` int(11) NOT NULL,
  `id_dh` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dondathang` (`id_dh`),
  KEY `fk_users(QTV)` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phieutrahang`
--

INSERT INTO `phieutrahang` (`id`, `ghichu`, `trangthai`, `hoantien`, `nhanhang`, `tongtien`, `lydo`, `id_dh`, `id_user`, `created_at`, `updated_at`) VALUES
(73, NULL, 1, 1, 1, 4500000, 0, 100300, 4, '2021-08-20 17:04:24', '2021-08-20 17:04:24'),
(75, NULL, 1, 1, 1, 4200000, 1, 100299, 4, '2021-08-20 17:25:12', '2021-08-20 17:25:12'),
(76, NULL, 1, 1, 1, 5000000, 1, 100308, 4, '2021-08-20 17:26:15', '2021-08-20 17:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tensp` varchar(250) NOT NULL,
  `giaban` int(11) NOT NULL,
  `gianhap` int(11) NOT NULL,
  `giakm` int(11) NOT NULL,
  `gianhap_new` int(11) NOT NULL,
  `trangthai` int(1) NOT NULL,
  `daban` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_lsp` bigint(20) UNSIGNED NOT NULL,
  `id_th` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_danhmuc` (`id_lsp`),
  KEY `fk_thuonghieu` (`id_th`)
) ENGINE=InnoDB AUTO_INCREMENT=202185 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `tensp`, `giaban`, `gianhap`, `giakm`, `gianhap_new`, `trangthai`, `daban`, `created_at`, `updated_at`, `id_lsp`, `id_th`) VALUES
(202112, 'K NIKE AIR JORDAN 1 MID SE TURF ORANGE \"BLACK/WHITE\"', 5000000, 3000000, 0, 3000000, 1, 40, '2021-07-16 08:27:04', '2021-08-20 17:26:16', 100001, 100010),
(202113, 'M ADIDAS SUPERSTAR CLOUD WHITE/CORE BLACK', 1500000, 600000, 0, 600000, 1, 0, '2021-07-16 08:47:51', '2021-08-21 07:38:56', 100001, 100011),
(202114, 'W NIKE AIR JORDAN 1 LOW SE \'MULTI COLOR\' WHITE/HYPER ROYAL', 4500000, 3000000, 0, 3000000, 1, 14, '2021-07-16 08:49:45', '2021-08-21 07:34:41', 100001, 100010),
(202115, 'M ADIDAS NMD R2 BLACK RED', 4000000, 2800000, 0, 2800000, 1, 12, '2021-07-16 08:51:27', '2021-08-15 07:34:39', 100001, 100011),
(202116, 'M ADIDAS NMD R2 WHITE RED', 4200000, 3000000, 0, 3000000, 1, 16, '2021-07-16 08:52:48', '2021-08-21 07:34:41', 100001, 100011),
(202117, 'M ADIDAS PUREBOOST CORE BLACK', 3500000, 2000000, 0, 2000000, 1, 3, '2021-07-16 08:53:43', '2021-08-20 17:27:21', 100001, 100011),
(202118, 'K NIKE AIR FORCE 1 NBA HO20 WHITE/BRIGHT CRIMSON', 2500000, 1000000, 0, 1000000, 1, 0, '2021-07-16 08:55:41', '2021-07-16 08:55:41', 100001, 100010),
(202122, 'M NIKE AIR MAX 90 WHITE/WHITE-VARSITY MAIZE', 3250000, 2500000, 0, 2500000, 1, 1, '2021-07-16 09:35:42', '2021-08-20 17:54:54', 100001, 100010),
(202123, 'M ADIDAS NMD R1 SESAME', 3500000, 25000000, 0, 2500000, 1, 4, '2021-07-16 09:37:07', '2021-08-20 17:27:21', 100001, 100011),
(202124, 'M ADIDAS DAY JOGGER \"WHITE HOT CORAL\"', 2000000, 1000000, 0, 1000000, 1, 11, '2021-07-16 09:39:20', '2021-07-30 06:33:52', 100001, 100011),
(202125, 'W NIKE AIR MAX 90 WORLDWIDE PACK WHITE/GOLD', 3200000, 2200000, 0, 2200000, 1, 4, '2021-07-16 09:41:17', '2021-08-19 17:31:26', 100001, 100010),
(202176, 'TEREX COMBO - BỘ VỆ SINH GIÀY', 160000, 95455, 0, 90000, 1, 2, '2021-07-27 11:02:28', '2021-08-18 17:40:20', 100026, NULL),
(202177, 'W NIKE AIR ZOOM VOMERO 14 BLACK/WHITE (ĐEN - TRẮNG)', 3250000, 2009901, 0, 2000000, 1, 0, '2021-08-02 09:35:33', '2021-08-05 15:32:55', 100001, 100010),
(202178, 'W NIKE AIR JORDAN 1 LOW METALLIC GOLD WHITE/GOLD', 4500000, 3000000, 0, 3000000, 1, 4, '2021-08-05 17:28:54', '2021-08-20 17:57:02', 100001, 100010),
(202179, 'M NIKE AIR HUARACHE RUN DNA CH.1 WHITE/RED', 3000000, 2000000, 0, 2000000, 1, 3, '2021-08-05 17:33:33', '2021-08-20 17:54:54', 100001, 100010),
(202180, 'M ADIDAS YUNG-1 WHITE RED', 3500000, 2500000, 0, 2500000, 1, 2, '2021-08-05 17:37:09', '2021-08-20 16:57:52', 100001, 100011),
(202181, 'K NIKE AIR FORCE 1 \'07 \"WHITE RACER/BLUE VOLT\"', 2500000, 1500000, 0, 1500000, 1, 2, '2021-08-05 17:40:13', '2021-08-20 17:55:57', 100001, 100010),
(202182, 'DÂY GIÀY - SHOELACES', 20000, 10000, 0, 10000, 1, 0, '2021-08-18 17:49:08', '2021-08-18 17:53:38', 100026, NULL),
(202183, 'BÀN CHẢI VỆ SINH GIÀY TEREX', 30000, 0, 0, 0, 1, 0, '2021-08-21 07:42:47', '2021-08-21 07:42:47', 100026, 100029),
(202184, 'DUNG DỊCH VỆ SINH TEREX', 130000, 0, 0, 0, 1, 0, '2021-08-21 07:43:52', '2021-08-21 07:43:52', 100026, 100029);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
CREATE TABLE IF NOT EXISTS `size` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `size` varchar(250) DEFAULT NULL,
  `soluong` int(11) NOT NULL,
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_size` (`id_sp`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `size`, `soluong`, `id_sp`, `created_at`, `updated_at`) VALUES
(134, '43', 50, 202112, '2021-08-20 17:26:15', '2021-08-20 17:26:15'),
(135, '42', 82, 202112, '2021-08-19 17:30:29', '2021-08-19 17:30:29'),
(136, '44', 85, 202112, '2021-08-15 07:14:21', '2021-08-15 07:14:21'),
(138, '43', 310, 202113, '2021-08-20 17:02:32', '2021-08-20 17:02:32'),
(139, '44', 46, 202113, '2021-07-18 02:47:17', '2021-07-17 19:47:17'),
(140, '42', 9, 202113, '2021-08-20 16:57:52', '2021-08-20 16:57:52'),
(141, '41', 3, 202113, '2021-08-20 17:42:22', '2021-08-20 17:42:22'),
(142, '43', 131, 202114, '2021-08-07 16:28:46', '2021-08-07 16:28:46'),
(143, '42', 62, 202114, '2021-08-20 17:58:46', '2021-08-20 17:58:46'),
(144, '41', 33, 202114, '2021-08-20 17:58:46', '2021-08-20 17:58:46'),
(145, '44', 50, 202115, '2021-08-21 07:20:27', '0000-00-00 00:00:00'),
(146, '43', 55, 202115, '2021-07-17 07:10:52', '0000-00-00 00:00:00'),
(147, '42', 19, 202115, '2021-08-21 07:11:12', '2021-08-21 07:11:12'),
(148, '44', 16, 202116, '2021-08-21 07:34:41', '2021-08-21 07:34:41'),
(149, '43', 3, 202116, '2021-07-17 07:10:52', '0000-00-00 00:00:00'),
(150, '42', 20, 202116, '2021-08-05 17:52:56', '0000-00-00 00:00:00'),
(151, '40', 52, 202116, '2021-08-02 10:28:23', '2021-08-02 03:28:23'),
(152, '44', 50, 202117, '2021-08-21 07:20:27', '0000-00-00 00:00:00'),
(153, '43', 45, 202117, '2021-07-28 17:53:47', '2021-07-28 10:53:47'),
(154, '42', 8, 202117, '2021-08-20 16:49:36', '2021-08-20 16:49:36'),
(155, '43', 30, 202118, '2021-07-17 07:10:52', '0000-00-00 00:00:00'),
(156, '44', 50, 202118, '2021-07-18 01:26:46', '2021-07-17 18:26:46'),
(157, '40', 91, 202118, '2021-07-27 14:26:19', '2021-07-27 07:26:19'),
(161, '43', 10, 202122, '2021-07-28 06:09:14', '2021-07-27 23:09:14'),
(162, '41', 18, 202122, '2021-08-21 07:07:43', '2021-08-21 07:07:43'),
(163, '43', 9, 202123, '2021-08-20 17:07:40', '2021-08-20 17:07:40'),
(164, '41', 38, 202123, '2021-08-21 07:09:47', '2021-08-21 07:09:47'),
(165, '44', 61, 202124, '2021-08-06 06:56:27', '2021-08-06 06:56:27'),
(166, '42', 20, 202124, '2021-08-21 07:23:23', '2021-07-28 10:35:16'),
(167, '44', 17, 202125, '2021-08-21 07:11:11', '2021-08-21 07:11:11'),
(192, 'default', 21, 202176, '2021-08-18 17:39:36', '2021-08-18 17:39:36'),
(193, '36', 20, 202177, '2021-08-05 17:53:10', '2021-08-02 09:35:33'),
(194, '37', 20, 202177, '2021-08-21 07:23:23', '2021-08-02 09:35:33'),
(195, '41', 25, 202177, '2021-08-02 16:55:47', '2021-08-02 09:55:47'),
(196, '42', 23, 202177, '2021-08-02 16:55:47', '2021-08-02 09:55:47'),
(197, '44', 53, 202177, '2021-08-04 17:16:26', '2021-08-04 10:16:26'),
(198, '41', 8, 202178, '2021-08-20 17:22:18', '2021-08-20 17:22:18'),
(199, '43', 30, 202178, '2021-08-21 07:23:23', '2021-08-05 17:28:54'),
(200, '44', 30, 202178, '2021-08-05 17:45:09', '2021-08-05 17:45:09'),
(201, '45', 8, 202178, '2021-08-20 17:56:39', '2021-08-20 17:56:39'),
(202, '40', 9, 202179, '2021-08-20 17:03:48', '2021-08-20 17:03:48'),
(203, '38', 40, 202179, '2021-08-21 07:23:23', '2021-08-05 17:33:33'),
(204, '41', 30, 202179, '2021-08-05 17:47:43', '2021-08-05 17:33:33'),
(205, '44', 20, 202179, '2021-08-05 17:45:09', '2021-08-05 17:45:09'),
(206, '42', 37, 202179, '2021-08-21 07:07:43', '2021-08-21 07:07:43'),
(207, '39', 20, 202179, '2021-08-21 07:23:23', '2021-08-05 17:33:33'),
(208, '38', 18, 202180, '2021-08-11 17:09:52', '2021-08-11 17:09:52'),
(209, '39', 30, 202180, '2021-08-21 07:23:23', '2021-08-05 17:37:09'),
(210, '40', 29, 202180, '2021-08-20 16:57:53', '2021-08-20 16:57:53'),
(211, '41', 40, 202180, '2021-08-05 17:46:53', '2021-08-05 17:37:09'),
(212, '42', 20, 202180, '2021-08-21 07:23:23', '2021-08-05 17:37:09'),
(213, '44', 9, 202180, '2021-08-11 17:18:48', '2021-08-11 17:18:48'),
(214, '40', 10, 202181, '2021-08-21 07:23:23', '2021-08-05 17:40:13'),
(215, '41', 20, 202181, '2021-08-05 17:46:44', '2021-08-05 17:40:13'),
(216, '43', 11, 202181, '2021-08-19 17:10:13', '2021-08-19 17:10:13'),
(217, '44', 23, 202181, '2021-08-18 18:16:36', '2021-08-18 18:16:36'),
(218, '42', 7, 202181, '2021-08-20 17:55:57', '2021-08-20 17:55:57'),
(219, 'default', 50, 202182, '2021-08-18 17:53:38', '2021-08-18 17:53:38'),
(220, '42', 30, 202125, '2021-08-21 07:23:23', '2021-08-21 07:13:15'),
(221, '43', 50, 202125, '2021-08-21 07:23:23', '2021-08-21 07:13:24'),
(222, '40', 50, 202125, '2021-08-21 07:23:23', '2021-08-21 07:13:31'),
(223, '41', 50, 202125, '2021-08-21 07:23:23', '2021-08-21 07:13:38'),
(224, '39', 40, 202125, '2021-08-21 07:23:23', '2021-08-21 07:13:44'),
(225, '43', 60, 202124, '2021-08-21 07:23:23', '2021-08-21 07:14:05'),
(226, '41', 70, 202124, '2021-08-21 07:23:23', '2021-08-21 07:14:13'),
(227, '40', 40, 202124, '2021-08-21 07:23:23', '2021-08-21 07:14:24'),
(228, '42', 60, 202123, '2021-08-21 07:23:23', '2021-08-21 07:14:39'),
(229, '40', 80, 202123, '2021-08-21 07:23:23', '2021-08-21 07:14:53'),
(230, '42', 50, 202122, '2021-08-21 07:23:23', '2021-08-21 07:15:15'),
(231, '44', 30, 202122, '2021-08-21 07:23:23', '2021-08-21 07:15:20'),
(232, '40', 20, 202122, '2021-08-21 07:23:23', '2021-08-21 07:15:27'),
(233, '41', 60, 202118, '2021-08-21 07:23:23', '2021-08-21 07:15:57'),
(234, '42', 30, 202118, '2021-08-21 07:52:19', '2021-08-21 07:16:01'),
(235, '41', 70, 202117, '2021-08-21 07:23:23', '2021-08-21 07:16:18'),
(236, '40', 30, 202117, '2021-08-21 07:23:23', '2021-08-21 07:16:31'),
(237, '41', 50, 202116, '2021-08-21 07:23:23', '2021-08-21 07:16:52'),
(238, '41', 30, 202115, '2021-08-21 07:23:24', '2021-08-21 07:17:12'),
(239, '40', 30, 202115, '2021-08-21 07:23:24', '2021-08-21 07:17:18'),
(240, '40', 30, 202114, '2021-08-21 07:23:24', '2021-08-21 07:17:43'),
(241, '44', 49, 202114, '2021-08-21 07:34:41', '2021-08-21 07:34:41'),
(242, '40', 20, 202113, '2021-08-21 07:23:24', '2021-08-21 07:18:26'),
(243, '45', 40, 202112, '2021-08-21 07:23:24', '2021-08-21 07:19:15'),
(244, 'default', 30, 202183, '2021-08-21 07:52:02', '2021-08-21 07:42:47'),
(245, 'default', 40, 202184, '2021-08-21 07:52:03', '2021-08-21 07:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `thongke`
--

DROP TABLE IF EXISTS `thongke`;
CREATE TABLE IF NOT EXISTS `thongke` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ngaydat` date NOT NULL,
  `doanhthu` int(11) NOT NULL,
  `loinhuan` int(11) NOT NULL,
  `donhang` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thongke`
--

INSERT INTO `thongke` (`id`, `ngaydat`, `doanhthu`, `loinhuan`, `donhang`, `created_at`, `updated_at`) VALUES
(1, '2021-07-12', 15000000, 8000000, 100, '2021-07-26 10:40:54', NULL),
(2, '2021-07-28', 25000000, 12000000, 40, '2021-07-26 07:46:52', NULL),
(3, '2021-07-14', 23400000, 13000000, 50, '2021-08-02 16:04:26', '2021-07-27 09:50:15'),
(4, '2021-07-17', 15000000, 8000000, 50, '2021-07-26 08:59:52', NULL),
(5, '2021-07-26', 8700000, 5000000, 50, '2021-08-02 16:04:55', '2021-07-28 00:27:44'),
(6, '2021-07-24', 12039999, 8000000, 50, '2021-07-27 16:51:29', '2021-07-27 09:35:52'),
(25, '2021-07-29', 15746000, 6800000, 5, '2021-08-01 17:39:01', '2021-08-01 10:39:01'),
(28, '2021-07-31', 20850000, 8250000, 4, '2021-08-21 07:33:33', '2021-07-30 11:18:21'),
(32, '2021-08-02', 32260000, 10360000, 8, '2021-08-06 06:49:07', '2021-08-06 06:49:07'),
(33, '2021-08-04', 45000000, 15000000, 5, '2021-08-21 07:28:34', '2021-08-04 08:02:05'),
(34, '2021-08-05', 26440000, 8644000, 5, '2021-08-21 07:30:21', '2021-08-07 16:13:24'),
(37, '2021-08-07', 52800000, 16800000, 8, '2021-08-11 15:59:44', '2021-08-11 15:59:44'),
(41, '2021-08-15', 56000000, 18000000, 8, '2021-08-21 07:29:22', '2021-08-15 07:34:39'),
(42, '2021-08-19', 15160000, 4064545, 4, '2021-08-21 07:30:49', '2021-08-19 17:31:26'),
(46, '2021-08-20', 62500000, 27500000, 10, '2021-08-21 07:29:46', '2021-08-20 17:54:54'),
(47, '2021-08-21', 48700000, 17700000, 6, '2021-08-21 07:34:41', '2021-08-21 07:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
CREATE TABLE IF NOT EXISTS `thuonghieu` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100030 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thuonghieu`
--

INSERT INTO `thuonghieu` (`id`, `ten`, `slug`, `created_at`, `updated_at`) VALUES
(100010, 'Nike', 'nike', '2021-08-03 18:32:58', '0000-00-00 00:00:00'),
(100011, 'Adidas', 'adidas', '2021-08-03 18:33:05', '0000-00-00 00:00:00'),
(100027, 'Vans', 'vans', '2021-08-11 17:23:43', '2021-08-11 17:23:43'),
(100029, 'TEREX', 'terex', '2021-08-21 07:41:38', '2021-08-21 07:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `sdt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tonggd` int(11) DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `yeuthich` int(11) NOT NULL,
  `phantram` float NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_code` timestamp NULL DEFAULT NULL,
  `code_active` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_code_index` (`code`),
  KEY `users_code_active_index` (`code_active`)
) ENGINE=InnoDB AUTO_INCREMENT=100066 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `sdt`, `password`, `tonggd`, `remember_token`, `created_at`, `updated_at`, `is_admin`, `yeuthich`, `phantram`, `code`, `time_code`, `code_active`, `active`) VALUES
(4, 'Nha', 'tuannha1234@gmail.com', NULL, '0971473348', '$2y$10$vtjVJfqF7VsPAUVr7UYyKOA2QLmphodJ5sGJHUCS6yoLzAL0w8ruq', 0, NULL, NULL, '2021-08-20 16:31:24', 1, 0, 0.1, NULL, NULL, NULL, 0),
(6, 'Tan Tai', 'dinhtantai9a4@gmail.com', NULL, '0379307950', '$2y$10$4.FG.tiynhJFTPTiA1m9QuYfEiKMXyVeCJFLQUFHSz.40pO3xS2Vy', 0, NULL, '2021-07-03 10:37:27', '2021-07-21 11:31:12', 0, 0, 0, NULL, NULL, NULL, 0),
(100056, 'Admin', 'admin123@gmail.com', NULL, '0989895802', '$2y$10$6vnSX/FgCILflRPT3/oa1ucYuNhrcTqCHIKXExEm/cChj252nskpi', 0, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, 0),
(100059, 'Thái Tuấn Nhã', 'tuannha_demo@gmail.com', '2021-08-18 17:26:17', '0376440059', '$2y$10$A0s8tee4c7eonSTC8Rlv4OvTBfWeuYSC6GJTOi5eDcnD5e7l3XnDC', 12050000, NULL, '2021-08-18 17:26:17', '2021-08-20 17:03:49', 0, 0, 0.1, NULL, NULL, NULL, 1),
(100063, 'Tấn Lộc', 'loc@gmail.com', '2021-08-20 16:51:27', '0376338874', '$2y$10$PEdGziGTBdcJE5uXZ1RSGO.fpMhCJgOCYpmdo.oybrQQGoaSc0Mcq', 4500000, NULL, '2021-08-20 16:51:26', '2021-08-20 17:26:16', 0, 0, 0.06, NULL, NULL, '$2y$10$13kEv6wiBOdTDL4b6ebdL.pNN2ijRs2grsMvmDZIkCWmq65QLFp6C', 1),
(100064, 'Anh Dũng', 'dung@gmail.com', '2021-08-20 16:53:52', '0376220048', '$2y$10$ZitTYT9509.4zOitH2q1hejw3fh8OpReA31JaTTbiFGEBbE81mUvS', 4500000, NULL, '2021-08-20 16:53:51', '2021-08-20 17:02:32', 0, 0, 0.06, NULL, NULL, '$2y$10$eV2/bKM4ru1nV2t0n0Bu6.E7Fg5Dx1i96ng7n7cengXYqbvBQm1OO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yeuthich`
--

DROP TABLE IF EXISTS `yeuthich`;
CREATE TABLE IF NOT EXISTS `yeuthich` (
  `id_sp` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sp`,`id_user`),
  KEY `fk_makh_yt` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banner`
--
ALTER TABLE `banner`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD CONSTRAINT `fk_ddh` FOREIGN KEY (`id_dh`) REFERENCES `dondathang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sanpham` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `fk_masp_pn` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pn` FOREIGN KEY (`id_pn`) REFERENCES `phieunhaphang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chitietphieutra`
--
ALTER TABLE `chitietphieutra`
  ADD CONSTRAINT `fk_id_pt` FOREIGN KEY (`id_pt`) REFERENCES `phieutrahang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_masp_pt` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `fk_users(KH)` FOREIGN KEY (`id_kh`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD CONSTRAINT `fk_masp` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD CONSTRAINT `fk_maqtv_km` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `phieunhaphang`
--
ALTER TABLE `phieunhaphang`
  ADD CONSTRAINT `fk_maqtv` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_nhacungcap` FOREIGN KEY (`id_ncc`) REFERENCES `nhacungcap` (`id`);

--
-- Constraints for table `phieutrahang`
--
ALTER TABLE `phieutrahang`
  ADD CONSTRAINT `fk_dondathang` FOREIGN KEY (`id_dh`) REFERENCES `dondathang` (`id`),
  ADD CONSTRAINT `fk_users(QTV)` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_danhmuc` FOREIGN KEY (`id_lsp`) REFERENCES `loaisanpham` (`id`),
  ADD CONSTRAINT `fk_thuonghieu` FOREIGN KEY (`id_th`) REFERENCES `thuonghieu` (`id`);

--
-- Constraints for table `size`
--
ALTER TABLE `size`
  ADD CONSTRAINT `fk_id_sp` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `fk_makh_yt` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_masp_yt` FOREIGN KEY (`id_sp`) REFERENCES `sanpham` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
