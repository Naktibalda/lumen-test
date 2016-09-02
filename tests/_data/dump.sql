CREATE TABLE `user` (
  `username` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `last_login` DATETIME NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `token` (
  `token` char(36) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`token`),
  INDEX `token_username` (`username` ASC),
  CONSTRAINT `token_username`
  FOREIGN KEY (`username`)
  REFERENCES `standup`.`user` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `report` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `yesterday` VARCHAR(200) NOT NULL,
  `today` VARCHAR(200) NOT NULL,
  `blockers` VARCHAR(200) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `report_username_date_unique` (`username` ASC, `date` ASC),
  INDEX `report_date` (`date` ASC),
  CONSTRAINT `report_username`
  FOREIGN KEY (`username`)
  REFERENCES `user` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;;
