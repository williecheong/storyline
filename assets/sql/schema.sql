DROP DATABASE storyline;
CREATE DATABASE `storyline` DEFAULT CHARSET utf8;
USE `storyline`;

CREATE TABLE `chapter` (
   `id` int(11) not null auto_increment,
   `ordering` decimal(16,6) not null default '0.000000',
   `title` varchar(255) not null,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`chap_id`),
   UNIQUE KEY (`stor_id`,`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `contribution` (
   `id` int(11) not null auto_increment,
   `paragraph_id` int(11) not null,
   `email` int(11) not null,
   `status` int(11) not null,
   `description` text,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   `snapshot` text,
   `contype` varchar(255),
   PRIMARY KEY (`cont_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `contribution_part` (
   `id` int(11) not null auto_increment,
   `contribution_id` int(11) not null,
   `edited_by` int(11) not null default '0',
   `insdel` tinyint(4) not null default '0',
   `content` text,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`part_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `paragraph` (
   `para_id` int(11) not null auto_increment,
   `chap_id` int(11) not null,
   `ordering` decimal(19,9) not null default '0.000000000',
   `content` text,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`para_id`),
   UNIQUE KEY (`chap_id`,`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `story` (
   `stor_id` int(11) not null auto_increment,
   `title` varchar(255) not null,
   `synopsis` text,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`stor_id`),
   UNIQUE KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `line_story` (`stor_id`, `title`, `synopsis`, `created_at`, `updated_at`) VALUES 
('1', 'Doing it All Over - Al Steiner', 'Have you ever wished you could go back to your teens and re-live your life, knowing what you know now? Bill Stevens, a burned-out, 31 year old paramedic, made such a wish one night. Only his came true. Doing It All Over, first published online in 1999, is the story of a 32 year old paramedic, who wakes up one morning to find himself back as a 15 year old in 1982, with a chance to redo the crucial years of his life.', '2013-08-18 00:56:18', '2013-08-18 04:56:18');

CREATE TABLE `feedback` (
   `id` int(11) not null auto_increment,
   `email` varchar(255),
   `message` text,
   `ip_address` varchar(255),
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `sppt_status` (
   `status` int(11) not null auto_increment,
   `title` varchar(255) not null,
   `description` text,
   `last_updated` timestamp default current_timestamp on update current_timestamp,
   PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

INSERT INTO `sppt_status` (`status`, `title`, `description`, `created_at`, `updated_at`) VALUES 
('1', 'Pending', 'This contribution is undecided upon and has not been merged into the paragraph yet.', '2013-08-18 00:43:03', '0000-00-00 00:00:00'),
('2', 'Merged', 'This contribution has been merged into the paragraph.', '2013-08-18 00:43:03', '0000-00-00 00:00:00'),
('3', 'Retired', 'This contribution will not be merged into the paragraph.', '2013-08-18 00:43:04', '0000-00-00 00:00:00');