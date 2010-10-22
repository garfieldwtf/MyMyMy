-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 15, 2010 at 03:28 PM
-- Server version: 5.0.75
-- PHP Version: 5.2.6-3ubuntu4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tm_tables`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL ,
  `foreign_key` int(11) NOT NULL ,
  `file` varchar(255) default NULL,
  `filename` varchar(255) default NULL,
  `checksum` varchar(255) default NULL,
  `field` varchar(255) default NULL,
  `type` varchar(50) default NULL ,
  `size` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `private` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL ,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL ,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL,
  `foreign_key` int(11) NOT NULL ,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `group2_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL auto_increment,
  `rank` varchar(100) default NULL ,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `description` varchar(30) default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `parent_id` int(11) default NULL,
  `lft` int(11) default '0',
  `rght` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

-- --------------------------------------------------------

--
-- Table structure for table `group2s`
--

CREATE TABLE IF NOT EXISTS `group2s` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `description` varchar(30) default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group2s_users`
--

CREATE TABLE IF NOT EXISTS `group2s_users` (
 `id` int(11) NOT NULL auto_increment,
 `group2_id` int(11) NOT NULL,
 `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `implementors`
--

CREATE TABLE IF NOT EXISTS `implementors` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `model` varchar(20) default NULL ,
  `foreign_key` int(11) NOT NULL ,
  `assign_as` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `implementors`
--


-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL ,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetings`
--


-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL ,
  `foreign_key` int(11) NOT NULL ,
  `group_id` int(11) NOT NULL,
  `head` tinyint(1) NOT NULL default '0' ,
  `admin` tinyint(1) NOT NULL default '0' ,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Dumping data for table `memberships`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `type` varchar(20) default NULL,
  `message_title` varchar(255) default NULL,
  `notification_date` datetime default NULL ,
  `notification_sent` tinyint(1) NOT NULL default '0' ,
  `message` text ,
  `to` text,
  `recipient` text,
  `info` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL ,
  `user_id` int(11) NOT NULL ,
  `note` text NOT NULL,
  `remind_date` datetime default NULL ,
  `repeated` tinyint(1) default '0',
  `active` tinyint(1) NOT NULL default '1',
  `before` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `reminders`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL ,
  `description` text ,
  `deleted` tinyint(1) default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `roles`
--

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE IF NOT EXISTS `schemes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `schemes`
--

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL ,
  `updater` int(11) NOT NULL ,
  `task_status` varchar(50) NOT NULL ,
  `percent` varchar(100) NOT NULL,
  `description` text ,
  `status_date` datetime default NULL ,
  `closed` tinyint(1) NOT NULL,
  `date_closed` datetime NOT NULL ,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `user_id` int(11) NOT NULL,
  `group2_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1  ;

--
-- Dumping data for table `statuses`
--


-- --------------------------------------------------------

--
-- Table structure for table `taskinfos`
--

CREATE TABLE IF NOT EXISTS `taskinfos` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL ,
  `foreign_key` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `taskinfos`
--


-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL auto_increment,
  `ref_no` varchar(255) default NULL,
  `priority` int(11) NOT NULL ,
  `task_name` varchar(500) NOT NULL ,
  `task_desc` text NOT NULL ,
  `start_date` datetime default NULL ,
  `end_date` datetime default NULL ,
  `deleted` tinyint(1) NOT NULL default '0',
  `created` date default NULL,
  `updated` date default NULL,
  `group_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL ,
  `foreign_key` int(11) NOT NULL ,
  `type` varchar(20) default NULL ,
  `title` varchar(200) default NULL ,
  `description` varchar(255) default NULL,
  `template` text ,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `templates`
--


-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE IF NOT EXISTS `titles` (
  `id` int(11) NOT NULL auto_increment,
  `long_name` varchar(100) NOT NULL ,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `titles`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) default NULL,
  `superuser` tinyint(1) NOT NULL default '0' ,
  `scheme_id` int(11) NULL ,
  `grade_id` int(11) NULL ,
  `job_title` varchar(50) default NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(150) default NULL,
  `telephone` varchar(30) default NULL,
  `mobile` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `address` text ,
  `title_id` int(11) NOT NULL ,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `bahagian` varchar(255) default NULL ,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `locked` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

