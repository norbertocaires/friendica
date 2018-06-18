--
-- TABLE Competency
--
CREATE TABLE IF NOT EXISTS `competency` (
	`id` int unsigned NOT NULL auto_increment COMMENT 'sequential ID',
	`uid` mediumint unsigned NOT NULL DEFAULT 0 COMMENT 'Owner User id',

	`name` varchar(255) NOT NULL DEFAULT '' COMMENT '',
	`statement` varchar(255) NOT NULL DEFAULT '' COMMENT '',
	`idnumber` varchar(255) NOT NULL DEFAULT 0 COMMENT '',
	

	`autonomy` boolean NOT NULL DEFAULT '0' COMMENT 'With assistence = true, Without help = false',
	`frequency` boolean NOT NULL DEFAULT '0' COMMENT 'In all cases = true, In some cases = false',
	`familiarity` boolean NOT NULL DEFAULT '0' COMMENT 'Familiar = true, Unfamiliar = false',
	`scope` boolean NOT NULL DEFAULT '0' COMMENT 'Total = true, Partial = false',

	`complexity` varchar(255) NOT NULL DEFAULT '' COMMENT 'High/Middle/Weak',


	 PRIMARY KEY(`id`)
) DEFAULT COLLATE utf8mb4_general_ci COMMENT='';
