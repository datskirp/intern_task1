CREATE TABLE IF NOT EXISTS `users` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                         `email` VARCHAR(320) NOT NULL ,
                         `first_name` VARCHAR(120) NOT NULL ,
                         `last_name` VARCHAR(120) NOT NULL ,
                         `password` CHAR(255) NOT NULL,
                        `created_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                         PRIMARY KEY (`id`),
                         UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_tokens` (
                   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `selector` VARCHAR(255) NOT NULL ,
                    `validator` CHAR(255) NOT NULL,
                    `user_id` INT UNSIGNED NOT NULL,
                    `expiration` DATETIME NOT NULL,
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`user_id`)
                    REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `login_block` (
                   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                   `ip` INT(4) UNSIGNED NOT NULL ,
                `email` VARCHAR(320) NOT NULL ,
                `start_block` TIMESTAMP NOT NULL ,
                `end_block` TIMESTAMP NOT NULL ,
                PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
