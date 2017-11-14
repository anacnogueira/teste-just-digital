CREATE TABLE `just_digital`.`posts` ( 
	`id` INT NOT NULL AUTO_INCREMENT , 
	`title` VARCHAR(255) NOT NULL , 
	`body` TEXT NOT NULL , 
	`path` VARCHAR(255) NOT NULL , 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;