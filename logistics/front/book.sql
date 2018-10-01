-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 25, 2018 at 02:31 AM
-- Server version: 5.5.61-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book`
--
CREATE DATABASE IF NOT EXISTS `book` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `book`;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) NOT NULL,
  `top` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `node_id`, `top`) VALUES
(51, 246, NULL),
(52, 246, NULL),
(53, 247, NULL),
(54, 248, NULL),
(55, 248, NULL),
(57, 249, NULL),
(58, 249, NULL),
(60, 251, NULL),
(61, 251, NULL),
(62, 251, NULL),
(64, 244, NULL),
(66, 249, NULL),
(67, 256, NULL),
(68, 256, NULL),
(69, 242, NULL),
(70, 243, NULL),
(71, 244, NULL),
(72, 244, NULL),
(73, 247, NULL),
(74, 242, NULL),
(75, 244, NULL),
(76, 244, NULL),
(77, 244, NULL),
(79, 244, NULL),
(80, 244, NULL),
(81, 243, NULL),
(82, 243, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) NOT NULL DEFAULT 'localhost',
  `title` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `seq` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`id`, `domain`, `title`, `url`, `seq`) VALUES
(26, 'help.logistics.lol', 'logistics.lol', 'www.logistics.lol', 0);

-- --------------------------------------------------------

--
-- Table structure for table `node`
--

CREATE TABLE IF NOT EXISTS `node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'localhost',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `seq` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `seq` (`seq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=257 ;

--
-- Dumping data for table `node`
--

INSERT INTO `node` (`id`, `domain`, `parent_id`, `seq`, `title`, `content`, `hits`) VALUES
(241, 'help.logistics.lol', 0, NULL, 'EasiPlanner Guide', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>', 12591),
(242, 'help.logistics.lol', 241, 2, 'Create a Driver', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>&nbsp;</p>\r\n<p><strong><img id="image74" style="max-height: 100%; max-width: 100%;" src="/imgs/node/74.jpg" alt="" /></strong></p>\r\n<p><strong>Step 1</strong>: Click on the driver option in the top navigation bar, and then click the green Create Driver button.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Step 2:</strong> Fill in the form with the information required and then click Create.</p>\r\n<p>Setting the home postal is&nbsp;<strong>mandatory</strong>&nbsp;for this program to function properly.</p>\r\n<p>&nbsp;<img id="image69" style="max-height: 100%; max-width: 100%;" src="/imgs/node/69.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>', 567),
(243, 'help.logistics.lol', 241, 3, 'Create a Vehicle', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Step 1: Click on the the Vehicle option&nbsp;in the top navigation bar. And then click the green "Create Vehicle" button.</p>\r\n<p>&nbsp;<img id="image82" style="max-height: 100%; max-width: 100%;" src="/imgs/node/82.jpg" alt="" /></p>\r\n<p>Step 2: Fill in the form and click create button.Volume and Weight are numerical values.</p>\r\n<p>Driver ID is based on your created drivers. If you have not created any drivers,you should go back to the <a href="/242.html">Create Driver </a>page to do so.</p>\r\n<p>Click on the "Create Vehicle" button if all the information is filled in.</p>\r\n<p>You can flag the vehicle as active or inactive when you create vehicle.</p>\r\n<p><img id="image81" style="max-height: 100%; max-width: 100%;" src="/imgs/node/81.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n<p>You are able to set the capacity volume and capacity weight for your vehicles at once by click on "Batch Set "button.</p>\r\n<p><img id="image70" style="max-height: 100%; max-width: 100%;" src="/imgs/node/70.jpg" alt="" /></p>\r\n</body>\r\n</html>', 462),
(244, 'help.logistics.lol', 241, 4, 'Import Parcels', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><strong>Step 1:</strong> Click on the Parcel option&nbsp;in the top navigation bar and then click on the yellow Import Parcels button.</p>\r\n<p>&nbsp;<img id="image80" style="max-height: 100%; max-width: 100%;" src="/imgs/node/80.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Step 2:</strong> Select the parcels file and click Import. You can download a&nbsp;sample file bellow.</p>\r\n<p><img id="image71" style="max-height: 100%; max-width: 100%;" src="/imgs/node/71.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n<p>The format of the file should mirror the format of the sample excel/csv file.</p>\r\n<p>This is a preview of the sample excel/ csv file.</p>\r\n<p>&nbsp;<img id="image64" style="max-height: 100%; max-width: 100%;" src="/imgs/node/64.jpg" alt="" /></p>\r\n<p><span style="text-decoration: underline;"><strong>Reschedule Parcels</strong></span></p>\r\n<p><strong>Step 1 :</strong>Click on''''Change &nbsp;start date'''' and select the date that you need to change as shown as below.</p>\r\n<p><img id="image75" style="max-height: 100%; max-width: 100%;" src="/imgs/node/75.jpg" alt="" /></p>\r\n<p><strong>&nbsp;Step 2:</strong>&nbsp;Click on''''Change end date'''' and select the date that you need to change as shown as below.</p>\r\n<p><img id="image76" style="max-height: 100%; max-width: 100%;" src="/imgs/node/76.jpg" alt="" /></p>\r\n<p><strong>Step 3:</strong>Note the reason for reschedule Parcels and Click on&nbsp;''''Reschedule Parcels" button.</p>\r\n<p><img id="image77" style="max-height: 100%; max-width: 100%;" src="/imgs/node/77.jpg" alt="" /></p>\r\n<p>A pop-out massage will be shown to verified the request of reschedule Parcels. Click "OK" to reschedule parcels.</p>\r\n<p>&nbsp;<img id="image79" style="max-height: 100%; max-width: 100%;" src="/imgs/node/79.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>', 666),
(245, 'help.logistics.lol', 241, 5, 'Clustering and Routing', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>', 2330),
(246, 'help.logistics.lol', 245, 2, 'Manual planning', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><strong>Step 1:</strong> Click on the square control button and drag your mouse to select the parcels on the map.</p>\r\n<p><strong>Step 2:</strong> Choose a vehicle on the right side and click on the green Assign button.</p>\r\n<p><img id="image52" style="max-height: 100%; max-width: 100%;" src="/imgs/node/52.jpg" alt="" /></p>\r\n</body>\r\n</html>', 358),
(247, 'help.logistics.lol', 245, 1, 'Overview', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>There are three&nbsp;control sections.</p>\r\n<ol>\r\n<li>The controls on the left are for selecting parcels on the map.</li>\r\n<li>The controls on the right are for parcel filtering.</li>\r\n<li>The controls on the top are for smart routing.</li>\r\n</ol>\r\n<p><img id="image53" style="max-height: 100%; max-width: 100%;" src="/imgs/node/53.jpg" alt="" /></p>\r\n<p>The green icon shown as a warehouse</p>\r\n<p>The red, blue and cyanine icon shown as a driver ''s house. The information and detail of the driver will be shown when you press the icon.</p>\r\n<p><img id="image73" style="max-height: 100%; max-width: 100%;" src="/imgs/node/73.jpg" alt="" /></p>\r\n</body>\r\n</html>', 395),
(248, 'help.logistics.lol', 245, 4, 'Auto planning', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>After you are done with <a href="/246.html">manual&nbsp;clustering</a>, click on the red Routing (Play Symbol) button.&nbsp;</p>\r\n<p><img id="image55" src="/imgs/node/55.jpg" alt="" /></p>\r\n<p>The time taken to generate the results depends on the amount of parcels you have planned to deliver.</p>\r\n<p>If you want to auto cluster and route, click yellow button beside the red one.</p>\r\n<p>This application works best on&nbsp;<a href="https://www.google.com/chrome/browser/desktop/">Chrome</a>.</p>\r\n<p>&nbsp;</p>\r\n<p><img id="image54" style="max-height: 100%; max-width: 100%;" src="/imgs/node/54.jpg" alt="" /></p>\r\n<p>If you want hide the routing lines, you can click the blue Erase (Cross Symbol) button.</p>\r\n</body>\r\n</html>', 392),
(249, 'help.logistics.lol', 245, 5, 'Downloading Data', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><strong>Step 1:</strong> Go to the <a href="/244.htm">Parcel</a>&nbsp;page, and click the blue Export Parcels button.&nbsp;</p>\r\n<p>This will export your file in a&nbsp;.csv format.</p>\r\n<p><img id="image58" style="max-height: 100%; max-width: 100%;" src="/imgs/node/58.jpg" alt="" /></p>\r\n<p>This is a sample output of&nbsp;the .csv file.</p>\r\n<p>&nbsp;<img id="image66" style="max-height: 100%; max-width: 100%;" src="/imgs/node/66.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>', 288),
(251, 'help.logistics.lol', 245, 3, 'Semi-auto planning', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Step 1: Select a seed parcel</p>\r\n<p><img id="image60" style="max-height: 100%; max-width: 100%;" src="/imgs/node/60.jpg" alt="" /></p>\r\n<p>&nbsp;</p>\r\n<p>Step 2: Select an vechile and then click the Auto Fill button.</p>\r\n<p><img id="image61" style="max-height: 100%; max-width: 100%;" src="/imgs/node/61.jpg" alt="" /></p>\r\n<p>Step 3: You will the see the result like bellow. And then click the green Assign button.</p>\r\n<p><img id="image62" style="max-height: 100%; max-width: 100%;" src="/imgs/node/62.jpg" alt="" /></p>\r\n</body>\r\n</html>', 360),
(252, 'help.logistics.lol', 241, 6, 'Sample data for testing', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Download:&nbsp;<a href="http://www.logistics.lol/tutorial/sample">Sample data for testing</a></p>\r\n</body>\r\n</html>', 384),
(253, 'help.logistics.lol', 241, 7, 'Survey Form', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><a href="http://goo.gl/forms/wMNtV0DgDm">http://goo.gl/forms/wMNtV0DgDm</a></p>\r\n</body>\r\n</html>', 312),
(254, 'help.logistics.lol', 241, 8, 'FAQ', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Here are a list of Frequently Asked Questions.&nbsp;</p>\r\n<p>We hope this will help clarify some issues you may face.</p>\r\n<p>&nbsp;</p>\r\n<p><em><strong>Q:OMG!Why can''t I route??The icon just keeps spinning!</strong></em></p>\r\n<p><strong>A:&nbsp;</strong>This is our most asked question.Firstly,check if you have set your warehouse/company/delivery starting point address in the <a href="/256.html">Profile</a>&nbsp;Page.</p>\r\n<p>Next,check if your date and time match today''s date and time in the <a href="/244.html">Parcel</a>&nbsp;page.</p>\r\n<p>The Excel formatting may be inaccurate&nbsp;so do check if it is properly formatted.Use this <a href="/252.html">sample data</a>&nbsp;as reference.</p>\r\n</body>\r\n</html>', 145),
(255, 'help.logistics.lol', 241, 9, 'Contact Us', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Have you read our&nbsp;<a href="/254.html" target="_blank">F.A.Q</a>&nbsp;section yet?If not,please do so.</p>\r\n<p>You can contact us at <a href="mailto:easiplanner.dev@gmail.com">easiplanner.dev@gmail.com</a>&nbsp;for help and assistance.</p>\r\n</body>\r\n</html>', 146),
(256, 'help.logistics.lol', 241, 1, 'Initial Setup', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><strong>Welcome to EasiPlanner''s Guide.</strong></p>\r\n<p>You''ve now registered for our site,congratulations!</p>\r\n<p>We need to do some basic configuration before EasiPlanner can work for you.</p>\r\n<p><strong>Step 1:</strong> <strong>Log in.</strong></p>\r\n<p>There are other functionalities like resetting your password and resending a confirmation email.</p>\r\n<p>&nbsp;<img id="image67" style="max-height: 100%; max-width: 100%;" src="/imgs/node/67.jpg" alt="" width="525" height="339" /></p>\r\n<p><strong>Step 2: Go to the Profile Page (Gear icon in the top bar)</strong></p>\r\n<p>&nbsp;<img id="image68" style="max-height: 100%; max-width: 100%;" src="/imgs/node/68.jpg" alt="" width="623" height="272" /></p>\r\n<p>There is some important information here that you need to fill in.This includes your Company''s Full Name,Address,Warehouse Postal Code and Warehouse Latitude and Warehouse Longitude.</p>\r\n<p>Setting the postal code or warehouse latitude/warehouse longitude is <strong>mandatory</strong> for this program to function properly.</p>\r\n<p>We recommend you only use a postal code as this will automatically check the latitude and longitude of your company''s HQ.</p>\r\n<p>However,if you wish to set a specific latitude and longitude to compliment&nbsp;the postal code,you can do so.</p>\r\n<p>You can ignore the speed factor for now.The speed factor is only adjusted when delivery time seems to be either too fast or too slow.</p>\r\n<p><strong>Step 3: Click on Update</strong>&nbsp;</p>\r\n<p>This will update your settings and allow you to create&nbsp;<a href="/242.html">Drivers</a>,<a href="/243.html">Vehicles</a> and <a href="/244.html">Parcels</a>.</p>\r\n</body>\r\n</html>', 189);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `category`, `key`, `value`) VALUES
(18, 'help.logistics.lol', 'app_name', 's:17:"EasiPlanner Guide";'),
(19, 'help.logistics.lol', 'language', 's:0:"";'),
(20, 'help.logistics.lol', 'title', 's:36:"Welcome to the guide for EasiPlanner";'),
(21, 'help.logistics.lol', 'keywords', 's:0:"";'),
(22, 'help.logistics.lol', 'description', 's:0:"";'),
(23, 'help.logistics.lol', 'footer_text', 's:0:"";'),
(24, 'help.logistics.lol', 'enable_ads', 's:5:"false";'),
(25, 'help.logistics.lol', 'theme', 's:0:"";'),
(26, 'help.logistics.lol', 'cache_duration', 's:0:"";'),
(27, 'help.logistics.lol', 'enable_prefetch', 's:0:"";'),
(28, 'help.logistics.lol', 'enable_highlight', 's:0:"";');

-- --------------------------------------------------------

--
-- Table structure for table `yiicache`
--

CREATE TABLE IF NOT EXISTS `yiicache` (
  `id` char(128) COLLATE utf8_bin NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `value` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `yiicache`
--

INSERT INTO `yiicache` (`id`, `expire`, `value`) VALUES
('6196ae6cdc07cf499b02d761b60527ff', 1537851406, 0x613a323a7b693a303b613a31313a7b733a383a226170705f6e616d65223b733a31373a2245617369506c616e6e6572204775696465223b733a383a226c616e6775616765223b733a303a22223b733a353a227469746c65223b733a33363a2257656c636f6d6520746f2074686520677569646520666f722045617369506c616e6e6572223b733a383a226b6579776f726473223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31313a22666f6f7465725f74657874223b733a303a22223b733a31303a22656e61626c655f616473223b733a353a2266616c7365223b733a353a227468656d65223b733a303a22223b733a31343a2263616368655f6475726174696f6e223b733a303a22223b733a31353a22656e61626c655f7072656665746368223b733a303a22223b733a31363a22656e61626c655f686967686c69676874223b733a303a22223b7d693a313b4e3b7d),
('7b73289287ada97d78078559cd0c9e59', 0, 0x613a323a7b693a303b613a323a7b693a303b613a363a7b693a303b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a31303a226e6f64652f696e646578223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a32343a222f5e283f503c69643e5c642b295c2e68746d6c5c2f242f75223b733a383a2274656d706c617465223b733a393a223c69643e2e68746d6c223b733a363a22706172616d73223b613a313a7b733a323a226964223b733a333a225c642b223b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d693a313b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a31303a226e6f64652f696e646578223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a373a222f5e5c2f242f75223b733a383a2274656d706c617465223b733a303a22223b733a363a22706172616d73223b613a303a7b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d693a323b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a393a22706167652f76696577223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a33303a222f5e706167655c2f283f503c7469746c653e5b5e5c2f5d2b295c2f242f75223b733a383a2274656d706c617465223b733a31323a22706167652f3c7469746c653e223b733a363a22706172616d73223b613a313a7b733a353a227469746c65223b733a363a225b5e5c2f5d2b223b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d693a333b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a31303a226e6f64652f61646d696e223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a31323a222f5e61646d696e5c2f242f75223b733a383a2274656d706c617465223b733a353a2261646d696e223b733a363a22706172616d73223b613a303a7b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d693a343b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a31323a22736974652f736974656d6170223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a31393a222f5e736974656d61705c2e786d6c5c2f242f75223b733a383a2274656d706c617465223b733a31313a22736974656d61702e786d6c223b733a363a22706172616d73223b613a303a7b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d693a353b4f3a383a224355726c52756c65223a31363a7b733a393a2275726c537566666978223b4e3b733a31333a226361736553656e736974697665223b4e3b733a31333a2264656661756c74506172616d73223b613a303a7b7d733a31303a226d6174636856616c7565223b4e3b733a343a2276657262223b4e3b733a31313a2270617273696e674f6e6c79223b623a303b733a353a22726f757465223b733a31333a22736974652f6d616e6966657374223b733a31303a227265666572656e636573223b613a303a7b7d733a31323a22726f7574655061747465726e223b4e3b733a373a227061747465726e223b733a31353a222f5e6d616e69666573745c2f242f75223b733a383a2274656d706c617465223b733a383a226d616e6966657374223b733a363a22706172616d73223b613a303a7b7d733a363a22617070656e64223b623a303b733a31313a22686173486f7374496e666f223b623a303b733a31343a220043436f6d706f6e656e74005f65223b4e3b733a31343a220043436f6d706f6e656e74005f6d223b4e3b7d7d693a313b733a33323a223733323064616665363735346166626466306538636364356537613837646335223b7d693a313b4e3b7d),
('f91cd0eb25a531338ceea6d652393208', 1537851406, 0x613a323a7b693a303b613a313a7b693a303b733a31383a2268656c702e6c6f676973746963732e6c6f6c223b7d693a313b4e3b7d);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
