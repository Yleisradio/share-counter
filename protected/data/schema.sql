-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 03, 2013 at 01:24 PM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kato_ite`
--

-- --------------------------------------------------------

--
-- Table structure for table `apilog`
--

CREATE TABLE IF NOT EXISTS `apilog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` int(2) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `response` text NOT NULL,
  `response_code` int(3) DEFAULT NULL,
  `total_time` float(5,2) NOT NULL,
  `request` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `service` (`service`,`timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=962743 ;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `username` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`,`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1580 ;

-- --------------------------------------------------------

--
-- Table structure for table `metric`
--

CREATE TABLE IF NOT EXISTS `metric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`,`type`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1841782 ;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1415 ;

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(512) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `facebook_shares` int(6) NOT NULL DEFAULT '0',
  `facebook_likes` int(6) NOT NULL DEFAULT '0',
  `facebook_comments` int(6) NOT NULL DEFAULT '0',
  `twitter_tweets` int(6) NOT NULL DEFAULT '0',
  `linkedin_shares` int(6) NOT NULL DEFAULT '0',
  `not_changed` int(3) NOT NULL DEFAULT '0',
  `title` varchar(256) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `shares_per_hour` int(11) NOT NULL DEFAULT '0',
  `brand` int(2) DEFAULT NULL,
  `page_views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `url` (`url`(255),`updated`),
  KEY `brand` (`brand`),
  KEY `shares_per_hour` (`shares_per_hour`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14782 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Constraints for table `metric`
--
ALTER TABLE `metric`
  ADD CONSTRAINT `metric_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);
