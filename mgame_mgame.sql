-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th9 06, 2017 lúc 12:38 PM
-- Phiên bản máy phục vụ: 10.1.25-MariaDB
-- Phiên bản PHP: 7.0.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mgame_mgame`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `files`
--

CREATE TABLE `files` (
  `file_id` bigint(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_slug` varchar(255) NOT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_source` varchar(255) DEFAULT NULL,
  `file_thumb` varchar(255) DEFAULT NULL,
  `file_mime` varchar(50) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `file_checksum` varchar(255) DEFAULT NULL,
  `file_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `file_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `file_user` int(11) DEFAULT NULL,
  `file_folder` int(11) NOT NULL DEFAULT '0',
  `file_password` varchar(255) DEFAULT NULL,
  `file_subscene` varchar(255) DEFAULT NULL,
  `file_type` varchar(20) NOT NULL DEFAULT 'remote',
  `file_status` int(2) NOT NULL DEFAULT '0',
  `file_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `files`
--

INSERT INTO `files` (`file_id`, `file_name`, `file_slug`, `file_url`, `file_source`, `file_thumb`, `file_mime`, `file_size`, `file_checksum`, `file_created`, `file_modified`, `file_user`, `file_folder`, `file_password`, `file_subscene`, `file_type`, `file_status`, `file_update`) VALUES
(83, 'TruTien1660Mod.zip', 'D6CFA009DD24', 'https://drive.google.com/open?id=0B9X8DGnWGvezTTFURHdsbFJZUWs', NULL, NULL, 'application/zip', 420495598, NULL, '2017-08-06 02:52:21', '2017-08-06 02:52:21', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 19:52:21'),
(84, 'daophong_full.apk', '365DF322A105', 'https://drive.google.com/open?id=0B9X8DGnWGvezZklNdnBKZE03X1k', NULL, NULL, 'application/vnd.android.package-archive', 363644056, NULL, '2017-08-06 04:08:56', '2017-08-06 04:08:56', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 21:08:56'),
(85, 'TP Heroes v2.9.apk', 'A28518EFBEA1', 'https://drive.google.com/open?id=0B9X8DGnWGvezTTJNN3J6QWNEYWc', NULL, NULL, 'application/vnd.android.package-archive', 36224620, NULL, '2017-08-06 04:10:55', '2017-08-06 04:10:55', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 21:10:55'),
(86, '사조영웅전_3.2Mod.apk', '653FECA6AC09', 'https://drive.google.com/open?id=0B9X8DGnWGvezeUI5Rmxfb1VsV1k', NULL, NULL, 'application/vnd.android.package-archive', 40753816, NULL, '2017-08-06 04:12:35', '2017-08-06 04:12:35', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 21:12:35'),
(87, 'Shadowfight3_v116203Mod.zip', '1A344000EA2C', 'https://drive.google.com/open?id=0B9X8DGnWGvezUmFqSFE0UjlSNkE', NULL, NULL, 'application/zip', 351835806, NULL, '2017-08-06 04:29:32', '2017-08-06 04:29:32', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 21:29:32'),
(88, 'Marvelbattle14.1.1.zip', 'CDFDEB0685F1', 'https://drive.google.com/open?id=0B9X8DGnWGvezMEUtLWlMYTRFYms', NULL, NULL, 'application/zip', 578070771, NULL, '2017-08-06 04:47:35', '2017-08-06 04:47:35', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 21:47:35'),
(92, 'OP 7.0.0 M2.apk', '1187809B2F26', 'https://drive.google.com/open?id=0B9X8DGnWGvezdm5rWVBVc1J3THM', NULL, NULL, 'application/vnd.android.package-archive', 41474589, NULL, '2017-08-06 05:08:11', '2017-08-06 05:08:11', 1, 0, NULL, NULL, 'upload', 1, '2017-08-05 22:08:11'),
(95, 'Au-speed-full-1011Mod.zip', '2BC25141780A', 'https://drive.google.com/open?id=0B9X8DGnWGvezZURpTUd3NkJzUjg', NULL, NULL, 'application/zip', 352970096, NULL, '2017-08-07 17:51:52', '2017-08-07 17:51:52', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 10:51:52'),
(96, 'Android.ROW.zip', '5BBB06FACE52', 'https://drive.google.com/open?id=0B9X8DGnWGvezX21lMDB1MTRqaGs', 'https://drive.google.com/open?id=0B6XCGVbT8AirOG4wcFlDdTFiREU', NULL, 'application/zip', 630433798, 'd523f31d776bbb54c4242ad16f85ec31', '2017-08-07 18:54:35', '2017-08-07 18:54:35', 1, 0, NULL, NULL, 'remote', 1, '2017-08-07 11:54:35'),
(97, 'Plants.Vs.Zombies.2.v.6.2.1.ROW.apk', '0C616A6FDD5B', 'https://drive.google.com/open?id=0B9X8DGnWGvezbzZLbzhzQTl2bXM', 'https://drive.google.com/open?id=0B6XCGVbT8AirOEdRVGJocU5OLTg', NULL, 'application/vnd.android.package-archive', 13024823, 'f10895674849b638a2222f675e06bc62', '2017-08-07 18:56:52', '2017-08-07 18:56:52', 1, 0, NULL, NULL, 'remote', 1, '2017-08-07 11:56:52'),
(100, 'DEADTRIGGER2V1.3.1MODMENU.apk', 'ACE1138C1BAA', 'https://drive.google.com/open?id=0B9X8DGnWGvezYjlMYjJfZW9jU2c', NULL, NULL, 'application/vnd.android.package-archive', 27200988, NULL, '2017-08-07 23:22:50', '2017-08-07 23:22:50', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:22:50'),
(101, 'HeroesGuardian_v1.1.2.apk', '9978B7869AE5', 'https://drive.google.com/open?id=0B9X8DGnWGvezaVF4VktKOWJHZ3c', NULL, NULL, 'application/vnd.android.package-archive', 75024705, NULL, '2017-08-07 23:39:22', '2017-08-07 23:39:22', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:39:22'),
(102, 'HeroesGuardian_v1.1.2.apk', '58B694DA933C', 'https://drive.google.com/open?id=0B9X8DGnWGvezcDY2aGxjdGpNSTA', NULL, NULL, 'application/vnd.android.package-archive', 75024705, NULL, '2017-08-07 23:50:28', '2017-08-07 23:50:28', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:50:28'),
(103, 'immortalsaga_mod.apk', '4FC350002989', 'https://drive.google.com/open?id=0B9X8DGnWGvezcWMyZHZOY2I5QU0', NULL, NULL, 'application/vnd.android.package-archive', 42214298, NULL, '2017-08-07 23:50:55', '2017-08-07 23:50:55', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:50:55'),
(104, 'into_the_dead_-263.apk', 'BFE89A87E528', 'https://drive.google.com/open?id=0B9X8DGnWGvezZHZWeUtIQjNuSFE', NULL, NULL, 'application/vnd.android.package-archive', 77723541, NULL, '2017-08-07 23:51:37', '2017-08-07 23:51:37', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:51:37'),
(106, 'Remonster_202New.apk', '24F716BB423D', 'https://drive.google.com/open?id=0B9X8DGnWGvezeEplYjRweDVRZUU', NULL, NULL, 'application/vnd.android.package-archive', 51492936, NULL, '2017-08-07 23:52:51', '2017-08-07 23:52:51', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:52:51'),
(107, 'Sonic Dash_3.7.3.Go.apk', '56D3EF9509D1', 'https://drive.google.com/open?id=0B9X8DGnWGvezQUlQR1pYNEhJR1E', NULL, NULL, 'application/vnd.android.package-archive', 71045997, NULL, '2017-08-07 23:53:35', '2017-08-07 23:53:35', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:53:35'),
(108, 'Yu-Gi-Oh-DuelGenerationv121aMod.zip', '3957B76F39CF', 'https://drive.google.com/open?id=0B9X8DGnWGvezT0labXFFdmN4S28', NULL, NULL, 'application/zip', 546482913, NULL, '2017-08-07 23:58:17', '2017-08-07 23:58:17', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 16:58:17'),
(109, 'Legendary_Game_of_Heroes_v1.8.13_mod.apk', 'FED6744FCA9C', 'https://drive.google.com/open?id=0B9X8DGnWGvezZDdJcmRndlBuckU', NULL, NULL, 'application/vnd.android.package-archive', 60018103, NULL, '2017-08-08 01:41:10', '2017-08-08 01:41:10', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 18:41:10'),
(110, 'BF GL 1.8.0.1 M.apk', 'D99ECB8DFB5A', 'https://drive.google.com/open?id=0B9X8DGnWGvezeVJkVE5aZ21xSXc', NULL, NULL, 'application/vnd.android.package-archive', 45891173, NULL, '2017-08-08 01:46:46', '2017-08-08 01:46:46', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 18:46:46'),
(111, 'Critical Ops_v0.8.1.f92.zip', '47B5C0804F88', 'https://drive.google.com/open?id=0B9X8DGnWGvezUnBYQUhKWmdTSTQ', NULL, NULL, 'application/zip', 179121654, NULL, '2017-08-08 01:53:51', '2017-08-08 01:53:51', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 18:53:51'),
(112, 'BattleHand_1.2.13p2 v2.apk', '63D5885A2721', 'https://drive.google.com/open?id=0B9X8DGnWGvezempMT21SOEh2LVk', NULL, NULL, 'application/vnd.android.package-archive', 82000053, NULL, '2017-08-08 02:27:37', '2017-08-08 02:27:37', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:27:37'),
(113, 'DawnofTitans v1.16.6MOD.zip', '9CFDEA2CC6CF', 'https://drive.google.com/open?id=0B9X8DGnWGvezbVJaWFNaRnhodTA', NULL, NULL, 'application/zip', 935890992, NULL, '2017-08-08 02:34:15', '2017-08-08 02:34:15', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:34:15'),
(114, 'Hungry Shark_5.0.0 v2.apk', '8A3512977B9C', 'https://drive.google.com/open?id=0B9X8DGnWGvezUXl3cW1pRkdUSGc', NULL, NULL, 'application/vnd.android.package-archive', 103024316, NULL, '2017-08-08 02:34:53', '2017-08-08 02:34:53', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:34:53'),
(115, 'Kings-Raid-ToggleON.apk', '3F5B4660209A', 'https://drive.google.com/open?id=0B9X8DGnWGvezQUoyYTlVbFA4aTQ', NULL, NULL, 'application/vnd.android.package-archive', 86068113, NULL, '2017-08-08 02:35:28', '2017-08-08 02:35:28', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:35:28'),
(116, 'real_racing_3_v540.apk', 'F00FE24FAC97', 'https://drive.google.com/open?id=0B9X8DGnWGvezekQ1TlBBX0xaRFU', NULL, NULL, 'application/vnd.android.package-archive', 57355656, NULL, '2017-08-08 02:35:52', '2017-08-08 02:35:52', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:35:52'),
(117, 'RogueLife_1.8.0 MOD x100.apk', '56E88B1B6F34', 'https://drive.google.com/open?id=0B9X8DGnWGvezaktQV2JzRGRIclk', NULL, NULL, 'application/vnd.android.package-archive', 85830081, NULL, '2017-08-08 02:36:24', '2017-08-08 02:36:24', 1, 0, NULL, NULL, 'upload', 1, '2017-08-07 19:36:24'),
(118, 'KingdomWarriors_v1.5.0_mod.apk', '7DD38A71E320', 'https://drive.google.com/open?id=0B9X8DGnWGvezV2pMSTB3M0ZNSjA', NULL, NULL, 'application/vnd.android.package-archive', 50867723, NULL, '2017-08-08 17:51:29', '2017-08-08 17:51:29', 1, 0, NULL, NULL, 'upload', 1, '2017-08-08 10:51:29'),
(120, 'DanceMaser_SuperDanceVN_33Mod.zip', '3F8D9152B6AF', 'https://drive.google.com/open?id=0B9X8DGnWGvezRXNzb05IZzhPT1U', NULL, NULL, 'application/zip', 746543565, NULL, '2017-08-10 08:08:03', '2017-08-10 08:08:03', 1, 0, NULL, NULL, 'upload', 1, '2017-08-10 01:08:03'),
(121, 'PokemonBlack2Vietnamese.zip', 'F483897F1EF1', 'https://drive.google.com/open?id=0B9X8DGnWGvezYmtQc0hKZHN4Qm8', NULL, NULL, 'application/zip', 169733985, NULL, '2017-08-10 22:07:34', '2017-08-10 22:07:34', 1, 0, NULL, NULL, 'upload', 1, '2017-08-10 15:07:34'),
(122, 'mGame_LienQuan_Mod.apk', '58679BC169FD', 'https://drive.google.com/open?id=0B9X8DGnWGvezV1duNHVTR2thR1k', NULL, NULL, 'application/vnd.android.package-archive', 434401952, NULL, '2017-08-12 05:31:01', '2017-08-12 05:31:01', 1, 0, NULL, NULL, 'upload', 1, '2017-08-11 22:31:01'),
(123, 'CA_HCNM_28.06.2017.apk', '17D110846BAD', 'https://drive.google.com/open?id=0B9X8DGnWGvezQXFKUzQ3NWFnRkU', 'https://drive.google.com/open?id=0B6TkqHooyxoUcC1BR18zQmVZN3M', NULL, 'application/vnd.android.package-archive', 534767684, '886a8b2af3594a42560ab91334b14223', '2017-08-12 06:11:46', '2017-08-12 06:11:46', 1, 0, NULL, NULL, 'remote', 1, '2017-08-11 23:11:46'),
(124, 'CLUB_KOREAN-V10078.apk', 'B6BFBB7D88DA', 'https://drive.google.com/open?id=0B9X8DGnWGvezY3NwYi1HNW1GN28', NULL, NULL, 'application/vnd.android.package-archive', 44745504, NULL, '2017-08-13 04:43:48', '2017-08-13 04:43:48', 1, 0, NULL, NULL, 'upload', 1, '2017-08-12 21:43:48'),
(126, 'CLBv1.3.3_VIPMOD.apk', '85CFE38DE5D2', 'https://drive.google.com/open?id=0B9X8DGnWGvezd0NCTy1OV1JZSkE', NULL, NULL, 'application/vnd.android.package-archive', 69985193, NULL, '2017-08-14 07:08:37', '2017-08-14 07:08:37', 1, 0, NULL, NULL, 'upload', 1, '2017-08-14 00:08:37'),
(129, 'mGame_TIENKIEMKYHIEP150MOD.zip', '4B837866025B', 'https://drive.google.com/open?id=0B9X8DGnWGvezaDg3TEhSVW8yOHM', 'https://drive.google.com/open?id=0B3YloZr7kPzyZnVWRDZMZzgtWFE', NULL, 'application/zip', 290453806, '5162cb8f889b1d4b4a59560a8eff73c4', '2017-08-15 12:32:51', '2017-08-15 12:32:51', 1, 0, NULL, NULL, 'remote', 1, '2017-08-15 05:32:51'),
(130, 'mGame_Darkera_v110MOD.zip', '119BDC637ADE', 'https://drive.google.com/open?id=0B9X8DGnWGvezdnZkU082ejlOd2s', 'https://drive.google.com/open?id=0B3YloZr7kPzyZlFWaVVSRnRKRnM', NULL, 'application/zip', 287358561, '5bcd9523bf3be9810068ff13bf0ecddb', '2017-08-15 20:57:09', '2017-08-15 20:57:09', 1, 0, NULL, NULL, 'remote', 1, '2017-08-15 13:57:09'),
(131, 'cdht.zip', 'FDEBB5CA50B3', 'https://drive.google.com/open?id=0B9X8DGnWGvezd3ZaY012R3lSdUE', NULL, NULL, 'application/zip', 13854676, NULL, '2017-08-16 18:59:25', '2017-08-16 18:59:25', 3, 0, NULL, NULL, 'upload', 1, '2017-08-16 11:59:25'),
(132, 'mGame_CDHT_2910MOD.zip', '0DE8454FDB11', 'https://drive.google.com/open?id=0B9X8DGnWGvezemMxbGtGR3NaRDA', NULL, NULL, 'application/zip', 536722999, NULL, '2017-08-16 20:06:32', '2017-08-16 20:06:32', 1, 0, NULL, NULL, 'upload', 1, '2017-08-16 13:06:32'),
(136, 'Es_file_explorer_manager_v104pro.apk', 'E1CA9CAE9A05', 'https://drive.google.com/open?id=0B9X8DGnWGvezekRiUzhndzFsems', NULL, NULL, 'application/vnd.android.package-archive', 6189571, NULL, '2017-08-17 00:33:18', '2017-08-17 00:33:18', 1, 0, NULL, NULL, 'upload', 1, '2017-08-16 17:33:18'),
(137, 'Lucky Patcher v6.5.5.apk', '5F97A40FF25C', 'https://drive.google.com/open?id=0B9X8DGnWGvezYURUZW9SQ3ZfWlU', NULL, NULL, 'application/vnd.android.package-archive', 6071334, NULL, '2017-08-17 00:33:24', '2017-08-17 00:33:24', 1, 0, NULL, NULL, 'upload', 1, '2017-08-16 17:33:24'),
(139, 'New_mGame_LIC_v3.0.apk', '33ED95E93157', 'https://drive.google.com/open?id=0B9X8DGnWGvezamtycVB3MEdINmM', NULL, NULL, 'application/vnd.android.package-archive', 2629387, NULL, '2017-08-18 03:36:35', '2017-08-18 03:36:35', 1, 0, NULL, NULL, 'upload', 1, '2017-08-17 20:36:35'),
(140, 'mGame_LIC_v3.0.apk', 'D8B363F85DF6', 'https://drive.google.com/open?id=0B9X8DGnWGvezb0M2ZElTR05qLUE', NULL, NULL, 'application/vnd.android.package-archive', 2629387, NULL, '2017-08-18 03:38:09', '2017-08-18 03:38:09', 1, 0, NULL, NULL, 'upload', 1, '2017-08-17 20:38:09'),
(146, 'v2_mGame_LIC_v3.0.apk', '6A9EAF8B3241', 'https://drive.google.com/open?id=0B9X8DGnWGvezcjlCNDhBN2JHR3c', NULL, NULL, 'application/vnd.android.package-archive', 5362861, NULL, '2017-08-23 16:21:48', '2017-08-23 16:21:48', 1, 0, NULL, NULL, 'upload', 1, '2017-08-23 09:21:48'),
(147, 'Crossfire Legends_v1.0.26.26_apkpure.com.xapk', '2570E2322593', 'https://drive.google.com/open?id=0B9X8DGnWGvezN2pSanE3cDdjVTg', NULL, NULL, 'application/x-zip', 410545656, NULL, '2017-08-23 17:29:46', '2017-08-23 17:29:46', 1, 0, NULL, NULL, 'upload', 1, '2017-08-23 10:29:46'),
(148, 'NOROOT_CLUB_KOREAN_v10082.apk', '9E6530822B0E', 'https://drive.google.com/open?id=0B9X8DGnWGvezSGZPaG1LRURZaTg', NULL, NULL, 'application/vnd.android.package-archive', 47785708, NULL, '2017-08-24 14:40:01', '2017-08-24 14:40:01', 1, 0, NULL, NULL, 'upload', 1, '2017-08-24 07:40:01'),
(149, 'ROOT_CLUB_KOREAN_v10082.apk', 'B3EDDF054740', 'https://drive.google.com/open?id=0B9X8DGnWGvezZWhTRE9VN1d2T1E', NULL, NULL, 'application/vnd.android.package-archive', 47735348, NULL, '2017-08-24 14:40:34', '2017-08-24 14:40:34', 1, 0, NULL, NULL, 'upload', 1, '2017-08-24 07:40:34'),
(151, 'Crossfire Legends_v1.0.26.26_apkpure.com.apk', '17D5F54C9C3C', 'https://drive.google.com/open?id=0B9X8DGnWGvezUWstOWI1T1hQMU0', NULL, NULL, 'application/vnd.android.package-archive', 24038924, NULL, '2017-08-24 15:03:55', '2017-08-24 15:03:55', 1, 0, NULL, NULL, 'upload', 1, '2017-08-24 08:03:55'),
(152, 'FIX_CLUB_KOREAN_v10082.apk', 'CD4D34321F60', 'https://drive.google.com/open?id=0B9X8DGnWGvezUnpjMnNkMTNZeHM', NULL, NULL, 'application/vnd.android.package-archive', 47761113, NULL, '2017-08-24 19:17:33', '2017-08-24 19:17:33', 1, 0, NULL, NULL, 'upload', 1, '2017-08-24 12:17:33'),
(153, 'FIX_ROOT_CLUB_KOREAN_v10082.apk', '46ACF7EA8F30', 'https://drive.google.com/open?id=0B9X8DGnWGvezMWtsMUlMWFRPdkE', NULL, NULL, 'application/vnd.android.package-archive', 47735370, NULL, '2017-08-24 19:18:31', '2017-08-24 19:18:31', 1, 0, NULL, NULL, 'upload', 1, '2017-08-24 12:18:31'),
(154, 'mGame_CLUBAU_FULL.apk', 'D04D48BFFE06', 'https://drive.google.com/open?id=0B9X8DGnWGvezQ0lfOC1yYnROUm8', 'https://drive.google.com/open?id=0B9X8DGnWGvezYUNwa2hxbjVtYUU', NULL, 'application/vnd.android.package-archive', 49139818, '8375752f541b38e64c0ce9be535c8295', '2017-08-25 04:38:16', '2017-08-25 04:38:16', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:38:16'),
(155, 'mGame_AuStar_MOD.apk', '5C16C6772DB4', 'https://drive.google.com/open?id=0B9X8DGnWGvezc3JLRkw5YkF6WnM', 'https://drive.google.com/open?id=0B9X8DGnWGvezeERyOFBRY0hkd2M', NULL, 'application/vnd.android.package-archive', 498373563, 'c20d23f20f339c638608dc2905db870a', '2017-08-25 04:39:08', '2017-08-25 04:39:08', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:39:08'),
(156, 'mGame_AULOVE_1.3.0511mod.apk', '067A92AEE4A0', 'https://drive.google.com/open?id=0B9X8DGnWGvezMXd0SXg1NDZzRFE', 'https://drive.google.com/open?id=0B9X8DGnWGveza3JHRWJtbGpuTWc', NULL, 'application/vnd.android.package-archive', 23235414, '0838a7740cfe88b0dcd9fd3ffa46fa7c', '2017-08-25 04:39:11', '2017-08-25 04:39:11', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:39:11'),
(157, 'mGame_500K_CLUBAU_FULL.apk', '7CE6F06045F7', 'https://drive.google.com/open?id=0B9X8DGnWGvezcHFnMVV5aU1BdDg', 'https://drive.google.com/open?id=0B9X8DGnWGvezZmlhQkp1empPRUE', NULL, 'application/vnd.android.package-archive', 49137895, '94d53f82baf6d0de84c4615792905a21', '2017-08-25 04:39:13', '2017-08-25 04:39:13', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:39:13'),
(158, 'mGame_HOTSTEPS_V15MOD.apk', '9AB9D3F18672', 'https://drive.google.com/open?id=0B9X8DGnWGvezZzJiYldaSGJTRWc', 'https://drive.google.com/open?id=0B9X8DGnWGvezUlViTE1ZRTMxTEE', NULL, 'application/vnd.android.package-archive', 25814689, 'ae97735bb0615dd7fa110366ee295cc0', '2017-08-25 04:39:16', '2017-08-25 04:39:16', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:39:16'),
(159, 'mGame_Phuckich2213MOD_FIX.apk', '4F3A2FE47243', 'https://drive.google.com/open?id=0B9X8DGnWGvezWTh5MHJjdGVYN2s', 'https://drive.google.com/open?id=0B9X8DGnWGvezSGI0V0JKVjRxQkU', NULL, 'application/vnd.android.package-archive', 229952351, 'f93513c06a5b4aaa9416b9dd861a2fb9', '2017-08-25 04:39:58', '2017-08-25 04:39:58', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:39:58'),
(160, 'mGame_QUANVANTRUONG_v111MOD_SIEUVIP.apk', 'A1FBA0AF634F', 'https://drive.google.com/open?id=0B9X8DGnWGvezd1JHSTRmc2NRcG8', 'https://drive.google.com/open?id=0B9X8DGnWGvezN3lOSGIxTWtOeXc', NULL, 'application/vnd.android.package-archive', 62619981, '1fecc894c7f4247f0b9a3453c8f3c1f6', '2017-08-25 04:40:00', '2017-08-25 04:40:00', 1, 0, NULL, NULL, 'remote', 1, '2017-08-24 21:40:00'),
(161, 'mGame_Seal_NewWorld_VN_Mod.apk', 'B778CCD16AC7', 'https://drive.google.com/open?id=0B9X8DGnWGvezVlp3MERMWXB1UW8', NULL, NULL, 'application/vnd.android.package-archive', 21379548, NULL, '2017-08-25 15:55:53', '2017-08-25 15:55:53', 1, 0, NULL, NULL, 'upload', 1, '2017-08-25 08:55:53'),
(162, 'VIP_LIC.apk', '2DAB46EF662A', 'https://drive.google.com/open?id=0B9X8DGnWGvezRjJiVlJscU5mQ0E', NULL, NULL, 'application/vnd.android.package-archive', 2628927, NULL, '2017-08-25 16:29:49', '2017-08-25 16:29:49', 1, 0, NULL, NULL, 'upload', 1, '2017-08-25 09:29:49'),
(163, '500kClub Audition_v10024_ROOT.apk', 'D46CBA34F2DA', 'https://drive.google.com/open?id=0B9X8DGnWGvezc01jV2hVZzRtQWs', NULL, NULL, 'application/vnd.android.package-archive', 36052625, NULL, '2017-08-26 18:37:10', '2017-08-26 18:37:10', 1, 0, NULL, NULL, 'upload', 1, '2017-08-26 11:37:10'),
(164, 'mGame_VOLAMMINHCHU600.zip', 'C2FF8E105211', 'https://drive.google.com/open?id=0B9X8DGnWGvezNE14U3lDc2NYNzQ', 'https://drive.google.com/open?id=0B3YloZr7kPzydDVoWGpRRi1xS2s', NULL, 'application/zip', 336739459, '94ec0a6fdbe87383b1a975005f5c5c10', '2017-08-28 13:47:32', '2017-08-28 13:47:32', 1, 0, NULL, NULL, 'remote', 1, '2017-08-28 06:47:32'),
(165, 'GDT_LIC.apk', '97CB4143D330', 'https://drive.google.com/open?id=0B9X8DGnWGvezQ1FxclMzeTVwT0E', NULL, NULL, 'application/vnd.android.package-archive', 2654440, NULL, '2017-08-28 17:27:49', '2017-08-28 17:27:49', 1, 0, NULL, NULL, 'upload', 1, '2017-08-28 10:27:49'),
(167, 'VIP_TorchlightMobile_v1.3_Mod_MGteam.apk', '0CCA658D2965', 'https://drive.google.com/open?id=0B9X8DGnWGvezY1BhY2tpUjB2bzQ', NULL, NULL, 'application/vnd.android.package-archive', 34878200, NULL, '2017-08-30 18:27:32', '2017-08-30 18:27:32', 1, 0, NULL, NULL, 'upload', 1, '2017-08-30 11:27:32'),
(168, 'mGame_PhucKich_2215Mod.apk', 'AAC3FB35D631', 'https://drive.google.com/open?id=0B9X8DGnWGvezMWVuUld5MEptOU0', NULL, NULL, 'application/vnd.android.package-archive', 254500367, NULL, '2017-08-31 05:23:33', '2017-08-31 05:23:33', 1, 0, NULL, NULL, 'upload', 1, '2017-08-30 22:23:33'),
(169, 'mGame_TruyKich_179Mod.apk', '73C592594B92', 'https://drive.google.com/open?id=0B9X8DGnWGvezeUNZdTBZM1FVM3c', NULL, NULL, 'application/vnd.android.package-archive', 83961024, NULL, '2017-08-31 20:42:34', '2017-08-31 20:42:34', 1, 0, NULL, NULL, 'upload', 1, '2017-08-31 13:42:34'),
(170, 'mGame_QVT_v120Mod.apk', '51B7D6B3DA53', 'https://drive.google.com/open?id=0B9X8DGnWGvezWHh2YUV4OUgxTUk', NULL, NULL, 'application/vnd.android.package-archive', 68120656, NULL, '2017-09-01 05:24:48', '2017-09-01 05:24:48', 1, 0, NULL, NULL, 'upload', 1, '2017-08-31 22:24:48'),
(171, 'CHIENLUBO_134MOD.apk', 'A1ED1F5CB022', 'https://drive.google.com/open?id=0B9X8DGnWGvezX0JLQ3VwMFJrcG8', NULL, NULL, 'application/vnd.android.package-archive', 69954641, NULL, '2017-09-01 08:34:41', '2017-09-01 08:34:41', 1, 0, NULL, NULL, 'upload', 1, '2017-09-01 01:34:41'),
(172, 'QVT_v120Mod.apk', 'C8B70214D107', 'https://drive.google.com/open?id=0B9X8DGnWGvezT280RFA0WDd3cVk', NULL, NULL, 'application/vnd.android.package-archive', 68120623, NULL, '2017-09-01 20:11:24', '2017-09-01 20:11:24', 1, 0, NULL, NULL, 'upload', 1, '2017-09-01 13:11:24'),
(173, 'V2_TorchlightMobile_v1.3_Mod.apk', '472BDD2422A4', 'https://drive.google.com/open?id=0B9X8DGnWGvezQ19yUk9vSlRHY2s', NULL, NULL, 'application/vnd.android.package-archive', 34879508, NULL, '2017-09-03 04:26:42', '2017-09-03 04:26:42', 1, 0, NULL, NULL, 'upload', 1, '2017-09-02 21:26:42'),
(174, 'mGame_Tales_of_thorn_v2.14.0_MOD.apk', '9C2321C445B6', 'https://drive.google.com/open?id=0B9X8DGnWGvezazJQNG9PWjdsN1E', NULL, NULL, 'application/vnd.android.package-archive', 104748528, NULL, '2017-09-04 01:35:17', '2017-09-04 01:35:17', 1, 0, NULL, NULL, 'upload', 1, '2017-09-03 18:35:17'),
(175, 'CDHT.zip', 'E11BA4983910', 'https://drive.google.com/open?id=0B9X8DGnWGvezc0RaV0ptQUVFNzA', NULL, NULL, 'application/zip', 38320658, NULL, '2017-09-05 23:37:13', '2017-09-05 23:37:13', 1, 0, NULL, NULL, 'upload', 1, '2017-09-05 16:37:13'),
(176, 'mGame_Smart_APK_v104.apk', '55517301C3A4', 'https://drive.google.com/open?id=0B9X8DGnWGvezNDdwdnB5cGFMQnM', NULL, NULL, 'application/vnd.android.package-archive', 2552676, NULL, '2017-09-05 23:42:09', '2017-09-05 23:42:09', 1, 0, NULL, NULL, 'upload', 1, '2017-09-05 16:42:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `folders`
--

CREATE TABLE `folders` (
  `folder_id` int(11) NOT NULL,
  `folder_slug` varchar(255) DEFAULT NULL,
  `folder_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `folder_password` varchar(255) DEFAULT NULL,
  `folder_user` int(11) NOT NULL,
  `folder_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `folder_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `folder_parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

CREATE TABLE `groups` (
  `group_id` bigint(11) NOT NULL,
  `group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_url` varchar(255) DEFAULT NULL,
  `group_user` int(11) NOT NULL,
  `group_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `group_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `group_password` varchar(255) DEFAULT NULL,
  `group_status` int(2) NOT NULL DEFAULT '1',
  `group_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_created` datetime NOT NULL,
  `user_modified` datetime NOT NULL,
  `user_nickname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_player_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_idfolder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_oauth_provider`, `user_oauth_uid`, `user_first_name`, `user_last_name`, `user_email`, `user_gender`, `user_locale`, `user_picture`, `user_link`, `user_created`, `user_modified`, `user_nickname`, `user_player_logo`, `user_idfolder`, `refresh_token`) VALUES
(1, 'google', '104686058496769820599', 'Viet', 'Vu', 'kenviet1988@gmail.com', 'male', 'vi', 'https://lh6.googleusercontent.com/-fTwy9o4lcMM/AAAAAAAAAAI/AAAAAAAAAdY/Swpxbs-BCXI/photo.jpg', 'https://plus.google.com/104686058496769820599', '2017-04-04 18:27:52', '2017-04-04 18:27:52', 'Viet Vu', NULL, NULL, NULL),
(2, 'google', '109005299854999698070', 'Bạch Long', 'Võ', 'dragon13294@gmail.com', 'male', 'vi', 'https://lh5.googleusercontent.com/-YxyDx7CAvd4/AAAAAAAAAAI/AAAAAAAAAPg/g2-hvUzOpbM/photo.jpg', 'https://plus.google.com/109005299854999698070', '2017-04-13 17:28:42', '2017-04-13 17:28:42', 'Bạch Long Võ', NULL, NULL, NULL),
(3, 'google', '107852579713651525882', 'nya', 'Azu', 'nyaayuu@gmail.com', NULL, 'vi', 'https://lh3.googleusercontent.com/-QuuMXwGj7nM/AAAAAAAAAAI/AAAAAAAAACI/Q1oNpGj7vNU/photo.jpg', 'https://plus.google.com/107852579713651525882', '2017-08-16 18:58:47', '2017-08-16 18:58:47', 'nya Azu', NULL, NULL, NULL),
(4, 'google', '106732056487579097666', 'Vu', 'Van Viet', 'download.mgame.us@gmail.com', NULL, 'vi', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'https://plus.google.com/106732056487579097666', '2017-08-16 22:54:32', '2017-08-16 22:54:32', 'Vu Van Viet', NULL, NULL, NULL),
(5, 'google', '110774516904027739436', 'Manga', 'Cul', 'princehvta7@gmail.com', NULL, 'vi', 'https://lh4.googleusercontent.com/-Ql0J1QaFY_g/AAAAAAAAAAI/AAAAAAAAAIE/_as_rxog-gQ/photo.jpg', 'https://plus.google.com/110774516904027739436', '2017-09-04 13:34:36', '2017-09-04 13:34:36', 'Manga Cul', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Chỉ mục cho bảng `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`folder_id`);

--
-- Chỉ mục cho bảng `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `files`
--
ALTER TABLE `files`
  MODIFY `file_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;
--
-- AUTO_INCREMENT cho bảng `folders`
--
ALTER TABLE `folders`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
