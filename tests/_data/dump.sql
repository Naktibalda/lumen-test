CREATE TABLE `token` (
  `token` char(36) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`),
  INDEX `token_username` (`username` ASC),
  CONSTRAINT `token_username`
  FOREIGN KEY (`username`)
  REFERENCES `standup`.`user` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user` (
  `username` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `created` DATETIME NOT NULL,
  `last_login` DATETIME NOT NULL,
  PRIMARY KEY (`username`));

INSERT INTO `user` (`username`, `name`, `created`, `last_login`) VALUES  ('valid', 'Test User', NOW(), NULL);

CREATE TABLE `report` (
  `date` DATE NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `yesterday` VARCHAR(200) NOT NULL,
  `today` VARCHAR(200) NOT NULL,
  `blockers` VARCHAR(200) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`date`),
  INDEX `report_username` (`username` ASC),
  CONSTRAINT `report_username`
  FOREIGN KEY (`username`)
  REFERENCES `user` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
