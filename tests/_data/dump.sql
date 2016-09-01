CREATE TABLE `token` (
  `token` char(36) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
