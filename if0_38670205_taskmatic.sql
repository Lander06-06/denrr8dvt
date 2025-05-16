-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql205.infinityfree.com
-- Generation Time: May 09, 2025 at 08:40 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38670205_taskmatic`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `changed_by` varchar(255) DEFAULT NULL,
  `change_time` datetime DEFAULT current_timestamp(),
  `dv_no_old` varchar(255) DEFAULT NULL,
  `dv_no_new` varchar(255) DEFAULT NULL,
  `jev_no_old` varchar(255) DEFAULT NULL,
  `jev_no_new` varchar(255) DEFAULT NULL,
  `ada_no_old` varchar(255) DEFAULT NULL,
  `ada_no_new` varchar(255) DEFAULT NULL,
  `ors_no_old` varchar(255) DEFAULT NULL,
  `ors_no_new` varchar(255) DEFAULT NULL,
  `transaction_ref_no_old` varchar(255) DEFAULT NULL,
  `transaction_ref_no_new` varchar(255) DEFAULT NULL,
  `acic_batch_no_old` varchar(255) DEFAULT NULL,
  `acic_batch_no_new` varchar(255) DEFAULT NULL,
  `t_title_old` varchar(255) DEFAULT NULL,
  `t_title_new` varchar(255) DEFAULT NULL,
  `t_description_old` text DEFAULT NULL,
  `t_description_new` text DEFAULT NULL,
  `net_amount_old` decimal(10,2) DEFAULT NULL,
  `net_amount_new` decimal(10,2) DEFAULT NULL,
  `t_start_time_old` datetime DEFAULT NULL,
  `t_start_time_new` datetime DEFAULT NULL,
  `t_end_time_old` datetime DEFAULT NULL,
  `t_end_time_new` datetime DEFAULT NULL,
  `t_user_id_old` int(11) DEFAULT NULL,
  `t_user_id_new` int(11) DEFAULT NULL,
  `payee_sms_id_old` int(11) DEFAULT NULL,
  `payee_sms_id_new` int(11) DEFAULT NULL,
  `transaction_id_old` int(11) DEFAULT NULL,
  `transaction_id_new` int(11) DEFAULT NULL,
  `t_department_id_old` int(11) DEFAULT NULL,
  `t_department_id_new` int(11) DEFAULT NULL,
  `status_old` int(11) DEFAULT NULL,
  `status_new` int(11) DEFAULT NULL,
  `location_old` int(11) DEFAULT NULL,
  `location_new` int(11) DEFAULT NULL,
  `comment_old` text DEFAULT NULL,
  `comment_new` text DEFAULT NULL,
  `created_by_old` varchar(255) DEFAULT NULL,
  `created_by_new` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info`
--

CREATE TABLE `attendance_info` (
  `aten_id` int(20) NOT NULL,
  `atn_user_id` int(20) NOT NULL,
  `in_time` varchar(200) DEFAULT NULL,
  `out_time` varchar(150) DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`aten_id`, `atn_user_id`, `in_time`, `out_time`, `total_duration`) VALUES
(48, 1, '25-03-2025 11:06:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(50) NOT NULL,
  `department_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'Office of the Regional Director'),
(2, 'ARD for Management Services'),
(3, 'ARD for Technical Services'),
(4, 'Planning and Management Division'),
(5, 'Finance Division'),
(6, 'Accounting Section'),
(7, 'Budget Section'),
(8, 'Legal Division'),
(9, 'Administrative Division'),
(10, 'Procurement Section'),
(11, 'Cashier Section'),
(12, 'Conservation and Development Division'),
(13, 'Survey and Mapping Division'),
(14, 'Licenses, Patents and Deeds Division'),
(15, 'Enforcement Division'),
(16, 'Comission on Audit'),
(17, 'National Greening Program');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `notif_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `notif_msg` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `notif_date` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`notif_id`, `task_id`, `notif_msg`, `sender_id`, `receiver_id`, `notif_date`, `is_read`) VALUES
(62, 154, 'Task #154 has been updated.', 1, 57, '2025-04-23 00:56:58', 0),
(61, 154, 'Task #154 has been updated.', 1, 55, '2025-04-23 00:56:14', 0),
(60, 154, 'Task #154 has been updated.', 1, 53, '2025-04-23 00:55:04', 0),
(59, 154, 'Task #154 has been updated.', 1, 52, '2025-04-23 00:54:44', 0),
(58, 154, 'Task #154 has been updated.', 1, 52, '2025-04-23 00:53:43', 0),
(57, 154, 'Task #154 has been updated.', 1, 55, '2025-04-23 00:48:54', 0),
(42, 150, 'Task #150 has been updated.', 64, 53, '2025-04-22 20:01:23', 0),
(43, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 20:51:32', 0),
(44, 148, 'Task #148 has been updated.', 1, 55, '2025-04-22 21:09:39', 0),
(45, 88, 'Task #88 has been updated.', 1, 64, '2025-04-22 21:09:49', 0),
(46, 149, 'Task #149 has been updated.', 1, 50, '2025-04-22 21:10:28', 0),
(47, 149, 'Task #149 has been updated.', 1, 50, '2025-04-22 21:11:45', 0),
(48, 153, 'Task #153 has been updated.', 1, 53, '2025-04-22 21:20:38', 0),
(49, 153, 'Task #153 has been updated.', 1, 53, '2025-04-22 21:21:37', 0),
(50, 153, 'Task #153 has been updated.', 1, 53, '2025-04-22 21:21:58', 0),
(51, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 21:52:49', 0),
(52, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 22:00:29', 0),
(53, 154, 'Task #154 has been updated.', 64, 56, '2025-04-22 22:12:18', 0),
(54, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 22:30:53', 0),
(55, 154, 'Task #154 has been updated.', 1, 64, '2025-04-22 22:40:47', 0),
(56, 155, 'Task #155 has been updated.', 42, 57, '2025-04-22 23:13:08', 0),
(41, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 19:55:44', 0),
(40, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 19:52:19', 0),
(39, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 19:50:21', 0),
(38, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 19:34:40', 0),
(37, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 19:33:11', 0),
(36, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 19:30:51', 0),
(35, 148, 'Task #148 has been updated.', 64, 55, '2025-04-22 19:30:04', 0),
(34, 148, 'Task #148 has been updated.', 64, 57, '2025-04-22 19:22:43', 0),
(63, 154, 'Task #154 has been updated.', 1, 56, '2025-04-23 00:58:52', 0),
(64, 154, 'Task #154 has been updated.', 1, 57, '2025-04-23 01:03:07', 0),
(65, 154, 'Task #154 has been updated.', 1, 55, '2025-04-23 01:46:38', 0),
(66, 154, 'Task #154 has been updated.', 1, 56, '2025-04-23 01:47:38', 0),
(67, 154, 'Task #154 has been updated.', 1, 56, '2025-04-23 01:48:35', 0),
(68, 154, 'Task #154 has been updated.', 1, 56, '2025-04-23 01:49:34', 0),
(69, 154, 'Task #154 has been updated.', 1, 56, '2025-04-23 01:53:03', 0),
(70, 149, 'Task #149 has been updated.', 1, 50, '2025-04-23 01:58:06', 0),
(71, 157, 'Task #157 has been updated.', 1, 64, '2025-04-23 02:07:39', 0),
(72, 165, 'Task #165 has been updated.', 1, 57, '2025-04-23 02:26:29', 0),
(73, 165, 'Task #165 has been updated.', 1, 55, '2025-04-23 02:26:47', 0),
(74, 167, 'Task #167 has been updated.', 1, 57, '2025-04-23 03:38:30', 0),
(75, 167, 'Task #167 has been updated.', 1, 57, '2025-04-23 03:39:04', 0),
(76, 167, 'Task #167 has been updated.', 1, 57, '2025-04-23 03:39:13', 0),
(77, 169, 'Task #169 has been updated.', 42, 59, '2025-04-23 04:22:04', 0),
(78, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:22:16', 0),
(79, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:23:58', 0),
(80, 168, 'Task #168 has been updated.', 42, 42, '2025-04-23 04:25:15', 0),
(81, 169, 'Task #169 has been updated.', 42, 59, '2025-04-23 04:25:28', 0),
(82, 168, 'Task #168 has been updated.', 42, 42, '2025-04-23 04:25:36', 0),
(83, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:26:17', 0),
(84, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:33:49', 0),
(85, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:33:59', 0),
(86, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 04:38:53', 0),
(87, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 05:12:59', 0),
(88, 169, 'Task #169 has been updated.', 42, 42, '2025-04-23 05:13:18', 0),
(89, 193, 'Task #193 has been updated.', 1, 58, '2025-04-23 21:27:07', 0),
(90, 211, 'Task #211 has been updated.', 1, 64, '2025-04-23 22:31:35', 0),
(91, 211, 'Task #211 has been updated.', 1, 42, '2025-04-23 23:21:23', 0),
(92, 211, 'Task #211 has been updated.', 1, 42, '2025-04-23 23:28:26', 0),
(93, 215, 'Task #215 has been updated.', 42, 66, '2025-04-24 02:17:30', 0),
(94, 215, 'Task #215 has been updated.', 42, 42, '2025-04-24 02:22:26', 0),
(95, 216, 'Task #216 has been updated.', 1, 42, '2025-04-24 02:51:33', 0),
(96, 216, 'Task #216 has been updated.', 42, 42, '2025-04-24 02:53:01', 0),
(97, 216, 'Task #216 has been updated.', 1, 72, '2025-04-24 03:18:26', 0),
(98, 217, 'Task #217 has been updated.', 1, 57, '2025-04-24 03:32:16', 0),
(99, 217, 'Task #217 has been updated.', 1, 42, '2025-04-24 03:41:32', 0),
(100, 217, 'Task #217 has been updated.', 42, 42, '2025-04-24 03:42:38', 0),
(101, 217, 'Task #217 has been updated.', 1, 72, '2025-04-24 03:43:31', 0),
(102, 217, 'Task #217 has been updated.', 1, 53, '2025-04-24 03:48:33', 0),
(103, 217, 'Task #217 has been updated.', 1, 72, '2025-04-24 03:49:03', 0),
(104, 217, 'Task #217 has been updated.', 42, 74, '2025-04-24 03:51:50', 0),
(105, 217, 'Task #217 has been updated.', 42, 53, '2025-04-24 03:54:14', 0),
(106, 217, 'Task #217 has been updated.', 1, 59, '2025-04-24 03:55:13', 0),
(107, 218, 'Task #218 has been updated.', 1, 57, '2025-04-24 04:00:57', 0),
(108, 218, 'Task #218 has been updated.', 1, 74, '2025-04-24 04:01:58', 0),
(109, 218, 'Task #218 has been updated.', 1, 74, '2025-04-24 04:03:23', 0),
(110, 218, 'Task #218 has been updated.', 1, 53, '2025-04-24 04:04:47', 0),
(111, 218, 'Task #218 has been updated.', 1, 59, '2025-04-24 04:05:41', 0),
(112, 218, 'Task #218 has been updated.', 1, 74, '2025-04-24 04:12:51', 0),
(113, 218, 'Task #218 has been updated.', 1, 74, '2025-04-24 04:19:46', 0),
(114, 218, 'Task #218 has been updated.', 1, 59, '2025-04-24 20:09:05', 0),
(115, 217, 'Task #217 has been updated.', 1, 53, '2025-04-24 20:11:36', 0),
(116, 217, 'Task #217 has been updated.', 1, 50, '2025-04-25 00:39:43', 0),
(117, 217, 'Task #217 has been updated.', 1, 74, '2025-04-25 00:45:49', 0),
(118, 227, 'Task #227 has been updated.', 1, 65, '2025-04-27 21:10:43', 0),
(119, 239, 'Task #239 has been updated.', 1, 50, '2025-04-27 21:59:49', 0),
(120, 239, 'Task #239 has been updated.', 1, 50, '2025-04-27 22:00:44', 0),
(121, 239, 'Task #239 has been updated.', 1, 50, '2025-04-28 10:01:49', 0),
(122, 236, 'Task #236 has been updated.', 1, 42, '2025-04-28 10:11:22', 0),
(123, 235, 'Task #235 has been updated.', 1, 55, '2025-04-28 10:56:11', 0),
(124, 235, 'Task #235 has been updated.', 1, 58, '2025-04-27 22:59:02', 0),
(125, 235, 'Task #235 has been updated.', 1, 58, '2025-04-28 11:00:30', 0),
(126, 234, 'Task #234 has been updated.', 1, 56, '2025-04-28 11:01:09', 0),
(127, 234, 'Task #234 has been updated.', 1, 56, '2025-04-28 11:02:32', 0),
(128, 245, 'Task #245 has been updated.', 1, 64, '2025-04-27 23:24:27', 0),
(129, 243, 'Task #243 has been updated.', 1, 320, '2025-04-27 23:43:45', 0),
(130, 246, 'Task #246 has been updated.', 1, 64, '2025-04-27 23:52:14', 0),
(131, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 00:54:51', 0),
(132, 246, 'Task #246 has been updated.', 1, 59, '2025-04-28 01:11:14', 0),
(133, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:11:32', 0),
(134, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:23:34', 0),
(135, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:23:48', 0),
(136, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:25:11', 0),
(137, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:27:19', 0),
(138, 247, 'Task #247 has been updated.', 1, 64, '2025-04-28 01:27:29', 0),
(139, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:27:38', 0),
(140, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 01:43:36', 0),
(141, 247, 'Task #247 has been updated.', 1, 64, '2025-04-28 01:50:30', 0),
(142, 246, 'Task #246 has been updated.', 1, 89, '2025-04-28 01:52:31', 0),
(143, 246, 'Task #246 has been updated.', 89, 53, '2025-04-28 13:53:10', 0),
(144, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 13:58:10', 0),
(145, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 13:59:15', 0),
(146, 246, 'Task #246 has been updated.', 1, 64, '2025-04-28 14:01:42', 0),
(147, 248, 'Task #248 has been updated.', 1, 64, '2025-04-28 02:05:26', 0),
(148, 248, 'Task #248 has been updated.', 1, 64, '2025-04-28 02:05:36', 0),
(149, 249, 'Task #249 has been updated.', 1, 64, '2025-04-28 02:38:33', 0),
(150, 249, 'Task #249 has been updated.', 1, 64, '2025-04-28 02:47:30', 0),
(151, 250, 'Task #250 has been updated.', 1, 64, '2025-04-28 02:54:00', 0),
(152, 250, 'Task #250 has been updated.', 1, 64, '2025-04-28 02:59:54', 0),
(153, 251, 'Task #251 has been updated.', 42, 42, '2025-04-28 03:10:37', 0),
(154, 251, 'Task #251 has been updated.', 42, 42, '2025-04-28 03:12:31', 0),
(155, 251, 'Task #251 has been updated.', 42, 52, '2025-04-28 03:14:03', 0),
(156, 252, 'Task #252 has been updated.', 42, 55, '2025-04-28 03:16:33', 0),
(157, 252, 'Task #252 has been updated.', 42, 42, '2025-04-28 03:16:51', 0),
(158, 251, 'Task #251 has been updated.', 1, 64, '2025-04-28 03:18:42', 0),
(159, 252, 'Task #252 has been updated.', 42, 42, '2025-04-28 03:19:09', 0),
(160, 252, 'Task #252 has been updated.', 42, 59, '2025-04-28 15:19:46', 0),
(161, 252, 'Task #252 has been updated.', 42, 42, '2025-04-28 03:21:27', 0),
(162, 251, 'Task #251 has been updated.', 1, 59, '2025-04-28 04:41:26', 0),
(163, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:47:15', 0),
(164, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:49:49', 0),
(165, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:51:01', 0),
(166, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:53:28', 0),
(167, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:55:48', 0),
(168, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:57:28', 0),
(169, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:59:38', 0),
(170, 253, 'Task #253 has been updated.', 1, 64, '2025-04-28 04:59:45', 0),
(171, 254, 'Task #254 has been updated.', 1, 58, '2025-04-28 20:59:03', 0),
(172, 254, 'Task #254 has been updated.', 1, 58, '2025-04-28 21:46:56', 0),
(173, 254, 'Task #254 has been updated.', 1, 58, '2025-04-28 21:47:59', 0),
(174, 254, 'Task #254 has been updated.', 1, 58, '2025-04-28 21:48:50', 0),
(175, 254, 'Task #254 has been updated.', 1, 58, '2025-04-28 21:49:15', 0),
(176, 254, 'Task #254 has been updated.', 1, 0, '2025-04-28 22:19:27', 0),
(177, 253, 'Task #253 has been updated.', 1, 0, '2025-04-28 22:19:51', 0),
(178, 255, 'Task #255 has been updated.', 1, 0, '2025-04-28 22:22:10', 0),
(179, 256, 'Task #256 has been updated.', 1, 0, '2025-04-28 22:23:18', 0),
(180, 257, 'Task #257 has been updated.', 1, 59, '2025-04-28 22:36:53', 0),
(181, 257, 'Task #257 has been updated.', 1, 59, '2025-04-28 22:37:13', 0),
(182, 257, 'Task #257 has been updated.', 1, 59, '2025-04-28 22:38:33', 0),
(183, 257, 'Task #257 has been updated.', 42, 42, '2025-04-28 23:08:26', 0),
(184, 257, 'Task #257 has been updated.', 42, 42, '2025-04-28 23:10:44', 0),
(185, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:12:38', 0),
(186, 257, 'Task #257 has been updated.', 42, 59, '2025-04-28 23:12:49', 0),
(187, 257, 'Task #257 has been updated.', 42, 42, '2025-04-29 11:13:22', 0),
(188, 257, 'Task #257 has been updated.', 42, 42, '2025-04-28 23:14:02', 0),
(189, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:21:39', 0),
(190, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:22:02', 0),
(191, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:22:25', 0),
(192, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:24:00', 0),
(193, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:24:28', 0),
(194, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:25:26', 0),
(195, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:28:15', 0),
(196, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:29:22', 0),
(197, 251, 'Task #251 has been updated.', 1, 59, '2025-04-28 23:30:16', 0),
(198, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:32:38', 0),
(199, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:37:38', 0),
(200, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:43:42', 0),
(201, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:48:06', 0),
(202, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:49:22', 0),
(203, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:49:42', 0),
(204, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:55:37', 0),
(205, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:55:38', 0),
(206, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:56:05', 0),
(207, 258, 'Task #258 has been updated.', 1, 32, '2025-04-28 23:57:01', 0),
(208, 258, 'Task #258 has been updated.', 1, 32, '2025-04-29 00:38:39', 0),
(209, 258, 'Task #258 has been updated.', 1, 32, '2025-04-29 00:39:20', 0),
(210, 251, 'Task #251 has been updated.', 42, 42, '2025-04-29 00:44:04', 0),
(211, 251, 'Task #251 has been updated.', 42, 42, '2025-04-29 00:44:05', 0),
(212, 258, 'Task #258 has been updated.', 1, 0, '2025-04-29 01:14:24', 0),
(213, 258, 'Task #258 has been updated.', 1, 0, '2025-04-29 01:14:46', 0),
(214, 259, 'Task #259 has been updated.', 1, 0, '2025-04-29 01:18:44', 0),
(215, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 01:40:09', 0),
(216, 260, 'Task #260 has been updated.', 1, 55, '2025-04-29 01:40:18', 0),
(217, 260, 'Task #260 has been updated.', 1, 55, '2025-04-29 01:43:43', 0),
(218, 260, 'Task #260 has been updated.', 1, 55, '2025-04-29 01:44:11', 0),
(219, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 01:44:50', 0),
(220, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 01:49:09', 0),
(221, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 01:50:55', 0),
(222, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 01:54:52', 0),
(223, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 02:02:42', 0),
(224, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 02:09:49', 0),
(225, 260, 'Task #260 has been updated.', 1, 56, '2025-04-29 02:17:23', 0),
(226, 262, 'Task #262 has been updated.', 1, 64, '2025-04-29 02:33:13', 0),
(227, 266, 'Task #266 has been updated.', 42, 57, '2025-04-29 03:04:06', 0),
(228, 266, 'Task #266 has been updated.', 42, 42, '2025-04-29 03:05:23', 0),
(229, 266, 'Task #266 has been updated.', 42, 42, '2025-04-29 15:07:41', 0),
(230, 267, 'Task #267 has been updated.', 1, 64, '2025-04-29 03:39:32', 0),
(231, 266, 'Task #266 has been updated.', 42, 42, '2025-04-29 03:45:37', 0),
(232, 267, 'Task #267 has been updated.', 64, 64, '2025-04-29 04:01:38', 0),
(233, 267, 'Task #267 has been updated.', 64, 64, '2025-04-29 04:05:59', 0),
(234, 267, 'Task #267 has been updated.', 64, 64, '2025-04-29 04:11:58', 0),
(235, 267, 'Task #267 has been updated.', 1, 64, '2025-04-29 04:14:17', 0),
(236, 251, 'Task #251 has been updated.', 42, 42, '2025-04-29 04:25:42', 0),
(237, 251, 'Task #251 has been updated.', 42, 42, '2025-04-29 04:26:25', 0),
(238, 251, 'Task #251 has been updated.', 42, 59, '2025-04-29 04:29:12', 0),
(239, 251, 'Task #251 has been updated.', 42, 53, '2025-04-29 04:31:07', 0),
(240, 251, 'Task #251 has been updated.', 42, 53, '2025-04-29 16:31:58', 0),
(241, 251, 'Task #251 has been updated.', 42, 53, '2025-04-29 04:32:35', 0),
(242, 280, 'Task #280 has been updated.', 1, 64, '2025-04-29 23:15:00', 0),
(243, 283, 'Task #283 has been updated.', 1, 64, '2025-04-29 23:18:38', 0),
(244, 283, 'Task #283 has been updated.', 1, 64, '2025-04-29 23:20:35', 0),
(245, 289, 'Task #289 has been updated.', 1, 53, '2025-04-30 01:19:27', 0),
(246, 301, 'Task #301 has been updated.', 1, 52, '2025-04-30 01:59:40', 0),
(247, 320, 'Task #320 has been updated.', 64, 59, '2025-04-30 03:33:28', 0),
(248, 320, 'Task #320 has been updated.', 64, 59, '2025-04-30 03:35:34', 0),
(249, 321, 'Task #321 has been updated.', 1, 64, '2025-04-30 03:48:23', 0),
(250, 321, 'Task #321 has been updated.', 1, 64, '2025-04-30 03:57:15', 0),
(251, 321, 'Task #321 has been updated.', 1, 64, '2025-04-30 04:02:44', 0),
(252, 321, 'Task #321 has been updated.', 1, 64, '2025-04-30 04:21:13', 0),
(253, 325, 'Task #325 has been updated.', 42, 42, '2025-05-01 23:55:49', 0),
(254, 325, 'Task #325 has been updated.', 42, 42, '2025-05-04 21:28:37', 0),
(255, 324, 'Task #324 has been updated.', 1, 53, '2025-05-05 02:07:01', 0),
(256, 332, 'Task #332 has been updated.', 56, 56, '2025-05-05 14:23:08', 0),
(257, 340, 'Task #340 has been updated.', 1, 52, '2025-05-05 21:38:24', 0),
(258, 341, 'Task #341 has been updated.', 1, 58, '2025-05-06 10:03:18', 0),
(259, 341, 'Task #341 has been updated.', 1, 58, '2025-05-05 22:05:29', 0),
(260, 336, 'Task #336 has been updated.', 1, 64, '2025-05-05 22:07:29', 0),
(261, 325, 'Task #325 has been updated.', 1, 59, '2025-05-06 02:24:22', 0),
(262, 345, 'Task #345 has been updated.', 1, 64, '2025-05-06 14:24:49', 0),
(263, 346, 'Task #346 has been updated.', 1, 58, '2025-05-06 02:25:23', 0),
(264, 348, 'Task #348 has been updated.', 64, 57, '2025-05-06 04:45:07', 0),
(265, 348, 'Task #348 has been updated.', 64, 55, '2025-05-06 21:10:54', 0),
(266, 348, 'Task #348 has been updated.', 1, 55, '2025-05-06 21:52:04', 0),
(267, 348, 'Task #348 has been updated.', 64, 321, '2025-05-06 22:01:12', 0),
(268, 345, 'Task #345 has been updated.', 1, 64, '2025-05-07 10:17:31', 0),
(269, 345, 'Task #345 has been updated.', 1, 64, '2025-05-07 10:18:41', 0),
(270, 345, 'Task #345 has been updated.', 1, 64, '2025-05-07 10:21:37', 0),
(271, 348, 'Task #348 has been updated.', 1, 321, '2025-05-06 22:24:26', 0),
(272, 348, 'Task #348 has been updated.', 1, 321, '2025-05-06 22:29:01', 0),
(273, 348, 'Task #348 has been updated.', 1, 42, '2025-05-06 22:33:38', 0),
(274, 348, 'Task #348 has been updated.', 64, 57, '2025-05-06 23:26:59', 0),
(275, 348, 'Task #348 has been updated.', 64, 57, '2025-05-06 23:27:42', 0),
(276, 348, 'Task #348 has been updated.', 64, 64, '2025-05-06 23:33:22', 0),
(277, 348, 'Task #348 has been updated.', 64, 53, '2025-05-06 23:57:24', 0),
(278, 348, 'Task #348 has been updated.', 1, 59, '2025-05-06 23:57:57', 0),
(279, 348, 'Task #348 has been updated.', 64, 53, '2025-05-06 23:58:22', 0),
(280, 348, 'Task #348 has been updated.', 64, 42, '2025-05-07 01:21:26', 0),
(281, 348, 'Task #348 has been updated.', 64, 53, '2025-05-07 01:24:44', 0),
(282, 348, 'Task #348 has been updated.', 1, 42, '2025-05-07 01:25:21', 0),
(283, 348, 'Task #348 has been updated.', 64, 53, '2025-05-07 01:25:48', 0),
(284, 348, 'Task #348 has been updated.', 64, 53, '2025-05-07 15:52:22', 0),
(285, 348, 'Task #348 has been updated.', 64, 55, '2025-05-07 03:58:30', 0),
(286, 350, 'Task #350 has been updated.', 50, 50, '2025-05-07 06:07:42', 0),
(287, 350, 'Task #350 has been updated.', 50, 58, '2025-05-07 06:08:32', 0),
(288, 350, 'Task #350 has been updated.', 1, 55, '2025-05-07 06:20:47', 0),
(289, 350, 'Task #350 has been updated.', 50, 42, '2025-05-07 06:22:17', 0),
(290, 351, 'Task #351 has been updated.', 1, 333, '2025-05-07 20:14:35', 0),
(291, 350, 'Task #350 has been updated.', 50, 60, '2025-05-07 20:37:21', 0),
(292, 362, 'Task #362 has been updated.', 58, 58, '2025-05-07 22:09:22', 0),
(293, 364, 'Task #364 has been updated.', 58, 58, '2025-05-07 22:09:55', 0),
(294, 352, 'Task #352 has been updated.', 57, 55, '2025-05-07 22:13:27', 0),
(295, 363, 'Task #363 has been updated.', 322, 58, '2025-05-07 22:13:39', 0),
(296, 352, 'Task #352 has been updated.', 57, 55, '2025-05-07 22:20:53', 0),
(297, 361, 'Task #361 has been updated.', 58, 57, '2025-05-07 22:23:09', 0),
(298, 360, 'Task #360 has been updated.', 58, 57, '2025-05-07 22:24:16', 0),
(299, 360, 'Task #360 has been updated.', 57, 55, '2025-05-07 22:25:55', 0),
(300, 352, 'Task #352 has been updated.', 55, 60, '2025-05-07 22:26:03', 0),
(301, 361, 'Task #361 has been updated.', 57, 55, '2025-05-07 22:26:20', 0),
(302, 366, 'Task #366 has been updated.', 58, 57, '2025-05-07 22:28:07', 0),
(303, 360, 'Task #360 has been updated.', 55, 55, '2025-05-07 22:28:38', 0),
(304, 364, 'Task #364 has been updated.', 58, 65, '2025-05-07 22:31:17', 0),
(305, 360, 'Task #360 has been updated.', 55, 55, '2025-05-07 22:31:34', 0),
(306, 361, 'Task #361 has been updated.', 55, 60, '2025-05-07 22:32:34', 0),
(307, 367, 'Task #367 has been updated.', 58, 342, '2025-05-07 22:34:33', 0),
(308, 360, 'Task #360 has been updated.', 55, 55, '2025-05-07 22:36:32', 0),
(309, 360, 'Task #360 has been updated.', 55, 339, '2025-05-07 22:38:41', 0),
(310, 357, 'Task #357 has been updated.', 58, 332, '2025-05-07 22:38:57', 0),
(311, 367, 'Task #367 has been updated.', 342, 342, '2025-05-07 22:39:54', 0),
(312, 359, 'Task #359 has been updated.', 58, 337, '2025-05-07 22:40:12', 0),
(313, 352, 'Task #352 has been updated.', 55, 60, '2025-05-07 22:40:22', 0),
(314, 360, 'Task #360 has been updated.', 339, 339, '2025-05-07 22:40:26', 0),
(315, 357, 'Task #357 has been updated.', 332, 58, '2025-05-07 22:41:20', 0),
(316, 359, 'Task #359 has been updated.', 337, 337, '2025-05-07 22:41:53', 0),
(317, 361, 'Task #361 has been updated.', 59, 325, '2025-05-07 22:44:30', 0),
(318, 352, 'Task #352 has been updated.', 59, 325, '2025-05-07 22:44:57', 0),
(319, 359, 'Task #359 has been updated.', 337, 58, '2025-05-07 22:45:31', 0),
(320, 357, 'Task #357 has been updated.', 1, 58, '2025-05-07 22:47:13', 0),
(321, 355, 'Task #355 has been updated.', 58, 328, '2025-05-07 22:50:40', 0),
(322, 368, 'Task #368 has been updated.', 58, 323, '2025-05-07 22:51:25', 0),
(323, 366, 'Task #366 has been updated.', 55, 60, '2025-05-07 22:52:37', 0),
(324, 359, 'Task #359 has been updated.', 58, 57, '2025-05-07 22:52:43', 0),
(325, 355, 'Task #355 has been updated.', 328, 328, '2025-05-07 22:53:10', 0),
(326, 360, 'Task #360 has been updated.', 339, 339, '2025-05-07 22:53:28', 0),
(327, 355, 'Task #355 has been updated.', 328, 58, '2025-05-07 22:53:39', 0),
(328, 360, 'Task #360 has been updated.', 339, 339, '2025-05-07 22:55:46', 0),
(329, 368, 'Task #368 has been updated.', 323, 323, '2025-05-07 22:57:03', 0),
(330, 360, 'Task #360 has been updated.', 339, 58, '2025-05-07 22:57:19', 0),
(331, 369, 'Task #369 has been updated.', 58, 57, '2025-05-07 22:58:54', 0),
(332, 366, 'Task #366 has been updated.', 59, 325, '2025-05-07 23:00:47', 0),
(333, 371, 'Task #371 has been updated.', 58, 57, '2025-05-07 23:01:48', 0),
(334, 352, 'Task #352 has been updated.', 1, 327, '2025-05-07 23:02:23', 0),
(335, 361, 'Task #361 has been updated.', 1, 327, '2025-05-07 23:03:27', 0),
(336, 352, 'Task #352 has been updated.', 1, 60, '2025-05-07 23:05:15', 0),
(337, 361, 'Task #361 has been updated.', 1, 60, '2025-05-07 23:05:34', 0),
(338, 361, 'Task #361 has been updated.', 60, 60, '2025-05-07 23:13:03', 0),
(339, 352, 'Task #352 has been updated.', 60, 60, '2025-05-07 23:13:29', 0),
(340, 352, 'Task #352 has been updated.', 60, 60, '2025-05-07 23:13:53', 0),
(341, 361, 'Task #361 has been updated.', 60, 52, '2025-05-07 23:17:22', 0),
(342, 352, 'Task #352 has been updated.', 60, 52, '2025-05-07 23:17:38', 0),
(343, 352, 'Task #352 has been updated.', 1, 52, '2025-05-08 11:18:31', 0),
(344, 374, 'Task #374 has been updated.', 1, 325, '2025-05-08 01:15:00', 0),
(345, 374, 'Task #374 has been updated.', 1, 64, '2025-05-08 01:50:42', 0),
(346, 375, 'Task #375 has been updated.', 1, 57, '2025-05-08 16:33:27', 0),
(347, 375, 'Task #375 has been updated.', 1, 0, '2025-05-08 16:38:56', 0),
(348, 376, 'Task #376 has been updated.', 1, 64, '2025-05-08 16:50:51', 0),
(349, 376, 'Task #376 has been updated.', 1, 55, '2025-05-09 08:12:07', 0),
(350, 376, 'Task #376 has been updated.', 1, 55, '2025-05-09 08:32:04', 0),
(351, 376, 'Task #376 has been updated.', 1, 55, '2025-05-09 08:35:00', 0),
(352, 376, 'Task #376 has been updated.', 1, 64, '2025-05-09 09:02:17', 0),
(353, 376, 'Task #376 has been updated.', 64, 64, '2025-05-09 09:09:31', 0),
(354, 376, 'Task #376 has been updated.', 1, 64, '2025-05-09 10:09:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `task_id` int(50) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp(),
  `nt_user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `task_id`, `message`, `status`, `created_at`, `nt_user_id`) VALUES
(20, 58, 'Task note updated for document \"Ambot hini Budoy\": need a sign', 'read', '2025-03-27 15:24:39', 29),
(21, 56, 'Document \"paper\" location changed from Enforcement to SMD', 'unread', '2025-03-27 15:24:43', 28);

-- --------------------------------------------------------

--
-- Table structure for table `payee`
--

CREATE TABLE `payee` (
  `payee_id` int(50) NOT NULL,
  `payee_sms_id` bigint(255) NOT NULL,
  `payee_name` varchar(45) NOT NULL,
  `payee_email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payee`
--

INSERT INTO `payee` (`payee_id`, `payee_sms_id`, `payee_name`, `payee_email`) VALUES
(392, 120262037000, 'SALAZAR, ARTURO N.', 'ansalazar@denr.gov.ph'),
(393, 419596418000, 'APAREJADO, MERLITA', 'merlita.aparejado@gmail.com'),
(394, 252189614000, 'REBATO, MAR FRANCIS V.', 'rebato.marfrancis.law@gmail.com'),
(395, 703722671000, 'MILLARES, REY MARK', 'millaresreymark11@gmail.com'),
(396, 402250640000, 'OGARDO, ERNESTO JR. L.', 'jtogardo2010@gmail.com'),
(397, 404087415000, 'OMOY, VIVINCIO JR.', 'vivincioomoyjr@gmail.com'),
(398, 492607837000, 'YAO, HEDY M.', 'heds.yao@gmail.com'),
(399, 906922250000, 'CALCETA, DAISY LUISA B.', 'daisyluisacalceta43@gmail.com'),
(400, 242225126000, 'CUSTODIO, NOEL HAROLD C.', 'wel_98@yahoo.com'),
(401, 628106110000, 'DEMILLO, GERALD S.', 'geralddemillo08@gmail.com'),
(402, 354363585000, 'TERADO, ESTEEVE S.', 'esteeveterado2019@gmail.com'),
(403, 179945923000, 'SUAREZ, DARIO O.', 'attydariosuarez0@gmail.com'),
(404, 285214468000, 'ABELLA , RYAN C.', 'ryanabella@gmail.com'),
(405, 135484191000, 'BELONIAS, PERLICE D.', 'beloniasperlice05@gmail.com'),
(406, 260118354000, 'CALIMBA, NIÃ‘A MARIDEL', 'ninsky82.nmac@gmail.com'),
(407, 236130966000, 'BUENA, ANGELA', 'aneub.angel@gmail.com'),
(408, 928579509000, 'CRUZADA, JULIE A.', 'cruzadaj7@gmail.com'),
(409, 188430968000, 'FERNANDICO, DERDEN', 'derdenfernandico0104@gmail.com'),
(410, 264965645000, 'MACALALAG, ARIEL N.', 'arielmcllg@gmail.com'),
(411, 411566354000, 'AMORES, RICHARD M.', 'amores79ionline@gmail.com'),
(412, 496973456000, 'ARPON, REJEAN D.', 'naejernopra@gmail.com'),
(413, 671389357000, 'BATICAN, RHEA MAE I.', 'baticanrheamae13@gmail.com'),
(414, 401848406000, 'BAUTISTA VINCENT PAUL N.', 'vincentpaulbautista2018@gmail.com'),
(415, 480949125000, 'BORJA, CHRISTIAN M.', 'christian.borja1922@gmail.com'),
(416, 613229713000, 'CAPOQUIAN, IRENE B.', 'irenecapoquian1019@gmail.com'),
(417, 645346376000, 'CUAREZ, RONA MAE A.', 'cuaresronamae@gmail.com'),
(418, 943959398000, 'DELOS SANTOS, JEANETTE M.', 'lunamilitante@gmail.com'),
(419, 624283521000, 'DE PAZ, OLIVER R.', 'olivergandeza99@gmail.com'),
(420, 941572112000, 'DEL PILAR, MARIA TEODORA S.', 'del.p.maria84@gmail.com'),
(421, 624928951000, 'GUTLAY, JETHRO C.', 'jethrogutlay14@gmail.com'),
(422, 418232895000, 'IGOT, RODEL M.', 'rodeligot89@gmail.com'),
(423, 429326773000, 'LAYOS, ANNELYN B.', 'annelyn_layos@yahoo.com.ph'),
(424, 668604393000, 'LAZADA, SANDRO S.', 'sandrolazada29@gmail.com'),
(425, 455384014000, 'MACALE, MARICOR', 'macalemaricor98@gmail.com'),
(426, 605894529000, 'OBRAR, KRISTINE JOY C.', 'kris10obrar@gmail.com'),
(427, 669283625000, 'ROCHA, MARK JOSEPH Q', 'mjqrocha37@gmail.com'),
(428, 330373408000, 'TAN, NESTOR FRANCIS JR. C.', 'nftan101010@gmail.com'),
(429, 656359417000, 'TERAZA, MARK DAVE', 'markdaveteraza@gmail.com'),
(430, 669035330000, 'VILLAREN, JHONATAN A.', 'jhonatan.villaren@gmail.com'),
(431, 136328590000, 'SUCGANG, MAITA REINA G.', 'mrgsucgang@denr.gov.ph'),
(432, 164664723000, 'BELEÃ‘A, VICENTE JR. T.', 'saodenr.8@gmail.com'),
(433, 653825417000, 'URMENETA, WINDELL MAE P.', 'urmenetawindell@gmail.com'),
(434, 185647237000, 'ABAD, AILEEN P.', 'leenfaith70@gmail.com'),
(435, 390353638000, 'ASIS, MARNI JOI M.', 'marnijoi@gmail.com'),
(436, 196300039000, 'FABRA, JACINTA URSULA O.', 'jacintafabra8@gmail.com'),
(437, 188432292000, 'LABITA, MARIO D.', 'mariolabita65@gmail.com'),
(438, 299008595000, 'AGNER, RAMIL', 'agnerramil@gmail.com'),
(439, 613924417000, 'CAMPOMANES, JERICO', 'jecocampomanes@gmail.com'),
(440, 932821326000, 'ESCOLLANTE, GEORGE R.', 'georgeescollante1974@gmail.com'),
(441, 656770794000, 'ESPINA, NEIL T.', 'espinaneil562@gmail.com'),
(442, 188438384000, 'LACANARIA, NESTOR', 'nestorlacanaria1963@gmail.com'),
(443, 612778719000, 'LEGUA, RICKY', 'leguaricky63@gmail.com'),
(444, 264417706000, 'VIERNES, ZAIDY', 'zaidyviernes@gmail.com'),
(445, 928209564000, 'PAGASARTONGA, NOVY ANN G.', 'yvonann78@gmail.com'),
(446, 456517951000, 'RIOS, PEARL ANGEL T.', 'riospearlangel@gmail.com'),
(447, 503463840000, 'CAPALAR, IVAN PHILIP M.', 'ivancapalar@yahoo.com'),
(448, 766209182000, 'DEL ROSARIO, MICA ELLA', 'micaelladelrosario7@gmail.com'),
(449, 120260697000, 'LUEGO, SUSANA P.', 'susana_luego@yahoo.com'),
(450, 185641732000, 'ABELLA, ROSALINDA V.', 'rosalinda72567@gmail.com'),
(451, 262708879000, 'REGIS, MARIA JANETTE B.', 'janette.barredo_17@yahoo.com'),
(452, 361943992000, 'BELEÃ‘A, AEMITA FAITH', 'feythfeyth211997@gmail.com'),
(453, 935574218000, 'ALGO, MARICEL A.', 'algomaricel@gmail.com'),
(454, 920095893000, 'BALUYOT, SHIRLEY A.', 'shirlbaluyot@gmail.com'),
(455, 120262623000, 'MIÃ‘OZA, MARIA HAYLE S.', 'hayleminoza1966@gmail.com'),
(456, 444177808000, 'NEGRU, ROCHELYN D.', 'rochcerna1989@gmail.com'),
(457, 718269107000, 'BINGAT, NIÃ‘A YSABEL R.', 'ysabelbingat@gmail.com'),
(458, 468029156000, 'PIJO, EMELOU P.', 'emeloupijo1@gmail.com'),
(459, 449128539000, 'ARAGO, PABLITO JR. D.', 'pablitoarago1990@gmail.com'),
(460, 303697326000, 'TAGGET, JOY P.', 'joytagget@gmail.com'),
(461, 345892816000, 'MENDIOLA, MA. URSULA R.', 'ma.ursulaRmendiola3619@gmail.com'),
(462, 329056344000, 'NUEVO, MARK ANTHONY', 'makoynuevo@185@gmail.com'),
(463, 467397560000, 'NGOHO, EVANGELINE O.', 'evangoho2016@gmail.com'),
(464, 185643724000, 'MAESTRE, MARICOR T.', 'maestremaricor@gmail.com'),
(465, 120257773000, 'BANTULA, ALMA C.', 'alma5bantula@gmail.com'),
(466, 249359078000, 'CINCO, CONRAD PAUL P.', 'con251982@gmail.com'),
(467, 941583028000, 'UYKIENG, JELMA L.', 'jeluykieng1980@gmail.com'),
(468, 436073029000, 'LIBRE, MA. JORENE', 'jorene125@gmail.com'),
(469, 262708838000, 'UDTOHAN, MA. LORENA', 'lorenaudtohan@gmail.com'),
(470, 512795942000, 'SALIPOT, GLEN MARK', 'glenmarksalipot@gmail.com'),
(471, 423592508000, 'SORIANO, KENT RAMILO Q.', 'sorkent8792@gmail.com'),
(472, 120261220000, 'PATINDOL, MARIA TERESA N.', 'tessneri27@gmail.com'),
(473, 418018951000, 'ABARQUEZ, ROMEO D. JR.', 'jhay2601@gmail.com'),
(474, 120261149000, 'AYA-AY, TERESITA P.', 'teresitaayaay96@gmail.com'),
(475, 185648666000, 'GACUS, MYLA T.', 'mylatgacus@gmail.com'),
(476, 737316877000, 'MACALE, JAMES M.', 'jamesmacale2@gmail.com'),
(477, 717227760000, 'OGABAR, NILBERT S.', 'nilbertogabar1@gmail.com'),
(478, 266309170000, 'PETITO, ANA RIZA H.', 'anarizapetito323@gmail.com'),
(479, 471283243000, 'RECOSANA, GONZALO O. JR.', 'gonzalorecosana17@gmail.com'),
(480, 266354136000, 'MACABUHAY, LAURENCE V.', 'lowrains143@gmail.com'),
(481, 188430136000, 'MELGAZO, ELIZABETH M.', 'kylssh@gmail.com'),
(482, 266353812000, 'ROBLE, MA. ANNIELYN R.', 'macrr0408@gmail.com'),
(483, 329722269000, 'GALLEGO, SARAH JANE R.', 'sarahjanegallego123@gmail.com'),
(484, 362078580000, 'REBUYAS, ANGELU L.', 'angelu.rebuyas29@gmail.com'),
(485, 940735704000, 'CHIU, VICTOR IVY L.', 'vicchiu04@gmail.com'),
(486, 707186606000, 'EBERO, ALVEN C.', 'eberoalvin@gmail.com'),
(487, 720097261000, 'CASTAÃ‘ARES, HARLENE G.', 'harlenecastanares@gmail.com'),
(488, 949055761000, 'SUYOM, SYLVAN M.', 'sylvansuyom@gmail.com'),
(489, 472347507000, 'CASCO, JODIE ELEXA O.', 'jodielexacasco@gmail.com'),
(490, 643903343000, 'LABUTAP, JESECA JESUSA P.', 'anjhelicalabutap@gmail.com'),
(491, 120260875000, 'ANSALE, NAOMI C.', 'ncansale@denr.gov.ph'),
(492, 925891510000, 'CALUB, BENJAMIN A.', 'bacalub@denr.gov.ph'),
(493, 496884894000, 'IBDAO, KENNETH D.', 'kennethduavis0208@gmail.com'),
(494, 503464646000, 'NGOHO, BABES IVY O.', 'babes.ivyngoho@gmail.com'),
(495, 120257831000, 'MEJIDO, SONIA Q.', 'sqmejido@gmail.com'),
(496, 120260509000, 'CALUMBAY, NIMFA C.', 'ncalumbay08@yahoo.com.ph'),
(497, 283807413000, 'PEROSA, REY S.', 'reyperosa23@gmail.com'),
(498, 706145624000, 'ARGOTA, SHARYN ROSE P.', 'argotasharynrose2@gmail.com'),
(499, 461078984000, 'TABASA, OLIVER KENT W.', 'iamoliverkent@gmail.com'),
(500, 340656005000, 'DELORIA, IVERT JOSEF R.', 'iamivertjosef@gmail.com'),
(501, 728307306000, 'MANITO, BELLY JEAN G.', 'bellyjean031@gmail.com'),
(502, 648719452000, 'POSTRE, JOHN EURIE N.', 'euriejohn9@gmail.com'),
(503, 167128384000, 'TERADO, ANTONIA S.', 'tonetteterado2003@yahoo.com'),
(504, 188428333000, 'PELIÃ‘O, ALVIN P.', 'nivlaonilep@gmail.com'),
(505, 932536928000, 'SABAS, JENEFER S.', 'sabasjenefer@gmail.com'),
(506, 120260445000, 'SOLIDOR, MARNALDO D.', 'butz66solidor@gmail.com'),
(507, 930945152000, 'SOLIS, MELANIE B.', 'melaniebabalcon.solis17@gmail.com'),
(508, 720475578000, 'DADO, MA.ESPERANZA P.', 'esperdado0930@gmail.com'),
(509, 1, 'VILLANUEVA, ANGELITO B.', 'angelitovillanueva1089@yahoo.com'),
(510, 142384197000, 'PASAGUI, EVA R.', 'evapasagui3@gmail.com'),
(511, 351221014000, 'ABOBO, SHIELA MAE B.', 'sheila14347@gmail.com'),
(512, 636619323000, 'CABIDOG, NORVELLE JOY V.', 'norvellejoycabidog@gmail.com'),
(513, 2, 'JAPITAN, STEPHANIE JOY B.', 'stephiejoyjapitan@gmail.com'),
(514, 935577348000, 'PICSON, VICTOR R.', 'vicpicson@gmail.com'),
(515, 536643000, 'RODRIGO, ANGEL HANNAH E.', 'angelhannahrodrigo05@gmail.com'),
(516, 299000650000, 'BERDIJO, JEANILO C.', 'jeanilocabanas1234@gmail.com'),
(517, 271180726000, 'HORTELANO, DENNIS P.', 'ursaminor07041986@gmail.com'),
(518, 776118226000, 'GODIN, DONNA ROSE E.', 'donnarosegodin@gmail.com'),
(519, 940592535000, 'TUMOLVA, ANTHONY A.', 'anthonytumolva1984@gmail.com'),
(520, 262862739000, 'VERO, MAE JOY V.', 'mjvillasica@gmail.com'),
(521, 943953916000, 'SAYONG, JENNIFER E.', 'jensayong10@gmail.com'),
(522, 415850238000, 'POLIC, ANGELIE', 'catantan221988@gmail.com'),
(523, 906941663000, 'BULAQUI, SARAH S.', 'bulaquisar2714@gmail.com'),
(524, 153504448000, 'CABIAO, CHARLOTTE B.', 'chacabiao2007@gmail.com'),
(525, 120262778000, 'DAGA, ROEL GERARDO I.', 'gerardodaga23@gmail.com'),
(526, 941572708000, 'GONZAGA, ROMADIA M.', 'romadiagonzaga@gmail.com'),
(527, 188439967000, 'PATUYAN, NILDA M.', 'nildapatuyan@gmail.com'),
(528, 472154525000, 'CALIBO, MELANIE ANNE', 'melanieannecolas.calibo@gmail.com'),
(529, 615700579000, 'UNAY, RAMON F. JR.', 'ramonjr04.unay@gmail.com'),
(530, 188424995000, 'MALIBAGO, JESEBEL T.', 'malibago_4kz@yahoo.com.ph'),
(531, 120259768000, 'TAN, REBECCA N.', 'bectan03@gmail.com'),
(532, 188424978000, 'UNAY, JESSICA F.', 'jfunay2019@gmail.com'),
(533, 403730771000, 'VICTORINO, DARRYL A.', 'lacrimagnolia@gmail.com'),
(534, 208269820000, 'AMAGO, EVELYN C.', 'ecamago2018@gmail.com'),
(535, 937153792000, 'ABASOLA, DAISY M.', 'daisy.abasola1@gmail.com'),
(536, 146718733000, 'ALORRO, ELISA C.', 'alorroelisa@gmail.com'),
(537, 906615396000, 'CINCO, VIOLINO C.', 'violinocinco3@gmail.com'),
(538, 940597258000, 'CORDERO, CLAIRE P.', 'megaclaire32@gmail.com'),
(539, 712130219000, 'DAGALEA, BRYL ADAM G.', 'bryladam.dagalea@gmail.com'),
(540, 267781428000, 'HOMERES, ANGELIE N.', 'angeliehomeres85@gmail.com'),
(541, 929618584000, 'GAGAM, RONILO T.', 'ronilogagam@gmail.com'),
(542, 481418602000, 'JAVIER, REDANILO A.', 'Rjavier78@gmail.com'),
(543, 940595618000, 'LLEGADO, MICHAEL E.', 'llegadoemichael@gmail.com'),
(544, 930071607000, 'MIÃ‘OZA, EDGAR ISAAC Y.', 'edgarisaacminoza729@gmail.com'),
(545, 298666506000, 'ROJAS, EDILBERTO U.', 'cartographer1@gmail.com'),
(546, 287787477000, 'TINDOY, CYRIL KAY C.', 'cyrilkaytindoy@gmail.com'),
(547, 400017544000, 'AGULLO, ANDREA C.', 'andreaagullo1590@gmail.com'),
(548, 188432354000, 'ANTONIO, MERLY B.', 'delacruz.merly45@gmail.com'),
(549, 930070884000, 'CORDERO, GILBERT', 'gilbertcordero45@gmail.com'),
(550, 672168343000, 'CALICOY, BLANCHE MARIE M.', 'calicoyblanchemarie@gmail.com'),
(551, 252851198000, 'CINCO, CHERYL', 'CherylCinco@gmail.com'),
(552, 330376717000, 'CHAVEZ, MARIA REGINA M.', 'mariarregchvz17@gmail.com'),
(553, 287970641000, 'GOBENCIONG, RANDAL RICK P.', 'melaniemariano4@gmail.com'),
(554, 269505901000, 'MACAROL, MARINEL', 'marinel.macorol@gmail.com'),
(555, 602463951000, 'MOSCOSA, CLARISSA CASSANDRA J.', 'februacassandra02@gmail.com'),
(556, 703837239000, 'ARALAR, MARK JOSEPH T.', 'markeytadle1984@gmail.com'),
(557, 266354273000, 'JAYME, MARITES M.', 'm2jayme@gmail.com'),
(558, 771235139000, 'LAVILLA, GERRY BOY M.', 'lavillagerryboy@gmail.com'),
(559, 121391446000, 'SOLITE, MARISSA N.', 'issa611@yahoo.com'),
(560, 920099409000, 'GARCIANO, GLENN B.', 'glennbgarciano@yahoo.com'),
(561, 473290715000, 'MERCED, LEIRA ROMERO', 'romero.leira@gmail.com'),
(562, 331116017000, 'CARTAJENA, MARVIN E.', 'cartajenamarvinebale20@gmail.com'),
(563, 932536467000, 'CUGTAS, VIRGINIO III K.', 'cdd.v.cugtas@gmai.com'),
(564, 242616855000, 'DE LA CRUZ, LETICIA S.', 'let2solondelacruz@gmail.com'),
(565, 260312077000, 'HOMERES, IRENE AGNES P.', 'ireneseremoh@gmail.com'),
(566, 185647199000, 'GAD, EDWIN A.', 'dwngad@yahoo.com'),
(567, 481022706000, 'NICOLAS, HENNY FAYE', 'hennynicolas@gmail.com'),
(568, 196289424000, 'PARMIS, GIMELINA L.', 'gimelina.parmis@gmail.com'),
(569, 188428245000, 'AMIDA, GRACE C.', 'graceamida68@gmail.com'),
(570, 468027602000, 'CAGOYONG, MARIE CRIS G.', 'mariecrisgerez07@gmail.com'),
(571, 619311615000, 'ABERGIDO, MARIA GEORGIE A.', 'georgieabergido@gmail.com'),
(572, 708625675000, 'JAIME, KARL VINCE C.', 'karlvincejaime49@gmailcom'),
(573, 653376725000, 'MATE, NEIL ALFRED M.', 'mneilalfred@gmail.com'),
(574, 266309912000, 'PETITO, FORTUNATO F.', 'fortunatopetito96@gmail.com'),
(575, 456831905000, 'SOLANO, VAL JEASON', 'valj.solano@gmail.com'),
(576, 295510077000, 'SOLEDAD, JESSA KRISTIA F.', 'ar.jksoledad@gmail.com'),
(577, 264454004000, 'SARONA, JINKY M.', 'jiboysarona@yahoo.com'),
(578, 408730963000, 'DOMING, GERLY P.', 'gerlydoming@gmail.com'),
(579, 910139131000, 'CALULO, JOY A.', 'joycalulo@gmail.com'),
(580, 166426956000, 'SAAVEDRA, ARLENE S.', 'arlenessaavedra@yahoo.com'),
(581, 495603226000, 'CABATAÃ‘A, ALLEN LOUIE S.', 'cabatanaal@gmail.com'),
(582, 654697833000, 'COCOLLO, JANELLE', 'janelle.cocollo.bses@gmail.com'),
(583, 642326542000, 'MENESES, KRIZARAH ISABEL M.', 'meneseskrizarah@gmail.com'),
(584, 740994622000, 'TOMOL, DAN GUIDO SANDY Y.', 'dan.tomol33@gmail.com'),
(585, 496979001000, 'VELARDE, ZARAH MAE G.', 'velardezarahmae@gmail.com'),
(586, 184691386000, 'VILLAMOR, DAILINDA T.', 'dailindavillamor7@gmail.com'),
(587, 331418593000, 'AMISTOSO, MARLIN BEC M.', 'amistosom05@gmail.com'),
(588, 331215381000, 'BATHAN, MA. NERESSA M.', 'neressabathan@gmail.com'),
(589, 902656062000, 'MIÃ‘OZA, JENNETH P.', 'jenminoza74@gmail.com'),
(590, 935570608000, 'MACALALAG, MICHAEL N.', 'kingkoyzforester81@gmail.com'),
(591, 196291242000, 'SACEDA, TERESA C.', 'teresa_saceda45@yahoo.com.ph'),
(592, 265433329000, 'PATINDOL, LUCKY EARLWIN N.', 'luckypatindol05@gmail.com'),
(593, 711115826000, 'CASTILLO, MIGUEL', 'miguelmcastillo41695@gmail.com'),
(594, 440749221000, 'CORAL, JOYCE JAN MIA T.', 'coraljoycejanmia@gmail.com'),
(595, 258905160000, 'NAMIT, LYDHELA A.', 'lydhelanamit@gmail.com'),
(596, 700237255000, 'OBUSA, SUNSHINE EDGAR', 'shayixedgar@gmail.com'),
(597, 273762209000, 'ROMARATE, MARIA FE', 'mariaferomarate@gmail.com'),
(598, 427437763000, 'SAAVEDRA, RONNEL', 'kkcrsaavedra@gmail.com'),
(599, 298664014000, 'VIERNES, LUZ G.', 'viernesbeth65@gmail.com'),
(600, 342056532000, 'ANGCANAN, DANILO JR.', 'angcanandanilojr1995@gmailcom'),
(601, 261434172000, 'AQUINO, MARJORY O.', 'marjory037@gmail.com'),
(602, 669137021000, 'BANAYAG, GRANT HAROLD S.', 'banayagh@gmail.com'),
(603, 608517207000, 'BENIGA, MA. JUVELLEN O.', 'benigamajuvellen@gmail.com'),
(604, 723973731000, 'DECENA, HONEY GRACE P.', 'honeygracedecena@gmail.com'),
(605, 489459620000, 'GUMATAY, VINER L.', 'vinergumataymakata10@gmail.com'),
(606, 438878921000, 'MACARIOLA, JAKE', 'jakedmacariola@gmail.com'),
(607, 341881882000, 'MABUGAY, MARILOU A.', 'mariloumabugay409@gmail.com'),
(608, 376667050000, 'PEPITO, MARIANN MAE N.', 'marrian17pd@gmailcom'),
(609, 761713622000, 'TEODOSIO, ABIGAIL', 'teodosiogail@gmail.com'),
(610, 663423268000, 'TINOS, NOEMI D.', 'tinosnoemi16@gmail.com'),
(611, 900415364000, 'POLINAR, ESTELA M.', 'estelapolinar@gmail.com'),
(612, 120261698000, 'ABOCOT, MARILOU A.', 'marilouabocot62@gmail.com'),
(613, 926684666000, 'NALDA, EUMIR M.', 'raidmluaen@gmail.com'),
(614, 120261011000, 'ABELLA, DADIVA AURA G.', 'baba63_reuben@yahoo.com'),
(615, 941579879000, 'TUPAZ, EMILY P.', 'emilytupaz01@gmail.com'),
(616, 920086567000, 'ESPINA, RAMIL S.', 'espinaramil36@gmail.com'),
(617, 291885103000, 'LACABA, LIELANI H.', 'lielanilacaba@gmail.com'),
(618, 457588274000, 'FRANCISCO, EFREN', 'foresterfrancisco25@gmail.com'),
(619, 299347887000, 'CAJANO, EDISON ALDEN', 'cajanoedison5@gmail.com'),
(620, 196291428000, 'LEPASANA, LANIE S.', 'laniesantiagolepasana@gmail.com'),
(621, 298669840000, 'SUYOM, KRISTINES M.', 'thinesmones@gmail.com'),
(622, 185652147000, 'SOLETA, NATIVIDAD L.', 'natesolet@yahoo.com'),
(623, 920096167000, 'ASOQUE, DALIA M.', 'daliamontecansa@yahoo.com'),
(624, 3, 'ORONGAN, ROMEO N.', 'romorongan@gmail.com'),
(625, 659296568000, 'CINCO, ACE PETER D.', 'acepeter.cinco.bses@gmail.com'),
(626, 761605274000, 'PALEN, CLAIRE MARIE C.', 'clairemariepalen11@gmail.com'),
(627, 622459661000, 'TAGANNA, LORRIE MAY R.', 'lorriemay.taganna24@gmail.com'),
(628, 185652106000, 'LOMANTAS, MA. TERESITA M.', 'maritesslomantas@gmail.com'),
(629, 941575670000, 'ATUEL, RANDY V.', 'larsen66616@gmail.com'),
(630, 768836651000, 'SOTTO, CHENEE', 'sottochenee1220@gmail.com'),
(631, 906925614000, 'GOLONG, MARILYN P.', 'lynpgolong@gmail.com'),
(632, 929618527000, 'LONGCOP, DELFIN J. JR.', 'longcopdelfin@gmail.com'),
(633, 926673827000, 'OCHEA MARIA JOAN C.', 'aliyahochea@gmail.com'),
(634, 120262680000, 'ALASKA, CAMILO M.', 'calaska13@gmail.com'),
(635, 322644564000, 'ROBEL, JETT FLORIAN REY L.', 'robel.jettflorianrey.jd@gmail.com'),
(636, 492750021000, 'HUERTA, LUCIL D.', 'huertalucil@gmail.com'),
(637, 277720014000, 'VERBO, PAUL B.', 'paulsy52@gmail.com'),
(638, 654124546000, 'SALDAÃ‘A,CRISTINE JOY M.', 'cristinejoymsaldana.29@gmail.com'),
(639, 466866017000, 'CAMPANER, WINSTON N.', 'waynewyanet88@gmail.com'),
(640, 243224819000, 'PAREDES, KENT C.', 'kent198554@gmail.com'),
(641, 432535040000, 'SABANDEJA, LOUIE', 'louiesabandeja1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

CREATE TABLE `task_info` (
  `task_id` int(11) NOT NULL,
  `dv_no` varchar(50) DEFAULT NULL,
  `jev_no` varchar(50) DEFAULT NULL,
  `ada_no` varchar(50) DEFAULT NULL,
  `ors_no` varchar(50) DEFAULT NULL,
  `transaction_ref_no` varchar(50) DEFAULT NULL,
  `acic_batch_no` varchar(50) DEFAULT NULL,
  `pr_no` varchar(255) NOT NULL,
  `po_no` varchar(255) NOT NULL,
  `form_no` varchar(255) NOT NULL,
  `t_title` varchar(120) NOT NULL,
  `t_description` text DEFAULT NULL,
  `net_amount` decimal(15,2) NOT NULL,
  `gross_amount` decimal(15,2) NOT NULL,
  `t_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `t_end_time` varchar(100) DEFAULT NULL,
  `t_user_id` int(20) NOT NULL,
  `payee_sms_id` bigint(255) NOT NULL,
  `transaction_id` int(50) NOT NULL,
  `t_department_id` int(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = incomplete, 1 = In progress, 2 = complete',
  `location` int(11) NOT NULL DEFAULT 0 COMMENT '0=Finance and so on',
  `comment` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `dv_no`, `jev_no`, `ada_no`, `ors_no`, `transaction_ref_no`, `acic_batch_no`, `pr_no`, `po_no`, `form_no`, `t_title`, `t_description`, `net_amount`, `gross_amount`, `t_start_time`, `t_end_time`, `t_user_id`, `payee_sms_id`, `transaction_id`, `t_department_id`, `status`, `location`, `comment`, `created_by`, `updated_at`) VALUES
(376, '25-05-1403', '', '', '', '', '', '', '', '', '', 'sabsjfksafjsafsksafsajkfbjksabfjksbff\r\nassakfnsjfkjsabfjksabjkfbjksabfjkasksf\r\nfasbkjfbsajkfjksabfjkaskjfbaskfbjkasbfjkasbf\r\nfasjkfasjkfjkasbfkjasbjfbasjkbfjksabf', '0.00', '0.00', '2025-05-08 08:39:00', NULL, 64, 728307306000, 3, 7, 0, 0, '', 1, '2025-05-09 02:09:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `user_id` int(20) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `department_id` int(50) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `user_role` int(10) NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `department_id`, `temp_password`, `user_role`, `profile_image`) VALUES
(1, 'ADMINISTRATOR', 'administrator', 'kujanzaca@gmail.com', 'cd92a26534dba48cd785cdcc0b3e6bd1', 0, NULL, 1, 'assets/img/1746757396_Untitled design (1).png'),
(336, 'MARIE CRIS G. CAGOYONG', 'Marie.Cagoyong', 'mariecrisgerez07@gmail.com', '924c488cbf4a98e4fbb5f4683f970615', 12, '2975528', 2, 'assets/img/1746665443_denr.jpg'),
(42, 'Rey Perosa', 'Rey.Perosa', 'reyperosa23@gmail.com', '1b0c76822530dd90ad0d1c36ec8c201f', 6, '', 2, 'assets/img/rey.jpg'),
(50, 'Belly Jean Manito', 'BellyJean.Manito', 'bellyjean031@gmail.com', 'c33367701511b4f6020ec61ded352059', 6, '', 2, 'assets/img/1746609779_Logo.jpg'),
(64, 'Lander Mendigorin', 'Lander.Mendigorin', 'mendigorinlander732@gmail.com', '58daad699799029139cd5fdb9edb9b6a', 7, '', 2, 'assets/img/1745975515_financeavatar.jpg'),
(52, 'Rosalinda V. Abella', 'Rosalinda.Abella', 'rosalinda72567@gmail.com', 'fafc7f92921deeb9de2f58c3eca6ebcd', 11, '4000326', 2, ''),
(53, 'Susana P. Luego', 'Susana.Luego', 'susana_luego@yahoo.com', '11b603bd91c09cf1fceb4d6bec497dea', 11, '1402991', 2, ''),
(55, 'Sharyn Argota - Accounting', 'Sharyn', 'argotasharynrose2@gmail.com', '5b53c675ecb13720e7339b045eccf32c', 6, '', 2, 'assets/img/sharyn.jpg'),
(56, 'Ivert Deloria', 'Ivert', 'iamivertjosef@gmail.com', '2e588de54d8f482a82e274bcfab65e04', 6, '', 2, 'assets/img/ivert.jpg'),
(57, 'John Eurie Postre - Accounting', 'Eurie', 'euriejohn9@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 6, '', 2, 'assets/img/euri.jpg'),
(58, 'Esperanza Dado - Budget Section', 'Ezperanza', 'esperdado0930@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 7, '', 2, 'assets/img/espe.jpg'),
(59, 'Hazel R. Costin', 'Hazel.Costin', 'hazelreascostin@gmail.com', 'b28726656f217dec521d3df9f663028c', 6, '', 2, 'assets/img/hazel.jpg'),
(60, 'Alyssa Joy P. Dela Cruz', 'Alyssa.Delacruz', 'dalyssa856@gmail.com', '10d85d7664a911bcaec89732098c269a', 6, '', 2, 'assets/img/allysa.jpg'),
(335, 'MARIA FE ROMARATE', 'Maria.Romarate', 'mariaferomarate@gmail.com', 'dc29fa15e182928b8bf6452c92ea68b2', 12, '5305863', 2, 'assets/img/1746665384_denr.jpg'),
(65, 'Oliver Kent W. Tabasa', 'Oliver.Tabasa', 'iamoliverkent@gmail.com', '4144ea766a40709f47db50bd094867ae', 6, '', 2, 'assets/img/1745471118_oliver.jpg'),
(66, 'Glenmark Salipot', 'Glenmark.Salipot', 'salipotglenmark@gmail.com', 'b807229066224aa6bf4d9b5660e2d13a', 10, '', 2, 'assets/img/1745473584_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(67, 'Ma. Jorene P. Libre', 'Jorene.Libre', 'jorene125@gmail.com', '3da9f6ae0ace6fd52391e0a4dc32359e', 10, '', 2, 'assets/img/1745473936_4f7ee4bd-1234-4f19-ae95-574d859b95b8.jpg'),
(68, 'MA LORENA UDTOHAN', 'Lorena.udtohan', 'lorenaudtohan@gmail.com', '861bed2bffff112eda724e46bbc026f2', 10, '5193381', 2, 'assets/img/1745474225_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(69, 'KENT RAMILO SORIANO', 'Kent.Soriano', 'sorkent8792@gmail.com', '3c2e77e4585421254c228afe79377fb2', 10, '1889978', 2, 'assets/img/1745474394_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(70, 'Conrad Paul P. Cinco', 'Conrad.Cinco', 'bac.r8@denr.gov.ph', '83280b5fee78cbb6570f1eaa50a64c56', 10, '', 2, 'assets/img/1745474541_bfdf0e4f-5e5f-409a-9342-7412d4ae1d51.jpg'),
(71, 'Marni Joi M. Asis', 'marnijoi.asis', 'gssdenr8.2@gmail.com', '6cdc8faff0a74f03e5db084ccdb4fd20', 9, '', 2, 'assets/img/1745477001_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(72, 'Angela S. Buena', 'angela.buena', 'aneub.angel@gmail.com', '6249068e4a69ce90bfa55c0a2c662918', 2, '', 2, 'assets/img/1745478779_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(73, 'NiÃ±a Maridel Calimba', 'NiÃ±a.Calimba', 'ninsky82.nmac@gmail.com', '96da8b36d29921057cf4814e29069464', 2, '', 2, 'assets/img/1745480145_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(74, 'Dario O. Suarez', 'Dario.Saurez', 'oardms2023@gmail.com', '81afdeb4aa0f92c619b3437a5979a4ce', 2, '7327740', 2, 'assets/img/1745481064_ab7e19a2-2955-4811-ab77-6c07758fd147.jpg'),
(321, 'Cristine Joy M. SaldaÃ±a', 'Christine.SaldaÃ±a', 'enforcement.r8@denr.gov.ph', '5cb17236462280c91d213158e49f6037', 15, '4139765', 2, 'assets/img/1746583053_denr.jpg'),
(322, 'GERALD S. DEMILLO', 'Geral.Demillo', 'geralddemillo08@gmail.com', '223a5f74be82f3fe2c7e5f81aec4850d', 16, '', 2, 'assets/img/1746606737_denr.jpg'),
(323, 'NILBERT S. OGABAR', 'Nilbert.Ogabar', 'nilbertogabar1@gmail.com', '73920d511af4614966c2abd82391b8b4', 4, '', 2, 'assets/img/1746606966_denr.jpg'),
(324, 'BABES IVY O. NGOHO', 'BabesIvy.Ngoho', 'babes.ivyngoho@gmail.com', 'e73b54cee85e3467feb4c712c9235577', 4, '5456205', 2, 'assets/img/1746607080_denr.jpg'),
(325, 'PERLICE D. BELONIAS', 'Perlice.Belonias', 'beloniasperlice05@gmail.com', 'c9b1c885682159374c399ea2ab5c582c', 2, '', 2, 'assets/img/1746607203_denr.jpg'),
(326, 'SHIRLEY A. BALUYOT', 'Shirley.Baluyot', 'shirlbaluyot@gmail.com', '57dae41da705509505c689e08da5abbe', 9, '', 2, 'assets/img/1746607532_denr.jpg'),
(327, 'AEMITA FAITH BELEÃ‘A', 'Aemita.BeleÃ±a', 'feythfeyth211997@gmail.com', '4123eb683492274a7d58c3e5f6411c0e', 9, '575389', 2, 'assets/img/1746607646_denr.jpg'),
(328, 'HEDY M. YAO', 'Hedy.Yao', 'heds.yao@gmail.com', '92a130c12c7cecee7887cbf6a2cb9e0e', 1, '', 2, 'assets/img/1746607777_denr.jpg'),
(329, 'JENNIFER E. SAYONG', 'Jennifer.Sayong', 'jensayong10@gmail.com', '92253ca7f296fdfa23e4d96e3fafcd10', 13, '3162603', 2, 'assets/img/1746607939_denr.jpg'),
(330, 'MELANIE ANNE CALIBO', 'MelanieAnne.Calibo', 'melanieannecolas.calibo@gmail.com', 'cef3366d676ae574b763db07c54d1e93', 13, '', 2, 'assets/img/1746608023_denr.jpg'),
(331, 'ANDREA C. AGULLO', 'Andrea.Agullo', 'andreaagullo1590@gmail.com', 'cd11adbd8352fcea28774a32ece594f3', 13, '5147745', 2, 'assets/img/1746608086_denr.jpg'),
(332, 'EUMIR M. NALDA', 'Eumir.Nalda', 'raidmluaen@gmail.com', '089b1f57fea8fbbe8cc776ebb872ad06', 14, '', 2, 'assets/img/1746608258_denr.jpg'),
(333, 'EMILY P. TUPAZ', 'Emily.Tupaz', 'emilytupaz01@gmail.com', 'b7d26e7566814904a162247d9bb0fc55', 14, '5563476', 2, 'assets/img/1746608299_denr.jpg'),
(334, 'Merlita A. Aparejado', 'Reymark.Millares', 'millaresreymark11@gmail.com', 'ce86050d634a80d87a8ad123c383356f', 1, '', 2, 'assets/img/1746665112_denr.jpg'),
(337, 'LYN M. VIÃ‘AS', 'Lyn.ViÃ±as', 'denr8.legaldivision@gmail.com', '4bca3651c8c7480d2c01a63947879a74', 8, '', 2, 'assets/img/1746667192_462548139_863560998931319_3767426136905159573_n.jpg'),
(339, 'KRISTINE JOY OBRAR', 'Kristine.Obrar', 'denr.ngpregionaloffice8@gmail.com', '5bac58d47702fa467cd439a636f051a2', 17, '', 2, 'assets/img/1746669159_HRC.jpg'),
(340, 'STEPHANIE JOY B. JAPITAN', 'Stephanie.Japitan', 'ardtechnicalservicesr8@gmail.com', 'e2c16bb959d760b93cfbd75281f5f8fd', 3, '', 2, 'assets/img/1746669249_HRC.jpg'),
(341, 'WINSTON CAMPANER', 'Winston.Campaner', 'waynewyanet888@gmail.com', '619da956b714a5fd1cfff3bf97a7189b', 15, '', 2, 'assets/img/1746669338_HRC.jpg'),
(342, 'MELISSA CENTENAJE', 'Melissa.Centenaje', 'mscentenaje0207@gmail.com', '9923b085274c7f80dfa20e5125d20c19', 13, '', 2, 'assets/img/1746670057_Screenshot 2025-03-16 140245.png'),
(343, 'Lucky Erwin Patindol', 'Lucky.Patindol', 'luckypatindol105@gmail.com', 'bff53cf83308d08886550168fc6aa091', 12, '', 2, 'assets/img/1746678167_360_F_571060336_lRFo9ZoUUYDzcKb6dHKMs8unl2TM98rr.jpg'),
(344, 'Mark Anthony Nuevo', 'Mark.Nuevo', 'makoynuevo185@gmail.com', '46b44303ff95261f1dc67f73f5d7a68a', 9, '', 2, 'assets/img/1746678992_ADR SINTRA BOARD R8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(50) NOT NULL,
  `transaction_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `transaction_type`) VALUES
(1, 'Allowances/Bonuses/Honorania/Compensation/Others'),
(2, 'Cash Advance (Prepayments)'),
(3, 'Cash Advance (SDO)'),
(4, 'General Services'),
(5, 'Other Professional Services'),
(6, 'Procurement'),
(7, 'Refund'),
(8, 'Registration Fees'),
(9, 'Remittances'),
(10, 'Salaries and Wages'),
(11, 'Travelling Expenses'),
(12, 'Utility Expenses (Bills)'),
(13, 'Terminal Leave'),
(14, 'Monetization');

-- --------------------------------------------------------

--
-- Table structure for table `transmittal_report`
--

CREATE TABLE `transmittal_report` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transmittal_report`
--

INSERT INTO `transmittal_report` (`id`, `task_id`, `updated_by`, `update_time`) VALUES
(534, 376, '1', '2025-05-09 10:09:19'),
(533, 376, '64', '2025-05-09 09:09:31'),
(532, 376, '1', '2025-05-09 09:02:17'),
(531, 376, '1', '2025-05-09 08:35:00'),
(530, 376, '1', '2025-05-09 08:32:04'),
(529, 376, '1', '2025-05-09 08:12:07'),
(528, 376, '1', '2025-05-08 16:50:51'),
(527, 376, '1', '2025-05-08 16:40:10'),
(526, 375, '1', '2025-05-08 16:38:56'),
(525, 375, '1', '2025-05-08 16:33:27'),
(524, 375, '1', '2025-05-08 16:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `uploaded_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `payee`
--
ALTER TABLE `payee`
  ADD PRIMARY KEY (`payee_id`);

--
-- Indexes for table `task_info`
--
ALTER TABLE `task_info`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_admin_department` (`department_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transmittal_report`
--
ALTER TABLE `transmittal_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`uploaded_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `payee`
--
ALTER TABLE `payee`
  MODIFY `payee_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=642;

--
-- AUTO_INCREMENT for table `task_info`
--
ALTER TABLE `task_info`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transmittal_report`
--
ALTER TABLE `transmittal_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=535;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `uploaded_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
