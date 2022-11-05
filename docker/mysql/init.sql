CREATE TABLE IF NOT EXISTS `users` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                         `email` VARCHAR(320) NOT NULL ,
                         `firstname` VARCHAR(120) NOT NULL ,
                         `lastname` VARCHAR(120) NOT NULL ,
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

CREATE TABLE IF NOT EXISTS `login_block_log` (
                   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                   `ip` INT(4) UNSIGNED NOT NULL ,
                `email` VARCHAR(320) NOT NULL ,
                `start_block` TIMESTAMP NOT NULL ,
                `end_block` TIMESTAMP NOT NULL ,
                PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `login_block` (
     `ip` INT(4) UNSIGNED NOT NULL ,
    `attempts` int(1) UNSIGNED NOT NULL,
    `end_block` BIGINT ,
    `begin_attempts` BIGINT,
    PRIMARY KEY (`ip`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `products` (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
   `name` VARCHAR(120) NOT NULL ,
    `manufacturer` VARCHAR(120) NOT NULL ,
    `release` DATE NOT NULL ,
    `cost` DECIMAL(8, 2) NOT NULL,
    `category` VARCHAR(120) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Clear view','Sony','2022-03-12','399', 'TVs');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Game-pro','Asus','2022-04-12','1699', 'Laptops');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('RedMe Note 11','Xiaomi','2022-02-22','299', 'Mobile phones');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Super Frost','Samsung','2021-03-12','499', 'Fridges');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Clear view','Sony','2022-03-12','399', 'TVs');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Game-pro','Asus','2022-04-12','1699', 'Laptops');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('RedMe Note 11','Xiaomi','2022-02-22','299', 'Mobile phones');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Super Frost','Samsung','2021-03-12','499', 'Fridges');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Clear view','Sony','2022-03-12','399', 'TVs');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Game-pro','Asus','2022-04-12','1699', 'Laptops');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('RedMe Note 11','Xiaomi','2022-02-22','299', 'Mobile phones');
INSERT INTO `products`(`name`, `manufacturer`, `release`, `cost`, `category`) VALUES ('Super Frost','Samsung','2021-03-12','499', 'Fridges');

CREATE TABLE IF NOT EXISTS `services` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(120) NOT NULL,
    `cost` DECIMAL(8, 2) NOT NULL,
    `deadline` INT NOT NULL,
    `category` VARCHAR(120) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('warranty', 100, 365, 'TVs');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('warranty', 50, 365, 'Laptops');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('warranty', 30, 365, 'Mobile phones');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('warranty', 50, 365, 'Fridges');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('delivery', 30, 10, 'TVs');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('delivery', 20, 10, 'Laptops');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('delivery', 10, 10, 'Mobile phones');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('delivery', 50, 15, 'Fridges');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('install', 20, 3, 'TVs');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('install', 20, 3, 'Laptops');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('install', 10, 1, 'Mobile phones');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('install', 20, 3, 'Fridges');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('configure', 10, 3, 'TVs');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('configure', 15, 3, 'Laptops');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('configure', 10, 1, 'Mobile phones');
INSERT INTO `services`(`type`, `cost`, `deadline`, `category`) VALUES ('configure', 10, 3, 'Fridges');

CREATE TABLE IF NOT EXISTS `order` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
    `user_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `order_products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT UNSIGNED NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`order_id`)
    REFERENCES `order` (`id`),
    FOREIGN KEY (`product_id`)
    REFERENCES `products` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `order_services` (
   `order_products_id` INT UNSIGNED NOT NULL,
   `services_id` INT UNSIGNED NOT NULL,
   PRIMARY KEY (`order_products_id`, `services_id`),
    FOREIGN KEY (`order_products_id`)
    REFERENCES `order_products` (`id`),
    FOREIGN KEY (`services_id`)
    REFERENCES `services` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cart` (
    `id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
   `cart` BLOB NOT NULL ,
   PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
