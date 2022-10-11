CREATE TABLE IF NOT EXISTS `users` (
                         `id` bigint NOT NULL ,
                         `email` VARCHAR(320) NOT NULL ,
                         `name` VARCHAR(120) NOT NULL ,
                         `gender` VARCHAR(30) NOT NULL,
                         `status` VARCHAR(30) NOT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;