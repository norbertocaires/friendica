--
-- TABLE Competency
--
CREATE TABLE IF NOT EXISTS `competency` (
	`id` int unsigned NOT NULL auto_increment COMMENT 'sequential ID',

	`uid` mediumint unsigned NOT NULL DEFAULT 0 COMMENT 'Owner User id',
	`competencyId` int NOT NULL DEFAULT '' COMMENT '',

	 PRIMARY KEY(`id`)
) DEFAULT COLLATE utf8mb4_general_ci COMMENT='';
