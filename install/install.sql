-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `permalink` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permalink` (`permalink`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `blog_category` (`id`, `name`, `permalink`) VALUES
(1,	'Lainnya',	'Lainnya');

DROP TABLE IF EXISTS `blog_file`;
CREATE TABLE `blog_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(32) NOT NULL,
  `filetype` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `size` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `blog_pages`;
CREATE TABLE `blog_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `permalink` varchar(32) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `permalink` (`permalink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `blog_post`;
CREATE TABLE `blog_post` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `permalink` varchar(160) NOT NULL,
  `title` varchar(160) NOT NULL,
  `content` text NOT NULL,
  `category` text NOT NULL,
  `date` datetime NOT NULL,
  `update` datetime NOT NULL,
  `post_by` bigint(255) NOT NULL,
  `status` int(2) NOT NULL,
  `hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permalink` (`permalink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `blog_setting`;
CREATE TABLE `blog_setting` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(62) NOT NULL,
  `description` varchar(300) NOT NULL,
  `keyword` varchar(500) NOT NULL,
  `post_limit` int(11) NOT NULL,
  `slugpost` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `blog_setting` (`id`, `title`, `description`, `keyword`, `post_limit`, `slugpost`) VALUES
(1,	'PenulisCMS',	'Just Another Blog',	'tutorial php, belajar html',	5,	1);

DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `id` bigint(225) unsigned NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `email` varchar(32) NOT NULL,
  `username` varchar(16) NOT NULL,
  `fullname` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  `date` datetime NOT NULL,
  `picture` text NOT NULL,
  `quote` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2019-03-26 15:24:01
