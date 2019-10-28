ALTER TABLE `accounts`
ADD COLUMN `cookie` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT ''  AFTER `password`,
ADD COLUMN `session` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '' AFTER `cookie`,
ADD COLUMN `ip` varchar(15) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '' AFTER `session`,
ADD COLUMN `webpoints` smallint(4) unsigned NOT NULL DEFAULT '0' AFTER `ip`,
ADD COLUMN `voteTime` int(10) DEFAULT NULL AFTER `webpoints`;

ALTER TABLE `characters`
ADD COLUMN `onlinemap` enum('true','false') NOT NULL DEFAULT 'true' AFTER `onlinetime`,
ADD COLUMN `pccafe_points` int(6) unsigned NOT NULL DEFAULT '0';