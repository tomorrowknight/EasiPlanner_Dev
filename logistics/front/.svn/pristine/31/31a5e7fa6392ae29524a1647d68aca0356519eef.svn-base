-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2015 at 06:58 AM
-- Server version: 5.5.8
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `logistics.front`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `licence` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `user_id`, `username`, `password`, `licence`, `lat`, `lng`) VALUES
(1, 0, 'jack@gmail.com', '111', '', NULL, NULL),
(2, 1, 'jack3@gmail.com', '111', '', NULL, NULL),
(3, 1, 'jack@gmail.com', '111', '', NULL, NULL),
(4, 6, 'Driver1@gmail.com', '111', '', NULL, NULL),
(5, 7, 'Jacky', '111', '2A,2B', NULL, NULL),
(6, 7, 'Sammy', '111', '2B', NULL, NULL),
(7, 7, 'Tom', '1234', 'C', NULL, NULL),
(8, 8, 'tom', '111', '2A', 1.333, 103.711),
(9, 8, 'Jack', '111', '2B', 1.40165, 103.863),
(10, 8, 'Welson', '111', '2B', 1.31584, 103.799);

-- --------------------------------------------------------

--
-- Table structure for table `horizon`
--

CREATE TABLE IF NOT EXISTS `horizon` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) CHARACTER SET latin1 NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1421647140),
('m140524_153638_init_user', 1421647145),
('m140524_153642_init_user_auth', 1421647145);

-- --------------------------------------------------------

--
-- Table structure for table `parcel`
--

CREATE TABLE IF NOT EXISTS `parcel` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal` varchar(6) NOT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `volume` float NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `service_time` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `deliver_time` datetime DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `customer_name` varchar(122) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `window_start` datetime DEFAULT NULL,
  `window_end` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parcel`
--

INSERT INTO `parcel` (`id`, `user_id`, `vehicle_id`, `identifier`, `address`, `postal`, `lat`, `lng`, `volume`, `weight`, `service_time`, `note`, `deliver_time`, `phone`, `customer_name`, `status`, `window_start`, `window_end`) VALUES
(1, 8, 3, '1', 'Singapore 375042', '375042', 1.4506, 103.819, 0.97, 0.36, 30, NULL, NULL, '84847475', 'Customer 84847475', 0, '2015-05-08 09:00:00', '2015-05-08 11:00:00'),
(2, 8, 0, '2', 'Singapore 262872', '262872', 1.32241, 103.944, 0.7, 0.71, 30, NULL, NULL, '92290116', 'Customer 92290116', 0, '2015-05-08 17:00:00', '2015-05-08 18:00:00'),
(3, 8, 0, '3', 'Singapore 971600', '971600', 1.36999, 103.893, 0.85, 0.84, 30, NULL, NULL, '92290116', 'Customer 92290116', 0, '2015-05-08 16:00:00', '2015-05-08 18:00:00'),
(4, 8, 0, '4', 'Singapore 785601', '785601', 1.28941, 103.821, 0.63, 0.57, 10, NULL, NULL, '81131197', 'Customer 81131197', 0, '2015-05-08 19:00:00', '2015-05-08 21:00:00'),
(5, 8, 0, '5', 'Singapore 239251', '239251', 1.29202, 103.818, 0.78, 0.27, 30, NULL, NULL, '81212366', 'Customer 81212366', 0, '2015-05-08 19:00:00', '2015-05-08 20:00:00'),
(6, 8, 0, '6', 'Singapore 316925', '316925', 1.31763, 103.852, 0.5, 0.77, 10, NULL, NULL, '81212366', 'Customer 81212366', 0, '2015-05-08 12:00:00', '2015-05-08 13:00:00'),
(7, 8, 0, '7', 'Singapore 652996', '652996', 1.36183, 103.891, 0.51, 0.42, 20, NULL, NULL, '81212366', 'Customer 81212366', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(8, 8, 3, '8', 'Singapore 431842', '431842', 1.44163, 103.773, 0.04, 0.05, 20, NULL, NULL, '83169382', 'Customer 83169382', 0, '2015-05-08 14:00:00', '2015-05-08 16:00:00'),
(9, 8, 0, '9', 'Singapore 187835', '187835', 1.27715, 103.829, 0.8, 0.02, 10, NULL, NULL, '84999295', 'Customer 84999295', 0, '2015-05-08 19:00:00', '2015-05-08 20:00:00'),
(10, 8, 0, '10', 'Singapore 905352', '905352', 1.32917, 103.886, 0.01, 0.17, 30, NULL, NULL, '84999295', 'Customer 84999295', 0, '2015-05-08 15:00:00', '2015-05-08 17:00:00'),
(11, 8, 0, '11', 'Singapore 418768', '418768', 1.36663, 103.841, 0.39, 0.84, 30, NULL, NULL, '86505351', 'Customer 86505351', 0, '2015-05-08 10:00:00', '2015-05-08 11:00:00'),
(12, 8, 0, '12', 'Singapore 612457', '612457', 1.43944, 103.839, 0.16, 0.87, 10, NULL, NULL, '90063541', 'Customer 90063541', 0, '2015-05-08 15:00:00', '2015-05-08 16:00:00'),
(13, 8, 0, '13', 'Singapore 220794', '220794', 1.42006, 103.832, 0.04, 0.62, 10, NULL, NULL, '90232661', 'Customer 90232661', 0, '2015-05-08 18:00:00', '2015-05-08 19:00:00'),
(14, 8, 0, '14', 'Singapore 228155', '228155', 1.36479, 103.849, 0.25, 0.91, 10, NULL, NULL, '90278299', 'Customer 90278299', 0, '2015-05-08 19:00:00', '2015-05-08 21:00:00'),
(15, 8, 0, '15', 'Singapore 268914', '268914', 1.4296, 103.845, 0.5, 0.11, 10, NULL, NULL, '90286683', 'Customer 90286683', 0, '2015-05-08 09:00:00', '2015-05-08 10:00:00'),
(16, 8, 0, '16', 'Singapore 427447', '427447', 1.43464, 103.837, 0.01, 0.04, 20, NULL, NULL, '90286683', 'Customer 90286683', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(17, 8, 0, '17', 'Singapore 338128', '338128', 1.35445, 103.751, 0.5, 0.06, 10, NULL, NULL, '91632663', 'Customer 91632663', 0, '2015-05-08 09:00:00', '2015-05-08 10:00:00'),
(18, 8, 0, '18', 'Singapore 985333', '985333', 1.38913, 103.742, 0.2, 1, 10, NULL, NULL, '91887652', 'Customer 91887652', 0, '2015-05-08 09:00:00', '2015-05-08 10:00:00'),
(19, 8, 0, '19', 'Singapore 203436', '203436', 1.36668, 103.895, 0.82, 0.22, 20, NULL, NULL, '92290116', 'Customer 92290116', 0, '2015-05-08 08:00:00', '2015-05-08 10:00:00'),
(20, 8, 0, '20', 'Singapore 776812', '776812', 1.30264, 103.862, 0.57, 0.55, 20, NULL, NULL, '92364198', 'Customer 92364198', 0, '2015-05-08 09:00:00', '2015-05-08 10:00:00'),
(21, 8, 0, '21', 'Singapore 539837', '539837', 1.37733, 103.836, 0.18, 0.34, 10, NULL, NULL, '92725280', 'Customer 92725280', 0, '2015-05-08 13:00:00', '2015-05-08 15:00:00'),
(22, 8, 0, '22', 'Singapore 476885', '476885', 1.37458, 103.84, 0.87, 0.43, 10, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 18:00:00', '2015-05-08 19:00:00'),
(23, 8, 0, '23', 'Singapore 222332', '222332', 1.39322, 103.907, 0.35, 0.17, 30, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 14:00:00', '2015-05-08 16:00:00'),
(24, 8, 0, '24', 'Singapore 760552', '760552', 1.42141, 103.847, 0.85, 0.4, 20, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 12:00:00', '2015-05-08 14:00:00'),
(25, 8, 0, '25', 'Singapore 825921', '825921', 1.43673, 103.831, 0.08, 0.47, 20, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 09:00:00', '2015-05-08 10:00:00'),
(26, 8, 3, '26', 'Singapore 502813', '502813', 1.43683, 103.799, 0.26, 0.21, 10, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 17:00:00', '2015-05-08 19:00:00'),
(27, 8, 3, '27', 'Singapore 325604', '325604', 1.43853, 103.779, 0.11, 0.97, 30, NULL, NULL, '92965584', 'Customer 92965584', 0, '2015-05-08 13:00:00', '2015-05-08 15:00:00'),
(28, 8, 0, '28', 'Singapore 378668', '378668', 1.316, 103.846, 0.85, 0.6, 10, NULL, NULL, '93364639', 'Customer 93364639', 0, '2015-05-08 16:00:00', '2015-05-08 18:00:00'),
(29, 8, 0, '29', 'Singapore 296380', '296380', 1.32943, 103.887, 0.2, 0.44, 20, NULL, NULL, '94558100', 'Customer 94558100', 0, '2015-05-08 19:00:00', '2015-05-08 21:00:00'),
(30, 8, 0, '30', 'Singapore 163116', '163116', 1.31172, 103.896, 0.37, 0.33, 10, NULL, NULL, '96817775', 'Customer 96817775', 0, '2015-05-08 11:00:00', '2015-05-08 12:00:00'),
(31, 8, 0, '31', 'Singapore 513250', '513250', 1.33794, 103.7, 0.09, 0.61, 10, NULL, NULL, '96817775', 'Customer 96817775', 0, '2015-05-08 14:00:00', '2015-05-08 16:00:00'),
(32, 8, 0, '32', 'Singapore 531158', '531158', 1.35976, 103.833, 0.57, 0.14, 20, NULL, NULL, '96839763', 'Customer 96839763', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(33, 8, 0, '33', 'Singapore 751214', '751214', 1.35962, 103.952, 0.53, 0.25, 20, NULL, NULL, '97297018', 'Customer 97297018', 0, '2015-05-08 09:00:00', '2015-05-08 11:00:00'),
(34, 8, 0, '34', 'Singapore 357794', '357794', 1.38311, 103.839, 0.2, 0.79, 30, NULL, NULL, '97478147', 'Customer 97478147', 0, '2015-05-08 14:00:00', '2015-05-08 16:00:00'),
(35, 8, 3, '35', 'Singapore 785272', '785272', 1.44327, 103.805, 0.28, 0.1, 20, NULL, NULL, '97654270', 'Customer 97654270', 0, '2015-05-08 17:00:00', '2015-05-08 19:00:00'),
(36, 8, 3, '36', 'Singapore 318023', '318023', 1.45496, 103.817, 0.01, 0.02, 10, NULL, NULL, '98200661', 'Customer 98200661', 0, '2015-05-08 14:00:00', '2015-05-08 15:00:00'),
(37, 8, 0, '37', 'Singapore 390423', '390423', 1.30405, 103.832, 0.09, 0.91, 10, NULL, NULL, '98509292', 'Customer 98509292', 0, '2015-05-08 15:00:00', '2015-05-08 16:00:00'),
(38, 8, 0, '38', 'Singapore 186846', '186846', 1.26661, 103.81, 0.74, 0.59, 30, NULL, NULL, '98525624', 'Customer 98525624', 0, '2015-05-08 17:00:00', '2015-05-08 19:00:00'),
(39, 8, 0, '39', 'Singapore 241668', '241668', 1.28015, 103.852, 0.7, 0.43, 20, NULL, NULL, '98525624', 'Customer 98525624', 0, '2015-05-08 15:00:00', '2015-05-08 17:00:00'),
(40, 8, 0, '40', 'Singapore 639263', '639263', 1.43327, 103.829, 0.16, 0.25, 10, NULL, NULL, '98535569', 'Customer 98535569', 0, '2015-05-08 19:00:00', '2015-05-08 20:00:00'),
(41, 8, 0, '41', 'Singapore 114007', '114007', 1.31696, 103.875, 0.86, 0.41, 10, NULL, NULL, '84882750', 'Customer 84882750', 0, '2015-05-08 13:00:00', '2015-05-08 15:00:00'),
(42, 8, 0, '42', 'Singapore 550274', '550274', 1.36654, 103.962, 0.01, 0.74, 20, NULL, NULL, '90678356', 'Customer 90678356', 0, '2015-05-08 18:00:00', '2015-05-08 20:00:00'),
(43, 8, 0, '43', 'Singapore 682440', '682440', 1.35551, 103.886, 0.33, 0.6, 30, NULL, NULL, '92290116', 'Customer 92290116', 0, '2015-05-08 08:00:00', '2015-05-08 10:00:00'),
(44, 8, 0, '44', 'Singapore 594879', '594879', 1.37031, 103.881, 0.04, 0.82, 30, NULL, NULL, '96663686', 'Customer 96663686', 0, '2015-05-08 20:00:00', '2015-05-08 21:00:00'),
(45, 8, 0, '45', 'Singapore 821966', '821966', 1.42939, 103.835, 0.85, 0.75, 10, NULL, NULL, '96728468', 'Customer 96728468', 0, '2015-05-08 15:00:00', '2015-05-08 16:00:00'),
(46, 8, 0, '46', 'Singapore 548077', '548077', 1.37187, 103.855, 0.99, 0.24, 20, NULL, NULL, '96919003', 'Customer 96919003', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(47, 8, 0, '47', 'Singapore 307586', '307586', 1.39599, 103.906, 0.18, 0.62, 30, NULL, NULL, '96990189', 'Customer 96990189', 0, '2015-05-08 18:00:00', '2015-05-08 20:00:00'),
(48, 8, 0, '48', 'Singapore 184869', '184869', 1.33829, 103.844, 0.63, 0.74, 30, NULL, NULL, '98478537', 'Customer 98478537', 0, '2015-05-08 18:00:00', '2015-05-08 19:00:00'),
(49, 8, 0, '49', 'Singapore 714300', '714300', 1.35783, 103.748, 0.06, 0.94, 30, NULL, NULL, '98807305', 'Customer 98807305', 0, '2015-05-08 11:00:00', '2015-05-08 12:00:00'),
(50, 8, 0, '50', 'Singapore 180255', '180255', 1.31128, 103.861, 0.7, 0.08, 10, NULL, NULL, '98809392', 'Customer 98809392', 0, '2015-05-08 18:00:00', '2015-05-08 19:00:00'),
(51, 8, 0, '51', 'Singapore 917108', '917108', 1.32007, 103.869, 0.25, 0.48, 30, NULL, NULL, '91860119', 'Customer 91860119', 0, '2015-05-08 17:00:00', '2015-05-08 19:00:00'),
(52, 8, 0, '52', 'Singapore 309234', '309234', 1.32733, 103.891, 0.94, 1, 10, NULL, NULL, '93874518', 'Customer 93874518', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(53, 8, 0, '53', 'Singapore 691009', '691009', 1.37044, 103.849, 0.49, 0.98, 30, NULL, NULL, '96990189', 'Customer 96990189', 0, '2015-05-08 11:00:00', '2015-05-08 13:00:00'),
(54, 8, 0, '54', 'Singapore 346807', '346807', 1.43925, 103.83, 0.12, 0.26, 10, NULL, NULL, '96990189', 'Customer 96990189', 0, '2015-05-08 09:00:00', '2015-05-08 11:00:00'),
(55, 8, 0, '55', 'Singapore 711004', '711004', 1.31358, 103.765, 0.54, 0.18, 10, NULL, NULL, '96664488', 'Customer 96664488', 0, '2015-05-08 14:00:00', '2015-05-08 16:00:00'),
(56, 8, 0, '56', 'Singapore 967974', '967974', 1.37498, 103.771, 0.97, 0.6, 10, NULL, NULL, '98807305', 'Customer 98807305', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(57, 8, 0, '57', 'Singapore 752093', '752093', 1.2866, 103.809, 0.14, 0.85, 20, NULL, NULL, '90256676', 'Customer 90256676', 0, '2015-05-08 19:00:00', '2015-05-08 20:00:00'),
(58, 8, 0, '58', 'Singapore 147735', '147735', 1.41053, 103.83, 0.26, 0.78, 20, NULL, NULL, '90256676', 'Customer 90256676', 0, '2015-05-08 19:00:00', '2015-05-08 21:00:00'),
(59, 8, 0, '59', 'Singapore 589276', '589276', 1.29703, 103.843, 0.04, 0.73, 10, NULL, NULL, '97769308', 'Customer 97769308', 0, '2015-05-08 08:00:00', '2015-05-08 09:00:00'),
(60, 8, 0, '60', 'Singapore 361090', '361090', 1.33037, 103.908, 0.72, 0.55, 30, NULL, NULL, '97769308', 'Customer 97769308', 0, '2015-05-08 14:00:00', '2015-05-08 15:00:00'),
(61, 8, 0, '61', 'Singapore 897552', '897552', 1.3403, 103.721, 0.01, 0.57, 10, NULL, NULL, '97159923', 'Customer 97159923', 0, '2015-05-08 19:00:00', '2015-05-08 21:00:00'),
(62, 8, 0, '62', 'Singapore 483038', '483038', 1.36951, 103.884, 0.12, 0.65, 20, NULL, NULL, '81382679', 'Customer 81382679', 0, '2015-05-08 15:00:00', '2015-05-08 16:00:00'),
(63, 8, 0, '63', 'Singapore 551922', '551922', 1.31217, 103.938, 0.77, 0.12, 10, NULL, NULL, '91860119', 'Customer 91860119', 0, '2015-05-08 19:00:00', '2015-05-08 20:00:00'),
(64, 8, 0, '64', 'Singapore 288580', '288580', 1.42474, 103.834, 0.19, 0.84, 30, NULL, NULL, '98508981', 'Customer 98508981', 0, '2015-05-08 10:00:00', '2015-05-08 12:00:00'),
(65, 8, 0, '65', 'Singapore 227386', '227386', 1.36587, 103.857, 0.09, 0.14, 30, NULL, NULL, '92725280', 'Customer 92725280', 0, '2015-05-08 14:00:00', '2015-05-08 15:00:00'),
(66, 8, 0, '66', 'Singapore 452716', '452716', 1.32269, 103.883, 0.69, 0.86, 30, NULL, NULL, '00000000', 'Customer 00000000', 0, '2015-05-08 09:00:00', '2015-05-08 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `create_time`, `update_time`, `full_name`, `address`, `postal`, `phone`, `lat`, `lng`) VALUES
(1, 1, '2015-01-18 21:59:05', '2015-01-22 20:40:46', 'Evan', 'Woodlands drive 14, #04-273', '730519', '82995856', 1.43435, 103.792),
(4, 5, '2015-01-22 22:52:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, '2015-01-22 23:08:13', '2015-01-22 23:08:49', 'Jack Wong', 'Woodlands drive 14, #04-273', '730519', '82995856', 1.43435, 103.792),
(6, 7, '2015-01-22 23:38:28', '2015-01-22 23:39:00', 'Lucy', 'Woodlands drive 14, #04-273', '730519', '82995856', 1.43435, 103.792),
(7, 8, '2015-01-27 00:24:49', '2015-02-24 22:53:49', 'Teng suyan', 'Woodlands drive 14, #04-273', '569141', '88888888', 1.38793, 103.844);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `create_time`, `update_time`, `can_admin`) VALUES
(1, 'Admin', '2015-01-18 21:59:05', NULL, 1),
(2, 'User', '2015-01-18 21:59:05', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`) VALUES
(1, 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `ban_time` timestamp NULL DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `new_email`, `username`, `password`, `auth_key`, `api_key`, `login_ip`, `login_time`, `create_ip`, `create_time`, `update_time`, `ban_time`, `ban_reason`) VALUES
(1, 1, 1, 'neo@neo.com', NULL, 'neo', '$2y$10$WYB666j7MmxuW6b.kFTOde/eGCLijWa6BFSjAAiiRbSAqpC1HCmrC', 'RSyP1cP5yhauLt9hmCM0xSjdDNNxdlZt', '96g5IlTIu8-UxuZELi9NlVS6pUkKZQUb', '127.0.0.1', '2015-04-22 21:05:06', NULL, '2015-01-18 21:59:05', NULL, NULL, NULL),
(5, 2, 0, 'chief725@gmail.com', NULL, NULL, '$2y$13$dcVVciXUvinXhJ7m0zJBvuAgKpDz6NLOBQTTXK6v8MCIgkW7FGf/2', 'w4EcPEUEaVKsdFeunnVvabPRFGctT8tm', 'ReoJkL3APQNBgJaK_M8h3zku_Gh9SNUF', NULL, NULL, '127.0.0.1', '2015-01-22 22:52:57', NULL, NULL, NULL),
(6, 2, 1, 'jack@gmail.com', NULL, 'jack', '$2y$13$ydsFuAOjs5u5m8o5e93MbeD5Ggz0IncB9NmJs8PiW5jYAdDtj4BTS', NULL, NULL, '127.0.0.1', '2015-05-03 18:14:30', NULL, '2015-01-22 23:08:13', NULL, NULL, NULL),
(7, 2, 1, 'lucy@gmail.com', NULL, 'lucy', '$2y$13$hHa0VaX/uUSpeSAfTUfT5.S.ggkmuU4J1HX5ZNtTz6YcXMoGgEBZS', NULL, NULL, '127.0.0.1', '2015-01-25 20:57:36', NULL, '2015-01-22 23:38:28', NULL, NULL, NULL),
(8, 2, 1, 'teng@rp.sg', NULL, 'teng', '$2y$13$is/QpaeViTqfvQE2V9Tmwe50oTCLVla8r8O5p2MzOclT2ls0C861q', NULL, NULL, '127.0.0.1', '2015-05-05 06:15:16', NULL, '2015-01-27 00:24:49', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_key`
--

CREATE TABLE IF NOT EXISTS `user_key` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_key`
--

INSERT INTO `user_key` (`id`, `user_id`, `type`, `key`, `create_time`, `consume_time`, `expire_time`) VALUES
(2, 4, 1, 'u6569lY8OCKtAsrYDDpvLCDT5DAjtRck', '2015-01-22 22:50:39', NULL, NULL),
(3, 5, 1, 'CesULL7I8ZbBOSCin1iQei3vv53rVfsG', '2015-01-22 22:52:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `capacity_volume` float NOT NULL DEFAULT '0',
  `capacity_weight` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `user_id`, `driver_id`, `capacity_volume`, `capacity_weight`) VALUES
(1, 'Vehicle 1', 7, 7, 30, 0),
(2, 'Vehicle 2', 7, 6, 33, 0),
(3, 'Vehicle A', 8, 8, 40, 40),
(4, 'Vehicle B', 8, 9, 50, 40),
(5, 'Vehicle C', 8, 10, 50, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horizon`
--
ALTER TABLE `horizon`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `parcel`
--
ALTER TABLE `parcel`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
 ADD PRIMARY KEY (`id`), ADD KEY `profile_user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_email` (`email`), ADD UNIQUE KEY `user_username` (`username`), ADD KEY `user_role_id` (`role_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
 ADD PRIMARY KEY (`id`), ADD KEY `user_auth_provider_id` (`provider_id`), ADD KEY `user_auth_user_id` (`user_id`);

--
-- Indexes for table `user_key`
--
ALTER TABLE `user_key`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_key_key` (`key`), ADD KEY `user_key_user_id` (`user_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `horizon`
--
ALTER TABLE `horizon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `parcel`
--
ALTER TABLE `parcel`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_key`
--
ALTER TABLE `user_key`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
