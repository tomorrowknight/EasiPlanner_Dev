-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 08 月 26 日 04:09
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `book`
--

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) NOT NULL,
  `top` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `image`
--


-- --------------------------------------------------------

--
-- 表的结构 `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) NOT NULL DEFAULT 'localhost',
  `title` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `seq` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `link`
--


-- --------------------------------------------------------

--
-- 表的结构 `node`
--

CREATE TABLE IF NOT EXISTS `node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'localhost',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `seq` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `url` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `seq` (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `node`
--


-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `settings`
--


-- --------------------------------------------------------

--
-- 表的结构 `yiicache`
--

CREATE TABLE IF NOT EXISTS `yiicache` (
  `id` char(128) COLLATE utf8_bin NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `value` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `yiicache`
--

