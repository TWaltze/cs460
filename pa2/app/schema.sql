# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Database: picshare
# Generation Time: 2015-04-22 16:52:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table albums
# ------------------------------------------------------------

DROP TABLE IF EXISTS `albums`;

CREATE TABLE `albums` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `owner` int(11) unsigned NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`),
  KEY `owner` (`owner`),
  CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) unsigned DEFAULT NULL,
  `photo` int(11) unsigned NOT NULL,
  `comment` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cid`),
  KEY `author` (`author`),
  KEY `photo` (`photo`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`uid`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`photo`) REFERENCES `photos` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table friends
# ------------------------------------------------------------

DROP TABLE IF EXISTS `friends`;

CREATE TABLE `friends` (
  `fid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstFriend` int(11) unsigned NOT NULL,
  `secondFriend` int(11) unsigned NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `firstFriend` (`firstFriend`),
  KEY `secondFriend` (`secondFriend`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`firstFriend`) REFERENCES `users` (`uid`),
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`secondFriend`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `lid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `photo` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `photo` (`photo`),
  KEY `user` (`user`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`photo`) REFERENCES `photos` (`pid`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table photos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `photos`;

CREATE TABLE `photos` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album` int(11) unsigned NOT NULL,
  `owner` int(11) unsigned NOT NULL,
  `caption` varchar(140) DEFAULT NULL,
  `data` varchar(256) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`),
  KEY `album` (`album`),
  KEY `owner` (`owner`),
  CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`album`) REFERENCES `albums` (`aid`),
  CONSTRAINT `photos_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `tid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(32) NOT NULL,
  `photo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `photo` (`photo`),
  CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`photo`) REFERENCES `photos` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `firstName` varchar(32) DEFAULT NULL,
  `lastName` varchar(32) DEFAULT NULL,
  `dob` varchar(32) DEFAULT NULL,
  `gender` varchar(32) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `school` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
