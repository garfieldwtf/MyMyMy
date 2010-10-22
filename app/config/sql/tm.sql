#App sql generated on: 2009-11-19 14:33:45 : 1258612425

DROP TABLE IF EXISTS `attachments`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `hashes`;
DROP TABLE IF EXISTS `implementors`;
DROP TABLE IF EXISTS `logs`;
DROP TABLE IF EXISTS `memberships`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `protocols`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `taskcomponents`;
DROP TABLE IF EXISTS `taskdetails`;
DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `tasktypes`;
DROP TABLE IF EXISTS `titles`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `userstatuses`;


CREATE TABLE `attachments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(20) DEFAULT NULL,
	`foreign_key` int(11) NOT NULL,
	`file` varchar(255) DEFAULT NULL,
	`filename` varchar(255) DEFAULT NULL,
	`checksum` varchar(255) DEFAULT NULL,
	`field` varchar(255) DEFAULT NULL,
	`type` varchar(50) DEFAULT NULL,
	`size` int(11) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `comments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(20) DEFAULT NULL,
	`foreign_key` int(11) NOT NULL,
	`description` text DEFAULT NULL,
	`user_id` int(11) NOT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `groups` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(30) DEFAULT NULL,
	`description` text DEFAULT NULL,
	`deleted` tinyint(1) DEFAULT 0 NOT NULL,
	`deleted_date` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `hashes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(30) NOT NULL,
	`foreign_key` int(11) NOT NULL,
	`url` varchar(255) NOT NULL,
	`hash_type` varchar(30) DEFAULT NULL,
	`hash` varchar(30) NOT NULL,
	`limit` int(11) DEFAULT NULL,
	`due_date` datetime DEFAULT NULL,
	`limit_count` int(11) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,
	`deleted` tinyint(1) DEFAULT 0 NOT NULL,
	`deleted_date` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `implementors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`task_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `logs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`controller` varchar(50) NOT NULL,
	`action` varchar(50) NOT NULL,
	`url` varchar(255) NOT NULL,
	`timestamp` datetime DEFAULT NULL,
	`message` varchar(255) NOT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `memberships` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`group_id` int(11) NOT NULL,
	`role_id` int(11) NOT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `permissions` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`role_id` int(11) NOT NULL,
	`group_id` int(11) NOT NULL,
	`model` varchar(50) DEFAULT NULL,
	`level` int(11) NOT NULL,
	`view` varchar(200) DEFAULT NULL,
	`edit` varchar(200) DEFAULT NULL,
	`delete` varchar(200) DEFAULT NULL,
	`approve` varchar(200) DEFAULT NULL,
	`disapprove` varchar(200) DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `protocols` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`protocol_title` varchar(50) DEFAULT NULL,
	`rank` varchar(100) DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `roles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(20) DEFAULT NULL,
	`description` text DEFAULT NULL,
	`deleted` tinyint(1) DEFAULT 0,
	`deleted_date` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `taskcomponents` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`task_id` int(11) NOT NULL,
	`taskdetail_id` int(11) NOT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `taskdetails` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(20) DEFAULT NULL,
	`description` text DEFAULT NULL,
	`tasktype_id` int(4) DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `tasks` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`ref_no` int(11) NOT NULL,
	`priority` int(11) NOT NULL,
	`task_name` varchar(500) NOT NULL,
	`task_desc` text NOT NULL,
	`start_date` datetime DEFAULT NULL,
	`end_date` datetime DEFAULT NULL,
	`deleted` tinyint(1) DEFAULT 0 NOT NULL,
	`created` date DEFAULT NULL,
	`updated` date DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `tasktypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(20) DEFAULT NULL,
	`description` text DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `titles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`short_name` varchar(50) DEFAULT NULL,
	`long_name` varchar(100) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(20) DEFAULT NULL,
	`password` varchar(200) DEFAULT NULL,
	`superuser` tinyint(1) DEFAULT 0 NOT NULL,
	`protocol_id` int(11) NOT NULL,
	`job_title` varchar(50) DEFAULT NULL,
	`name` varchar(80) DEFAULT NULL,
	`email` varchar(150) DEFAULT NULL,
	`telephone` varchar(30) DEFAULT NULL,
	`mobile` varchar(30) DEFAULT NULL,
	`fax` varchar(30) DEFAULT NULL,
	`address` text DEFAULT NULL,
	`title_id` int(11) NOT NULL,
	`deleted` tinyint(1) DEFAULT 0 NOT NULL,
	`deleted_date` datetime DEFAULT NULL,
	`bahagian` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

CREATE TABLE `userstatuses` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`task_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`updater` int(11) NOT NULL,
	`status` varchar(50) NOT NULL,
	`percent` varchar(100) NOT NULL,
	`description` text DEFAULT NULL,
	`status_date` datetime DEFAULT NULL,
	`closed` tinyint(1) NOT NULL,
	`date_closed` datetime NOT NULL,
	`deleted` tinyint(1) DEFAULT 0 NOT NULL,
	`deleted_date` datetime DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`updated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`));

