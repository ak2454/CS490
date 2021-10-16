CREATE TABLE IF NOT EXISTS `Posts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT,
    `caption` VARCHAR(150) NOT NULL,
    `img_url` VARCHAR(250),
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `is_blocked` INT DEFAULT 1,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES Users(`id`)
)