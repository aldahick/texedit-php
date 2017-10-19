CREATE PROCEDURE `create_note` (IN `author_id` INT(8), IN `title` VARCHAR(128))
INSERT INTO `note` (`author_id`, `title`, `body`)
    VALUES (author_id, title, '')
    ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);
