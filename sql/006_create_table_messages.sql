CREATE TABLE IF NOT EXISTS `Messages`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `sender_id` INT,
    `receiver_id` INT,
    `created_time` DATETIME,
    `updated_time` DATETIME,
    `content` VARCHAR(250),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sender_id`) REFERENCES Users(`id`),
    FOREIGN KEY (`receiver_id`) REFERENCES Users(`id`)


)