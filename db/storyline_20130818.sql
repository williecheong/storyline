DROP DATABASE storyline;
CREATE DATABASE `storyline` DEFAULT CHARSET utf8;
USE `storyline`;

CREATE TABLE `line_chapter` (
   `chap_id` int(11) not null auto_increment,
   `stor_id` int(11) not null,
   `ordering` decimal(16,6) not null default '0.000000',
   `title` varchar(255) not null,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`chap_id`),
   UNIQUE KEY (`stor_id`,`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `line_contribution` (
   `cont_id` int(11) not null auto_increment,
   `para_id` int(11) not null,
   `user_id` int(11) not null,
   `status` int(11) not null,
   `description` text,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   `snapshot` text,
   `contype` varchar(255),
   PRIMARY KEY (`cont_id`),
   KEY `para_id` (`para_id`),
   KEY `user_id` (`user_id`),
   KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `line_contribution_part` (
   `part_id` int(11) not null auto_increment,
   `cont_id` int(11) not null,
   `edited_by` int(11) not null default '0',
   `insdel` tinyint(4) not null default '0',
   `content` text,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`part_id`),
   KEY `cont_id` (`cont_id`),
   KEY `edited_by` (`edited_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `line_paragraph` (
   `para_id` int(11) not null auto_increment,
   `chap_id` int(11) not null,
   `ordering` decimal(19,9) not null default '0.000000000',
   `content` text,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`para_id`),
   UNIQUE KEY (`chap_id`,`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `line_story` (
   `stor_id` int(11) not null auto_increment,
   `title` varchar(255) not null,
   `synopsis` text,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`stor_id`),
   UNIQUE KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `line_story` (`stor_id`, `title`, `synopsis`, `created_at`, `updated_at`) VALUES 
('1', 'Doing it All Over - Al Steiner', 'Have you ever wished you could go back to your teens and re-live your life, knowing what you know now? Bill Stevens, a burned-out, 31 year old paramedic, made such a wish one night. Only his came true. Doing It All Over, first published online in 1999, is the story of a 32 year old paramedic, who wakes up one morning to find himself back as a 15 year old in 1982, with a chance to redo the crucial years of his life.', '2013-08-18 00:56:18', '2013-08-18 04:56:18');

CREATE TABLE `line_user` (
   `user_id` int(11) not null auto_increment,
   `email` varchar(255) not null,
   `password` varchar(255) not null,
   `display` varchar(255) not null,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`user_id`),
   UNIQUE KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

INSERT INTO `line_user` (`user_id`, `email`, `password`, `display`, `created_at`, `updated_at`) VALUES 
('1', 'master@storyline.com', '$2y$08$d2hVCIyjgyvaJX0d2glweeYWR1o3D3ougWjwUFleQhi/shaIkYlcu', 'storyPhantom', '2013-08-18 00:43:02', '0000-00-00 00:00:00'),
('2', 'cheongwillie@gmail.com', '$2y$08$6/FYxjMy0L9/ebJQZln98u2Wk4tBzECB8qXjpDSHUiJD2gIGEQ6ui', 'Willie', '2013-08-18 00:52:49', '2013-08-18 04:52:49');

CREATE TABLE `rshp_director` (
   `dire_id` int(11) not null auto_increment,
   `user_id` int(11) not null,
   `stor_id` int(11) not null,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`dire_id`),
   UNIQUE KEY (`user_id`,`stor_id`),
   KEY `stor_id` (`stor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `rshp_director` (`dire_id`, `user_id`, `stor_id`, `created_at`, `updated_at`) VALUES 
('1', '1', '1', '2013-08-18 00:55:27', '0000-00-00 00:00:00');

CREATE TABLE `sppt_feedback` (
   `id` int(11) not null auto_increment,
   `email` varchar(255),
   `message` text,
   `url` text not null,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   `ip_address` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `sppt_status` (
   `status` int(11) not null auto_increment,
   `title` varchar(255) not null,
   `description` text,
   `created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `updated_at` timestamp not null default '0000-00-00 00:00:00',
   PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

INSERT INTO `sppt_status` (`status`, `title`, `description`, `created_at`, `updated_at`) VALUES 
('1', 'Pending', 'This contribution is undecided upon and has not been merged into the paragraph yet.', '2013-08-18 00:43:03', '0000-00-00 00:00:00'),
('2', 'Merged', 'This contribution has been merged into the paragraph.', '2013-08-18 00:43:03', '0000-00-00 00:00:00'),
('3', 'Retired', 'This contribution will not be merged into the paragraph.', '2013-08-18 00:43:04', '0000-00-00 00:00:00');