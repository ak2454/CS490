CREATE TABLE IF NOT EXISTS `Comments` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT,
    `post_id` INT,
    `comment` VARCHAR(150) NOT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
    FOREIGN KEY (`post_id`) REFERENCES Posts(`id`)
)