DROP DATABASE storyline;
CREATE DATABASE storyline;

CREATE TABLE `line_user` (
	`user_id` int(11) not null auto_increment,
	`email` varchar(255) not null,
	`password` varchar(255) not null,
	`display` varchar(255) not null,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`user_id`),
	UNIQUE KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `line_story` (
	`stor_id` int(11) not null auto_increment,
	`title` varchar(255) not null,
	`synopsis` text,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`stor_id`),
	UNIQUE KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `rshp_director` (
	`dire_id` int(11) not null auto_increment,
	`user_id` int(11) not null,
	`stor_id` int(11) not null,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`dire_id`),
	UNIQUE KEY (`user_id`, `stor_id`),
	FOREIGN KEY (user_id) REFERENCES line_user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (stor_id) REFERENCES line_story(stor_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `line_chapter` (
	`chap_id` int(11) not null auto_increment,
	`stor_id` int(11) not null,
	`ordering` int(11) not null default '0',
	`title` varchar(255) not null,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`chap_id`),
	UNIQUE KEY (`title`),
	UNIQUE KEY (`stor_id`, `ordering`),
	FOREIGN KEY (stor_id) REFERENCES line_story(stor_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `line_paragraph` (
	`para_id` int(11) not null auto_increment,
	`chap_id` int(11) not null,
	`ordering` int(11) not null default '0',
	`content` text,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`para_id`),
	UNIQUE KEY (`chap_id`, `ordering`),
	FOREIGN KEY (chap_id) REFERENCES line_chapter(chap_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `sppt_status` (
	`status` int(11) not null auto_increment,
	`title` varchar(255) not null,
	`description` text,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO sppt_status (title, description) VALUES ('Pending', 'This contribution is undecided upon and has not been merged into the paragraph yet.');
INSERT INTO sppt_status (title, description) VALUES ('Approved', 'This contribution has been merged into the paragraph.');
INSERT INTO sppt_status (title, description) VALUES ('Rejected', 'This contribution will not be merged into the paragraph.');

CREATE TABLE `line_contribution` (
	`cont_id` int(11) not null auto_increment,
	`para_id` int(11) not null,
	`user_id` int(11) not null,
	`status` int(11) not null,
	`description` text,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`cont_id`),
	FOREIGN KEY (para_id) REFERENCES line_paragraph(para_id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES line_user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (status) REFERENCES sppt_status(status) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `line_contribution_part` (
	`part_id` int(11) not null auto_increment,
	`cont_id` int(11) not null,
	`edited_by` int(11) not null default '0',
	`insdel` tinyint(4) not null default '0',
	`content` text,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`part_id`),
	FOREIGN KEY (cont_id) REFERENCES line_contribution(cont_id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (edited_by) REFERENCES line_user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;