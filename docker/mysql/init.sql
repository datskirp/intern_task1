CREATE TABLE IF NOT EXISTS `users` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                         `email` VARCHAR(320) NOT NULL ,
                         `first_name` VARCHAR(120) NOT NULL ,
                         `last_name` VARCHAR(120) NOT NULL ,
                         `password` CHAR(255) NOT NULL,
                        `created_date` TIMESTAMP NOT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;