CREATE TABLE IF NOT EXISTS `users` (
                         `id` INT NOT NULL AUTO_INCREMENT ,
                         `email` VARCHAR(255) NOT NULL ,
                         `name` VARCHAR(255) NOT NULL ,
                         `gender` VARCHAR(30) NOT NULL,
                         `status` VARCHAR(30) NOT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;