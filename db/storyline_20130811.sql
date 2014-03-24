CREATE TABLE `sppt_feedback` (
	`id` int(11) not null auto_increment,
	`email` varchar(255),
	`message` TEXT,
	`url` TEXT not null,
	`created_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`updated_at` timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;