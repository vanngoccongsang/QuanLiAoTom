-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 26, 2024 lúc 03:51 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quan_ly_ao_tom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ao`
--

CREATE TABLE `ao` (
  `ma_ao` int(100) NOT NULL,
  `ten_ao` varchar(20) NOT NULL,
  `ma_khu` int(255) NOT NULL,
  `ma_vu` int(100) NOT NULL,
  `loai_ao` varchar(50) NOT NULL,
  `dien_tich` int(100) NOT NULL,
  `hinh_dang` varchar(255) NOT NULL,
  `id_khach_hang` int(255) DEFAULT NULL,
  `doanh_thu` float DEFAULT NULL,
  `tong_chi` int(255) DEFAULT NULL,
  `loi_nhuan` int(255) DEFAULT NULL,
  `trang_thai` varchar(50) NOT NULL,
  `ao_cha` int(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ao`
--

INSERT INTO `ao` (`ma_ao`, `ten_ao`, `ma_khu`, `ma_vu`, `loai_ao`, `dien_tich`, `hinh_dang`, `id_khach_hang`, `doanh_thu`, `tong_chi`, `loi_nhuan`, `trang_thai`, `ao_cha`, `created_at`, `updated_at`) VALUES
(16, 'Ao 1', 1, 2, 'Ao Nuôi', 250, 'Ao tròn', 2, 250000000, 74731683, 175268317, 'Đã bán', 16, '2024-04-02 14:45:36', '2024-04-03 08:59:52'),
(17, 'Ao 2', 1, 2, 'Ao Vèo', 260, 'Ao vuông', NULL, NULL, NULL, NULL, 'Hoạt động', NULL, '2024-04-02 14:50:08', '2024-04-26 07:20:11'),
(18, 'Ao 3', 2, 2, 'Ao Nuôi', 270, 'Ao vuông', NULL, NULL, NULL, NULL, 'Hoạt động', NULL, '2024-04-02 14:58:01', '2024-04-17 08:02:11'),
(19, 'Ao 4', 1, 2, 'Ao Nuôi', 280, 'Ao vuông', NULL, NULL, NULL, NULL, 'Hoạt động', NULL, '2024-04-09 08:30:59', '2024-04-26 08:03:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_ao`
--

CREATE TABLE `chi_tiet_ao` (
  `id_chi_tiet_ao` bigint(255) NOT NULL,
  `ma_ao` varchar(255) NOT NULL,
  `ma_khu` int(255) NOT NULL,
  `ma_vu` int(255) NOT NULL,
  `ngay` date NOT NULL,
  `tuoi_tom` int(11) NOT NULL,
  `luong_thuc_an` int(11) DEFAULT NULL,
  `luong_tom_giong` int(11) DEFAULT NULL,
  `luong_tom_sp` int(255) DEFAULT NULL,
  `ADG` float DEFAULT NULL,
  `FCR` float DEFAULT NULL,
  `size` int(100) DEFAULT NULL,
  `hao_hut` int(100) DEFAULT NULL,
  `tinh_trang` varchar(255) DEFAULT NULL,
  `sl_nhan_chiet` int(255) DEFAULT NULL,
  `tong_tien` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_ao`
--

INSERT INTO `chi_tiet_ao` (`id_chi_tiet_ao`, `ma_ao`, `ma_khu`, `ma_vu`, `ngay`, `tuoi_tom`, `luong_thuc_an`, `luong_tom_giong`, `luong_tom_sp`, `ADG`, `FCR`, `size`, `hao_hut`, `tinh_trang`, `sl_nhan_chiet`, `tong_tien`, `created_at`, `updated_at`) VALUES
(138, '16', 1, 2, '2024-04-01', 22, 27, 1356345, 1500, NULL, NULL, 1350, NULL, NULL, NULL, 1194750, '2024-04-02 14:59:40', '2024-04-11 03:27:53'),
(139, '16', 1, 2, '2024-04-02', 23, 60, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, 2655000, '2024-04-02 15:06:07', '2024-04-11 03:27:53'),
(140, '16', 1, 2, '2024-04-03', 24, 60, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, 2672000, '2024-04-02 15:09:28', '2024-04-11 03:27:53'),
(141, '16', 1, 2, '2024-04-04', 25, 78, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, 3473600, '2024-04-02 15:11:48', '2024-04-11 03:27:53'),
(142, '16', 1, 2, '2024-04-05', 26, 98, NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, 4222167, '2024-04-02 15:13:43', '2024-04-11 03:27:53'),
(143, '16', 1, 2, '2024-04-06', 27, 150, NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, 6637500, '2024-04-02 15:15:07', '2024-04-11 03:27:53'),
(144, '16', 1, 2, '2024-04-07', 28, 160, NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, 7125333, '2024-04-02 15:15:55', '2024-04-11 03:27:53'),
(145, '16', 1, 2, '2024-04-08', 29, 150, NULL, 1400, NULL, NULL, NULL, NULL, NULL, NULL, 6680000, '2024-04-02 15:17:07', '2024-04-11 03:27:53'),
(146, '16', 1, 2, '2024-04-09', 30, 90, 1177179, 2020, NULL, NULL, 560, NULL, 'Chiết sang Ao 2', 179166, 4008000, '2024-04-02 15:19:06', '2024-04-11 03:27:53'),
(147, '17', 1, 2, '2024-04-09', 30, 35, 179166, 10, NULL, NULL, 560, NULL, 'Nhận từ Ao 1', 179166, 1507917, '2024-04-02 15:19:44', '2024-04-26 07:20:11'),
(149, '16', 1, 2, '2024-04-10', 31, 100, 1004105, 150, 0.12, 1.1, 560, 4940, 'Chiết sang Ao 2', 168134, 4308333, '2024-04-02 15:24:51', '2024-04-11 03:27:53'),
(150, '17', 1, 2, '2024-04-10', 31, 75, 347300, 200, NULL, NULL, 560, NULL, 'Nhận từ Ao 1', 168134, 3318750, '2024-04-02 15:27:43', '2024-04-26 07:20:11'),
(151, '16', 1, 2, '2024-04-11', 32, 80, 837795, 400, NULL, NULL, 554, NULL, 'Chiết sang Ao 3', 166310, 3540000, '2024-04-02 15:48:58', '2024-04-11 03:27:53'),
(152, '18', 2, 2, '2024-04-11', 32, 30, 166310, 100, NULL, NULL, 554, NULL, 'Nhận từ Ao 1', 166310, 1327500, '2024-04-02 15:50:14', '2024-04-11 03:27:53'),
(153, '18', 2, 2, '2024-04-12', 33, 50, 339601, 20, NULL, NULL, 554, NULL, 'Nhận từ Ao 1', 173291, 2212500, '2024-04-02 15:53:31', '2024-04-11 03:27:53'),
(154, '16', 1, 2, '2024-04-12', 33, 75, 657771, 1500, 0.1, 0.92, 554, 6733, 'Chiết sang Ao 3', 173291, 3318750, '2024-04-02 15:55:02', '2024-04-11 03:27:53'),
(155, '16', 1, 2, '2024-04-13', 34, 75, NULL, 4500, NULL, NULL, NULL, NULL, NULL, NULL, 3318750, '2024-04-02 16:02:29', '2024-04-11 03:27:53'),
(156, '16', 1, 2, '2024-04-14', 35, 75, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, 3318750, '2024-04-02 16:04:51', '2024-04-11 03:27:53'),
(157, '16', 1, 2, '2024-04-15', 36, 75, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3318750, '2024-04-02 16:06:40', '2024-04-11 03:27:53'),
(158, '16', 1, 2, '2024-04-16', 37, 75, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3318750, '2024-04-02 16:08:34', '2024-04-11 03:27:53'),
(159, '16', 1, 2, '2024-04-17', 38, 75, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3318750, '2024-04-02 16:09:50', '2024-04-11 03:27:53'),
(160, '16', 1, 2, '2024-04-18', 39, 90, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3877500, '2024-04-02 16:11:46', '2024-04-11 03:27:53'),
(161, '16', 1, 2, '2024-04-19', 40, 100, 630752, 4000, 0.14, 0.48, 309, 27019, NULL, NULL, 4425000, '2024-04-02 16:14:04', '2024-04-11 03:27:53'),
(162, '17', 1, 2, '2024-04-11', 32, 75, NULL, 300, NULL, NULL, NULL, NULL, NULL, NULL, 3340000, '2024-04-05 07:54:23', '2024-04-26 07:20:11'),
(163, '17', 1, 2, '2024-04-12', 33, 75, 347300, 1000, NULL, NULL, 554, NULL, NULL, NULL, 3318750, '2024-04-06 14:30:11', '2024-04-26 07:20:11'),
(164, '17', 1, 2, '2024-04-13', 34, 85, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, 3761250, '2024-04-06 14:33:43', '2024-04-26 07:20:11'),
(165, '17', 1, 2, '2024-04-14', 35, 85, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, 3785333, '2024-04-06 14:35:22', '2024-04-26 07:20:11'),
(166, '17', 1, 2, '2024-04-15', 36, 85, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, 3662083, '2024-04-06 14:36:14', '2024-04-26 07:20:11'),
(167, '17', 1, 2, '2024-04-16', 37, 85, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, 3785333, '2024-04-08 02:35:04', '2024-04-26 07:20:11'),
(168, '17', 1, 2, '2024-04-17', 38, 90, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3877500, '2024-04-08 02:36:46', '2024-04-26 07:20:11'),
(169, '17', 1, 2, '2024-04-18', 39, 100, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 4425000, '2024-04-08 02:37:42', '2024-04-26 07:20:11'),
(170, '17', 1, 2, '2024-04-19', 40, 110, 339555, 4000, 0.25, 0.68, 234, 7745, NULL, NULL, 4867500, '2024-04-08 02:39:54', '2024-04-26 07:20:11'),
(175, '17', 1, 2, '2024-04-20', 41, 115, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 4954583, '2024-04-08 03:15:05', '2024-04-26 07:20:11'),
(176, '17', 1, 2, '2024-04-21', 42, 120, NULL, 5000, NULL, NULL, NULL, NULL, NULL, NULL, 5310000, '2024-04-08 03:15:42', '2024-04-26 07:20:11'),
(177, '17', 1, 2, '2024-04-22', 43, 120, NULL, 6000, NULL, NULL, NULL, NULL, NULL, NULL, 5170000, '2024-04-08 03:16:35', '2024-04-26 07:20:11'),
(178, '17', 1, 2, '2024-04-23', 44, 125, NULL, 6000, NULL, NULL, NULL, NULL, NULL, NULL, 5566667, '2024-04-08 03:17:45', '2024-04-26 07:20:11'),
(179, '17', 1, 2, '2024-04-24', 45, 125, 333510, 10000, 0.43, 0.86, 156, 6045, NULL, NULL, 5587917, '2024-04-08 03:18:30', '2024-04-26 07:20:11'),
(182, '18', 2, 2, '2024-04-13', 34, 75, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, 3231250, '2024-04-11 04:36:07', '2024-04-17 04:16:32'),
(183, '17', 1, 2, '2024-04-25', 46, 120, NULL, 10000, NULL, NULL, NULL, NULL, NULL, NULL, 5310000, '2024-04-17 03:56:08', '2024-04-26 07:20:11'),
(184, '17', 1, 2, '2024-04-26', 47, 50, NULL, 8000, NULL, NULL, NULL, NULL, NULL, NULL, 2226667, '2024-04-17 04:00:59', '2024-04-26 07:20:11'),
(185, '18', 2, 2, '2024-04-14', 35, 80, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, 3446667, '2024-04-17 04:18:19', '2024-04-17 04:18:34'),
(186, '18', 2, 2, '2024-04-15', 36, 80, NULL, 2000, NULL, NULL, NULL, NULL, NULL, NULL, 3562667, '2024-04-17 04:21:31', '2024-04-17 04:21:44'),
(187, '18', 2, 2, '2024-04-16', 37, 80, NULL, 2000, NULL, NULL, NULL, NULL, NULL, NULL, 3540000, '2024-04-17 04:23:13', '2024-04-17 04:23:26'),
(188, '18', 2, 2, '2024-04-17', 38, 90, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 3877500, '2024-04-17 04:24:45', '2024-04-17 04:25:00'),
(189, '18', 2, 2, '2024-04-18', 39, 100, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, 4453333, '2024-04-17 04:26:07', '2024-04-17 04:26:31'),
(190, '18', 2, 2, '2024-04-19', 40, 110, 334002, 2000, 0.25, 0.6, 261, 5599, NULL, NULL, 4131937, '2024-04-17 04:34:34', '2024-04-17 04:37:20'),
(191, '18', 2, 2, '2024-04-20', 41, 115, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, 4486270, '2024-04-17 04:44:01', '2024-04-17 04:44:19'),
(192, '18', 2, 2, '2024-04-21', 42, 120, NULL, 4000, NULL, NULL, NULL, NULL, NULL, NULL, 4507568, '2024-04-17 04:45:14', '2024-04-17 04:46:32'),
(193, '18', 2, 2, '2024-04-22', 43, 120, NULL, 5000, NULL, NULL, NULL, NULL, NULL, NULL, 4681325, '2024-04-17 04:47:18', '2024-04-17 04:47:52'),
(194, '18', 2, 2, '2024-04-23', 44, 125, NULL, 5000, NULL, NULL, NULL, NULL, NULL, NULL, 4695383, '2024-04-17 04:48:41', '2024-04-17 04:49:16'),
(195, '18', 2, 2, '2024-04-24', 45, 125, 328278, 10000, 0.46, 0.8, 163, 5724, NULL, NULL, 5074457, '2024-04-17 04:49:50', '2024-04-17 04:51:43'),
(196, '18', 2, 2, '2024-04-25', 46, 120, NULL, 10000, NULL, NULL, NULL, NULL, NULL, NULL, 4681325, '2024-04-17 04:52:44', '2024-04-17 04:53:04'),
(197, '18', 2, 2, '2024-04-26', 47, 50, NULL, 8000, NULL, NULL, NULL, NULL, NULL, NULL, 1878153, '2024-04-17 04:53:51', '2024-04-17 08:52:00'),
(201, '18', 2, 2, '2024-04-27', 48, 125, 270423, 6000, NULL, NULL, 140, NULL, 'Chiết sang Ao 4', 57855, 4695384, '2024-04-17 08:53:24', '2024-04-17 09:19:09'),
(204, '19', 1, 2, '2024-04-27', 48, 0, 116313, 0, NULL, NULL, 140, NULL, 'Nhận từ Ao 2', 58458, NULL, '2024-04-17 09:19:09', '2024-04-26 08:03:31'),
(205, '17', 1, 2, '2024-04-27', 48, 80, 275052, 6000, NULL, NULL, 132, NULL, 'Chiết sang Ao 4', 58458, 3005045, '2024-04-17 09:24:57', '2024-04-26 07:20:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gia_tom`
--

CREATE TABLE `gia_tom` (
  `id` int(11) NOT NULL,
  `ngay_ban` date NOT NULL,
  `gia_ban` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `gia_tom`
--

INSERT INTO `gia_tom` (`id`, `ngay_ban`, `gia_ban`, `created_at`, `updated_at`) VALUES
(1, '2024-02-26', 150000, '2024-02-29 04:09:18', '2024-02-29 04:09:18'),
(2, '2024-02-27', 160000, '2024-02-29 04:10:22', '2024-02-29 04:10:22'),
(3, '2024-02-28', 130000, '2024-02-29 04:10:36', '2024-02-29 04:10:36'),
(4, '2024-02-29', 210000, '2024-02-29 04:21:06', '2024-02-29 04:21:06'),
(5, '2024-02-15', 310000, '2024-02-29 04:27:13', '2024-02-29 04:27:13'),
(6, '2024-02-19', 270000, '2024-02-29 04:29:14', '2024-02-29 04:29:14'),
(9, '2024-03-01', 270000, '2024-02-29 08:29:54', '2024-02-29 08:29:54'),
(10, '2024-03-19', 260000, '2024-03-19 08:51:29', '2024-03-19 08:51:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id_khach_hang` int(11) NOT NULL,
  `loai_khach_hang` varchar(255) NOT NULL,
  `ten_khach_hang` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(11) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`id_khach_hang`, `loai_khach_hang`, `ten_khach_hang`, `so_dien_thoai`, `dia_chi`, `ghi_chu`, `created_at`, `updated_at`) VALUES
(1, 'Tư nhân', 'Lê Văn Bảo', '0123456788', '123F NVN,phường 3, Gò Vấp', NULL, '2024-03-24 15:45:44', '2024-03-26 10:52:50'),
(2, 'Chợ', 'Nguyễn Văn Hải', '0933312345', '93C PVD, phường NCT, quận 5', NULL, '2024-03-24 22:35:31', '2024-03-26 10:53:05'),
(3, 'Nhà hàng', 'Trần Văn Trường', '0377277388', '26B CQ, phường NCT, quận 1', NULL, '2024-03-26 10:52:33', '2024-03-26 10:52:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khu_nuoi`
--

CREATE TABLE `khu_nuoi` (
  `ma_khu` int(100) NOT NULL,
  `ten_khu` varchar(255) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `trang_thai` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khu_nuoi`
--

INSERT INTO `khu_nuoi` (`ma_khu`, `ten_khu`, `dia_chi`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Khu 1', '123A LVB, phường 2, Gò Vấp', 'Hoạt động', '2024-01-24 20:15:50', '2024-04-09 01:45:48'),
(2, 'Khu 2', '88A LVB, phường 12, Gò Vấp', 'Hoạt động', '2024-01-25 03:18:24', '2024-03-19 06:22:05'),
(3, 'Khu 3', '88A LB, phường 1, Gò Vấp', 'Hoạt động', '2024-01-23 22:21:54', '2024-03-15 07:36:29'),
(4, 'Khu 4', '223A TC, phường 13, Tân Bình', 'Ngừng hoạt động', '2024-02-02 02:28:29', '2024-04-09 01:56:27'),
(5, 'Khu 5', '223A TC, phường NCT, quận 1', 'Hoạt động', '2024-02-02 02:39:15', '2024-04-05 04:31:11'),
(6, 'Khu 6', '223A TC, phường NCT, quận 1', 'Ngừng hoạt động', '2024-02-03 15:29:11', '2024-04-10 05:00:34'),
(8, 'Khu 7', '319/A8, Ly Thuong Kiet', 'Hoạt động', '2024-04-09 01:35:53', '2024-04-10 04:40:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `ma_khu` int(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `location`
--

INSERT INTO `location` (`id`, `ma_khu`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 10.7743, 106.667, '2024-04-05 11:51:03', '2024-04-05 11:52:41'),
(2, 2, 10.7738, 106.67, '2024-04-05 12:15:42', '2024-04-05 12:15:42'),
(3, 3, 10.7724, 106.675, '2024-04-05 14:11:12', '2024-04-05 14:11:12'),
(4, 4, 10.7703, 106.67, '2024-04-05 14:11:39', '2024-04-05 14:11:39'),
(5, 5, 10.7774, 106.679, '2024-04-05 14:20:59', '2024-04-05 14:20:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_08_143159_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 11),
(5, 'App\\Models\\User', 13),
(6, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 14),
(8, 'App\\Models\\User', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `moi_truong`
--

CREATE TABLE `moi_truong` (
  `id_moi_truong` bigint(20) NOT NULL,
  `id_chi_tiet_ao` int(50) NOT NULL,
  `do_kiem` float NOT NULL,
  `do_ph` float NOT NULL,
  `to_khong_khi_sang` int(10) NOT NULL,
  `to_khong_khi_chieu` int(10) NOT NULL,
  `to_nuoc_sang` int(10) NOT NULL,
  `to_nuoc_chieu` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `moi_truong`
--

INSERT INTO `moi_truong` (`id_moi_truong`, `id_chi_tiet_ao`, `do_kiem`, `do_ph`, `to_khong_khi_sang`, `to_khong_khi_chieu`, `to_nuoc_sang`, `to_nuoc_chieu`, `created_at`, `updated_at`) VALUES
(20, 138, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:01:24', '2024-04-02 15:02:43'),
(21, 139, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:08:37', '2024-04-02 15:08:37'),
(22, 140, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:11:01', '2024-04-02 15:11:01'),
(23, 141, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:12:35', '2024-04-02 15:12:35'),
(24, 142, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:14:25', '2024-04-02 15:14:25'),
(25, 144, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:16:35', '2024-04-02 15:16:35'),
(26, 145, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:17:43', '2024-04-02 15:17:43'),
(27, 146, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:23:58', '2024-04-02 15:23:58'),
(28, 147, 70, 7.9, 28, 31, 28, 29, '2024-04-02 15:26:50', '2024-04-02 15:26:50'),
(29, 149, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:28:54', '2024-04-02 15:28:54'),
(30, 151, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:51:19', '2024-04-02 15:51:19'),
(31, 154, 70, 7.9, 30, 45, 30, 31, '2024-04-02 15:55:52', '2024-04-02 15:55:52'),
(32, 155, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:03:13', '2024-04-02 16:03:13'),
(33, 156, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:05:51', '2024-04-02 16:05:51'),
(34, 157, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:07:14', '2024-04-02 16:07:14'),
(35, 158, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:09:11', '2024-04-02 16:09:11'),
(36, 159, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:10:21', '2024-04-02 16:10:21'),
(37, 160, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:12:18', '2024-04-02 16:12:18'),
(38, 161, 70, 7.9, 30, 45, 30, 31, '2024-04-02 16:14:44', '2024-04-02 16:14:44'),
(39, 150, 70, 7.9, 28, 31, 28, 29, '2024-04-03 07:10:27', '2024-04-03 08:22:19'),
(40, 179, 71, 7.9, 29, 30, 28, 29, '2024-04-08 08:49:19', '2024-04-16 02:57:24'),
(41, 183, 70, 7, 28, 32, 28, 29, '2024-04-17 03:57:49', '2024-04-17 03:58:24'),
(42, 182, 70, 7.5, 28, 34, 28, 30, '2024-04-17 04:17:19', '2024-04-17 04:17:19'),
(43, 185, 70, 7.5, 28, 34, 28, 30, '2024-04-17 04:19:19', '2024-04-17 04:19:19'),
(44, 186, 70, 7.5, 28, 34, 28, 30, '2024-04-17 04:22:21', '2024-04-17 04:22:21'),
(45, 187, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:24:08', '2024-04-17 04:24:08'),
(46, 188, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:25:48', '2024-04-17 04:25:48'),
(47, 189, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:27:48', '2024-04-17 04:27:48'),
(48, 190, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:36:39', '2024-04-17 04:36:39'),
(49, 191, 70, 7.5, 28, 34, 28, 30, '2024-04-17 04:44:42', '2024-04-17 04:44:42'),
(50, 192, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:46:15', '2024-04-17 04:46:15'),
(51, 193, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:47:40', '2024-04-17 04:47:40'),
(52, 194, 70, 7.6, 28, 34, 28, 30, '2024-04-17 04:48:59', '2024-04-17 04:48:59'),
(53, 195, 70, 7, 28, 32, 28, 29, '2024-04-17 04:50:59', '2024-04-17 04:50:59'),
(54, 196, 70, 7, 28, 32, 28, 29, '2024-04-17 04:53:23', '2024-04-17 04:53:23'),
(55, 197, 70, 7, 28, 32, 28, 29, '2024-04-17 04:54:15', '2024-04-17 04:54:15'),
(56, 201, 70, 7, 28, 34, 28, 29, '2024-04-17 08:54:16', '2024-04-17 08:54:16'),
(57, 205, 70, 7, 28, 32, 28, 29, '2024-04-17 09:25:45', '2024-04-19 03:40:59'),
(58, 204, 70, 7.6, 30, 32, 29, 30, '2024-04-24 04:27:34', '2024-04-24 04:27:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `ma_nhan_vien` varchar(255) NOT NULL,
  `ho_ten` varchar(50) NOT NULL,
  `chuc_vu` varchar(50) NOT NULL,
  `so_dien_thoai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhap_vat_tu`
--

CREATE TABLE `nhap_vat_tu` (
  `id_nhap_vat_tu` int(11) NOT NULL,
  `ma_vat_tu` int(11) NOT NULL,
  `ngay_nhap` date NOT NULL,
  `so_luong_nhap` int(100) NOT NULL,
  `gia_tien` int(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhap_vat_tu`
--

INSERT INTO `nhap_vat_tu` (`id_nhap_vat_tu`, `ma_vat_tu`, `ngay_nhap`, `so_luong_nhap`, `gia_tien`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-03-29', 200, 4000000, '2024-03-29 11:52:58', '2024-04-01 14:06:49'),
(2, 1, '2024-03-30', 100, 1900000, '2024-04-01 09:46:09', '2024-04-01 14:07:29'),
(4, 1, '2024-03-31', 200, 4100000, '2024-04-01 09:55:30', '2024-04-01 14:07:15'),
(5, 1, '2024-04-01', 100, 2000000, '2024-04-01 14:08:25', '2024-04-01 14:08:25'),
(6, 1, '2024-04-02', 200, 5000000, '2024-04-01 14:34:27', '2024-04-01 14:34:27'),
(7, 2, '2024-03-20', 500, 22500000, '2024-04-02 21:19:39', '2024-04-02 21:19:39'),
(8, 2, '2024-03-23', 1000, 43000000, '2024-04-02 21:22:11', '2024-04-02 21:22:11'),
(9, 2, '2024-03-28', 500, 23000000, '2024-04-02 21:23:11', '2024-04-02 21:23:11'),
(10, 3, '2024-03-12', 500, 23000000, '2024-04-02 21:23:42', '2024-04-02 21:23:42'),
(11, 3, '2024-03-21', 700, 28700000, '2024-04-02 21:24:21', '2024-04-02 21:24:21'),
(12, 4, '2024-03-26', 800, 36000000, '2024-04-02 21:26:16', '2024-04-02 21:26:16'),
(13, 4, '2024-04-01', 700, 30800000, '2024-04-02 21:28:08', '2024-04-02 21:28:08'),
(14, 3, '2024-04-17', 1000, 37000000, '2024-04-17 11:32:50', '2024-04-17 11:32:50'),
(15, 2, '2024-04-17', 1000, 40000000, '2024-04-17 11:33:20', '2024-04-17 11:33:20'),
(16, 4, '2024-04-17', 1000, 39000000, '2024-04-17 11:34:04', '2024-04-17 11:34:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhat_ky`
--

CREATE TABLE `nhat_ky` (
  `id_nhat_ky` bigint(20) NOT NULL,
  `id_chi_tiet_ao` bigint(20) NOT NULL,
  `ten_cu` varchar(255) NOT NULL,
  `ma_vat_tu` int(11) NOT NULL,
  `so_luong` float NOT NULL,
  `don_vi` varchar(255) DEFAULT NULL,
  `gia_tien` int(255) DEFAULT NULL,
  `ghi_chu` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhat_ky`
--

INSERT INTO `nhat_ky` (`id_nhat_ky`, `id_chi_tiet_ao`, `ten_cu`, `ma_vat_tu`, `so_luong`, `don_vi`, `gia_tien`, `ghi_chu`, `created_at`, `updated_at`) VALUES
(82, 138, 'Cử 1', 2, 27, NULL, 1194750, NULL, '2024-04-02 15:00:15', '2024-04-02 15:00:15'),
(83, 139, 'Cử 1', 2, 60, NULL, 2655000, NULL, '2024-04-02 15:07:21', '2024-04-02 15:07:21'),
(84, 140, 'Cử 1', 4, 60, NULL, 2672000, NULL, '2024-04-02 15:10:29', '2024-04-02 15:10:29'),
(85, 141, 'Cử 1', 4, 78, NULL, 3473600, NULL, '2024-04-02 15:12:19', '2024-04-02 15:12:19'),
(86, 142, 'Cử 1', 3, 98, NULL, 4222167, NULL, '2024-04-02 15:14:03', '2024-04-02 15:14:03'),
(87, 143, 'Cử 1', 2, 150, NULL, 6637500, NULL, '2024-04-02 15:15:19', '2024-04-02 15:15:19'),
(88, 144, 'Cử 1', 4, 160, NULL, 7125333, NULL, '2024-04-02 15:16:15', '2024-04-02 15:16:15'),
(89, 145, 'Cử 1', 4, 150, NULL, 6680000, NULL, '2024-04-02 15:17:26', '2024-04-02 15:17:26'),
(90, 146, 'Cử 1', 4, 90, NULL, 4008000, NULL, '2024-04-02 15:23:43', '2024-04-02 15:23:43'),
(91, 147, 'Cử 1', 3, 35, NULL, 1507917, NULL, '2024-04-02 15:26:16', '2024-04-02 15:26:16'),
(92, 149, 'Cử 1', 3, 100, NULL, 4308333, NULL, '2024-04-02 15:28:22', '2024-04-02 15:28:22'),
(93, 150, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 15:46:47', '2024-04-02 15:46:47'),
(94, 151, 'Cử 1', 2, 80, NULL, 3540000, NULL, '2024-04-02 15:49:35', '2024-04-02 15:49:35'),
(95, 152, 'Cử 1', 2, 30, NULL, 1327500, NULL, '2024-04-02 15:52:26', '2024-04-02 15:52:26'),
(96, 154, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 15:55:37', '2024-04-02 15:55:37'),
(97, 153, 'Cử 1', 2, 50, NULL, 2212500, NULL, '2024-04-02 15:57:54', '2024-04-02 15:57:54'),
(98, 155, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 16:02:55', '2024-04-02 16:02:55'),
(99, 156, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 16:05:33', '2024-04-02 16:05:33'),
(100, 157, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 16:07:01', '2024-04-02 16:07:01'),
(101, 158, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 16:08:57', '2024-04-02 16:08:57'),
(102, 159, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-02 16:10:07', '2024-04-02 16:10:07'),
(103, 160, 'Cử 1', 3, 90, NULL, 3877500, NULL, '2024-04-02 16:12:05', '2024-04-02 16:12:05'),
(104, 161, 'Cử 1', 2, 100, NULL, 4425000, NULL, '2024-04-02 16:14:29', '2024-04-02 16:14:29'),
(105, 162, 'Cử 1', 4, 75, NULL, 3340000, NULL, '2024-04-06 14:29:20', '2024-04-06 14:29:20'),
(106, 163, 'Cử 1', 2, 75, NULL, 3318750, NULL, '2024-04-06 14:30:40', '2024-04-06 14:30:40'),
(107, 164, 'Cử 1', 2, 85, NULL, 3761250, NULL, '2024-04-06 14:34:08', '2024-04-06 14:34:08'),
(108, 165, 'Cử 1', 4, 85, NULL, 3785333, NULL, '2024-04-06 14:35:44', '2024-04-06 14:35:44'),
(109, 166, 'Cử 1', 3, 85, NULL, 3662083, NULL, '2024-04-06 14:36:26', '2024-04-06 14:36:26'),
(110, 167, 'Cử 1', 4, 85, NULL, 3785333, NULL, '2024-04-08 02:35:35', '2024-04-08 02:35:35'),
(111, 168, 'Cử 1', 3, 90, NULL, 3877500, NULL, '2024-04-08 02:37:02', '2024-04-08 02:37:02'),
(112, 169, 'Cử 1', 2, 100, NULL, 4425000, NULL, '2024-04-08 02:37:56', '2024-04-08 02:37:56'),
(113, 170, 'Cử 1', 2, 110, NULL, 4867500, NULL, '2024-04-08 02:40:13', '2024-04-08 02:40:13'),
(114, 171, 'Cử 1', 4, 115, NULL, 5121333, NULL, '2024-04-08 02:52:53', '2024-04-08 02:52:53'),
(115, 172, 'Cử 1', 4, 120, NULL, 5344000, NULL, '2024-04-08 02:53:39', '2024-04-08 02:53:39'),
(116, 173, 'Cử 1', 3, 120, NULL, 5170000, NULL, '2024-04-08 02:54:12', '2024-04-08 02:54:12'),
(117, 174, 'Cử 1', 2, 125, NULL, 5531250, NULL, '2024-04-08 02:54:46', '2024-04-08 02:54:46'),
(118, 175, 'Cử 1', 3, 115, NULL, 4954583, NULL, '2024-04-08 03:15:18', '2024-04-08 03:15:18'),
(119, 176, 'Cử 1', 2, 120, NULL, 5310000, NULL, '2024-04-08 03:15:58', '2024-04-08 03:15:58'),
(120, 177, 'Cử 1', 3, 120, NULL, 5170000, NULL, '2024-04-08 03:16:54', '2024-04-08 03:16:54'),
(121, 178, 'Cử 1', 4, 125, NULL, 5566667, NULL, '2024-04-08 03:17:58', '2024-04-08 03:17:58'),
(122, 179, 'Cử 1', 4, 125, NULL, 5566667, NULL, '2024-04-08 03:18:45', '2024-04-08 03:18:45'),
(123, 179, 'Cử 2', 1, 1, NULL, 21250, NULL, '2024-04-09 09:36:42', '2024-04-09 09:36:42'),
(124, 183, 'Cử 1', 2, 120, NULL, 5310000, NULL, '2024-04-17 03:56:52', '2024-04-17 03:56:52'),
(125, 184, 'Cử 1', 4, 50, NULL, 2226667, NULL, '2024-04-17 04:01:43', '2024-04-17 04:01:43'),
(126, 182, 'Cử 1', 3, 75, NULL, 3231250, NULL, '2024-04-17 04:16:32', '2024-04-17 04:16:32'),
(127, 185, 'Cử 1', 3, 80, NULL, 3446667, NULL, '2024-04-17 04:18:34', '2024-04-17 04:18:34'),
(128, 186, 'Cử 1', 4, 80, NULL, 3562667, NULL, '2024-04-17 04:21:44', '2024-04-17 04:21:44'),
(129, 187, 'Cử 1', 2, 80, NULL, 3540000, NULL, '2024-04-17 04:23:26', '2024-04-17 04:23:26'),
(130, 188, 'Cử 1', 3, 90, NULL, 3877500, NULL, '2024-04-17 04:25:00', '2024-04-17 04:25:00'),
(131, 189, 'Cử 1', 4, 100, NULL, 4453333, NULL, '2024-04-17 04:26:31', '2024-04-17 04:26:31'),
(132, 190, 'Cử 1', 3, 110, NULL, 4131937, NULL, '2024-04-17 04:35:24', '2024-04-17 04:35:24'),
(133, 191, 'Cử 1', 4, 115, NULL, 4486270, NULL, '2024-04-17 04:44:19', '2024-04-17 04:44:19'),
(134, 192, 'Cử 1', 3, 120, NULL, 4507568, NULL, '2024-04-17 04:46:32', '2024-04-17 04:46:32'),
(135, 193, 'Cử 1', 4, 120, NULL, 4681325, NULL, '2024-04-17 04:47:52', '2024-04-17 04:47:52'),
(136, 194, 'Cử 1', 3, 125, NULL, 4695383, NULL, '2024-04-17 04:49:16', '2024-04-17 04:49:16'),
(137, 195, 'Cử 1', 2, 125, NULL, 5074457, NULL, '2024-04-17 04:50:10', '2024-04-17 04:50:10'),
(138, 196, 'Cử 1', 4, 120, NULL, 4681325, NULL, '2024-04-17 04:53:04', '2024-04-17 04:53:04'),
(139, 197, 'Cử 1', 3, 50, NULL, 1878153, NULL, '2024-04-17 04:54:24', '2024-04-17 04:54:24'),
(140, 201, 'Cử 1', 3, 125, NULL, 4695384, NULL, '2024-04-17 08:53:56', '2024-04-17 08:53:56'),
(141, 205, 'Cử 1', 3, 80, NULL, 3005045, NULL, '2024-04-17 09:25:28', '2024-04-17 09:25:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`, `updated_at`) VALUES
('nvtruonggiang02@gmail.com', 'U5ekP3y7gKwEK3YgTzoeow8ZykqU58ug0i9qS5SN', '2024-03-17 14:51:53', '2024-03-18 09:37:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `describe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `describe`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'add.ao', 'Add ao nuôi', 'web', '2024-03-08 07:58:47', '2024-03-08 07:58:47'),
(3, 'edit.ao', 'Edit ao nuôi', 'web', '2024-03-08 07:59:10', '2024-03-08 07:59:10'),
(4, 'delete.ao', 'Delete ao nuôi', 'web', '2024-03-08 07:59:20', '2024-03-08 07:59:20'),
(5, 'add.khu', 'Add khu nuôi', 'web', '2024-03-11 10:44:35', '2024-03-11 10:44:35'),
(6, 'edit.khu', 'Edit khu nuôi', 'web', '2024-03-11 10:44:50', '2024-03-11 10:44:50'),
(7, 'delete.khu', 'Delete khu nuôi', 'web', '2024-03-11 10:45:02', '2024-03-11 10:45:02'),
(8, 'add.chi.tiet.ao', 'Add chi tiết ao (ngày nuôi)', 'web', '2024-03-12 04:47:29', '2024-03-12 04:47:29'),
(9, 'add.vu', 'Add vụ nuôi', 'web', '2024-03-12 06:29:40', '2024-03-12 06:29:40'),
(10, 'edit.vu', 'Edit vụ nuôi', 'web', '2024-03-12 06:30:03', '2024-03-12 06:30:03'),
(11, 'delete.vu', 'Delete vụ nuôi', 'web', '2024-03-12 06:30:18', '2024-03-12 06:30:18'),
(12, 'add.vat.tu', 'Add vật tư', 'web', '2024-03-12 06:30:39', '2024-03-12 06:30:39'),
(13, 'edit.vat.tu', 'Edit vật tư', 'web', '2024-03-12 06:30:54', '2024-03-12 06:30:54'),
(14, 'delete.vat.tu', 'Delete vật tư', 'web', '2024-03-12 06:31:25', '2024-03-12 06:31:25'),
(15, 'add.nhat.ky', 'Add nhật ký nuôi', 'web', '2024-03-19 16:06:41', '2024-03-19 16:06:41'),
(16, 'add.moi.truong', 'Add chỉ số môi trường', 'web', '2024-03-19 16:07:11', '2024-03-19 16:07:11'),
(17, 'add.khach.hang', 'Add khách hàng', 'web', '2024-03-24 15:21:36', '2024-03-24 15:21:36'),
(18, 'edit.khach.hang', 'Edit khách hàng', 'web', '2024-03-24 15:21:54', '2024-03-24 15:21:54'),
(19, 'delete.khach.hang', 'Delete khách hàng', 'web', '2024-03-24 15:22:08', '2024-03-24 15:22:08'),
(20, 'edit.moi.truong', 'Edit môi trường', 'web', '2024-03-25 07:38:20', '2024-03-25 07:38:20'),
(21, 'delete.moi.truong', 'Delete môi trường', 'web', '2024-03-25 07:38:40', '2024-03-25 07:38:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phan_cong_ao`
--

CREATE TABLE `phan_cong_ao` (
  `id_phan_cong` bigint(255) NOT NULL,
  `ma_nhan_vien` varchar(255) NOT NULL,
  `ten_ao` varchar(255) NOT NULL,
  `trang_thai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'web', '2024-03-08 08:04:43', '2024-03-08 08:04:43'),
(5, 'quan ly ao', 'web', '2024-03-12 03:00:28', '2024-03-12 03:00:28'),
(6, 'quan ly khu', 'web', '2024-03-12 04:13:37', '2024-03-12 04:13:37'),
(7, 'quan ly vu', 'web', '2024-03-12 04:13:56', '2024-03-12 04:13:56'),
(8, 'quan ly vat tu', 'web', '2024-03-12 04:14:08', '2024-03-12 04:14:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 3),
(2, 5),
(3, 3),
(3, 5),
(4, 3),
(4, 5),
(5, 3),
(5, 6),
(6, 3),
(6, 6),
(7, 3),
(7, 6),
(8, 3),
(8, 5),
(9, 3),
(9, 7),
(10, 3),
(10, 7),
(11, 3),
(11, 7),
(12, 3),
(12, 8),
(13, 3),
(13, 8),
(14, 3),
(14, 8),
(15, 3),
(15, 5),
(16, 3),
(16, 5),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Trường Giang', 'nvtruonggiang02@gmail.com', NULL, '$2y$12$AUO.oOgGnhiKeq6gautTcOV7F7enETGwP.gPaoBEHbvtxkVcqZsL2', NULL, '2024-03-05 03:30:29', '2024-03-19 08:43:16'),
(11, 'Admin', 'admin@gmail.com', NULL, '$2y$12$19vXu5D2UyiKOaQkjwNun.YPp8YKCDuridcNgqdRojH0QowrPSsly', NULL, '2024-03-05 04:30:07', '2024-03-05 04:30:07'),
(13, 'Nguyen Van A', 'quanlyao@gmail.com', NULL, '$2y$12$mMt.VwdR02pNtG6vGFAzEuAVxBBbpFjzAyqpkz9I9HR0gV9nYk3ee', NULL, '2024-03-12 02:47:55', '2024-03-12 02:47:55'),
(14, 'Nguyen Van D', 'quanlyvu@gmail.com', NULL, '$2y$12$zHYiclc/rLKW1v/LyJgn2..5lJ4O7ZNXcKhMpEd0d9GGO2kSIllxW', NULL, '2024-03-12 06:33:34', '2024-03-12 06:33:34'),
(15, 'Le Duc Minh', 'quanlyvattu@gmail.com', NULL, '$2y$12$9Ums0LfFHjfVEAjOegesQOqyWx4PtGtDWn/whM8Kl5jSx63eTVMDa', NULL, '2024-03-12 06:43:30', '2024-03-12 06:43:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vat_tu`
--

CREATE TABLE `vat_tu` (
  `ma_vat_tu` int(100) NOT NULL,
  `ten_vat_tu` varchar(255) NOT NULL,
  `loai_vat_tu` varchar(255) NOT NULL,
  `mo_ta` varchar(255) NOT NULL,
  `nha_cung_cap` varchar(255) NOT NULL,
  `so_luong_nhap` int(255) DEFAULT NULL,
  `so_luong_ton` int(11) DEFAULT NULL,
  `gia_vat_tu_ton` int(255) DEFAULT NULL,
  `don_vi` varchar(255) NOT NULL,
  `gia_vat_tu` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `vat_tu`
--

INSERT INTO `vat_tu` (`ma_vat_tu`, `ten_vat_tu`, `loai_vat_tu`, `mo_ta`, `nha_cung_cap`, `so_luong_nhap`, `so_luong_ton`, `gia_vat_tu_ton`, `don_vi`, `gia_vat_tu`, `created_at`, `updated_at`) VALUES
(1, 'Thuốc khử khuẩn', 'Thuốc khử khuẩn', 'Thuốc khử khuẩn', 'Công ty TNHH BB', 800, 799, 16978750, 'Bao', 17000000, '2024-02-21 03:01:03', '2024-04-16 07:18:41'),
(2, 'Thức ăn 1', 'Thức ăn', 'Thúc đẩy tăng trưởng', 'Công ty TNHH ABC', 3000, 1038, 42138293, 'Kg', 128500000, '2024-01-24 19:52:16', '2024-04-17 04:50:10'),
(3, 'Thức ăn 2', 'Thức ăn', 'Thúc đẩy tăng trưởng', 'Công ty TNHH HH', 2200, 492, 18481030, 'Kg', 88700000, '2024-01-24 20:10:35', '2024-04-17 09:25:28'),
(4, 'Thức ăn 3', 'Thức ăn', 'Thúc đẩy tăng trưởng', 'Công ty TNHH ABC', 2500, 647, 25240147, 'Kg', 105800000, '2024-01-25 03:24:31', '2024-04-17 04:53:04'),
(5, 'Tôm giống A', 'Tôm giống', 'Tôm giống', 'Công ty tôm Long An', NULL, NULL, NULL, 'Con', NULL, '2024-01-25 03:14:24', '2024-04-02 14:15:55'),
(6, 'Tôm giống B', 'Tôm giống', 'Tôm giống', 'CTY TNHH ABC', NULL, NULL, NULL, 'Con', NULL, '2024-02-02 02:43:09', '2024-04-02 14:16:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vu_nuoi`
--

CREATE TABLE `vu_nuoi` (
  `ma_vu` int(100) NOT NULL,
  `ten_vu` varchar(100) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `ngay_tao` date NOT NULL,
  `trang_thai` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `vu_nuoi`
--

INSERT INTO `vu_nuoi` (`ma_vu`, `ten_vu`, `ngay_bat_dau`, `ngay_ket_thuc`, `ngay_tao`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Vụ 1 2024', '2024-01-01', '2024-03-31', '2024-01-01', 'Ngừng hoạt động', '2024-01-23 19:45:28', '2024-03-26 15:46:37'),
(2, 'Vụ 2 2024', '2024-04-01', '2024-06-30', '2024-04-01', 'Hoạt động', '2024-01-23 20:26:45', '2024-04-10 05:04:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ao`
--
ALTER TABLE `ao`
  ADD PRIMARY KEY (`ma_ao`);

--
-- Chỉ mục cho bảng `chi_tiet_ao`
--
ALTER TABLE `chi_tiet_ao`
  ADD PRIMARY KEY (`id_chi_tiet_ao`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `gia_tom`
--
ALTER TABLE `gia_tom`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id_khach_hang`);

--
-- Chỉ mục cho bảng `khu_nuoi`
--
ALTER TABLE `khu_nuoi`
  ADD PRIMARY KEY (`ma_khu`);

--
-- Chỉ mục cho bảng `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `moi_truong`
--
ALTER TABLE `moi_truong`
  ADD PRIMARY KEY (`id_moi_truong`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`ma_nhan_vien`);

--
-- Chỉ mục cho bảng `nhap_vat_tu`
--
ALTER TABLE `nhap_vat_tu`
  ADD PRIMARY KEY (`id_nhap_vat_tu`);

--
-- Chỉ mục cho bảng `nhat_ky`
--
ALTER TABLE `nhat_ky`
  ADD PRIMARY KEY (`id_nhat_ky`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `phan_cong_ao`
--
ALTER TABLE `phan_cong_ao`
  ADD PRIMARY KEY (`id_phan_cong`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `vat_tu`
--
ALTER TABLE `vat_tu`
  ADD PRIMARY KEY (`ma_vat_tu`);

--
-- Chỉ mục cho bảng `vu_nuoi`
--
ALTER TABLE `vu_nuoi`
  ADD PRIMARY KEY (`ma_vu`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ao`
--
ALTER TABLE `ao`
  MODIFY `ma_ao` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_ao`
--
ALTER TABLE `chi_tiet_ao`
  MODIFY `id_chi_tiet_ao` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `gia_tom`
--
ALTER TABLE `gia_tom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id_khach_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `khu_nuoi`
--
ALTER TABLE `khu_nuoi`
  MODIFY `ma_khu` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `moi_truong`
--
ALTER TABLE `moi_truong`
  MODIFY `id_moi_truong` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `nhap_vat_tu`
--
ALTER TABLE `nhap_vat_tu`
  MODIFY `id_nhap_vat_tu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `nhat_ky`
--
ALTER TABLE `nhat_ky`
  MODIFY `id_nhat_ky` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phan_cong_ao`
--
ALTER TABLE `phan_cong_ao`
  MODIFY `id_phan_cong` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `vat_tu`
--
ALTER TABLE `vat_tu`
  MODIFY `ma_vat_tu` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vu_nuoi`
--
ALTER TABLE `vu_nuoi`
  MODIFY `ma_vu` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
