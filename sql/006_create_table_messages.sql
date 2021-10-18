CREATE TABLE IF NOT EXISTS `Messages`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `sender_id` INT NOT NULL,
    `receiver_id` INT NOT NULL,
    `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `content` VARCHAR(250),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sender_id`) REFERENCES Users(`id`),
    FOREIGN KEY (`receiver_id`) REFERENCES Users(`id`)


)