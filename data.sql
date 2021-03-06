create table if not exists `user` (
    `id` int not null auto_increment,
    `email` varchar(64) not null,
    `password_hash` char(64) not null, -- hashed with sha256
    `password_salt` char(32) not null, -- combined with raw password to generate hash
    `reset_token` char(32) not null,
unique key(`email`),
primary key(`id`));

create table if not exists `note` (
    `id` int not null auto_increment,
    `author_id` int not null,
    `title` varchar(128) not null,
    `body` text not null,
    `is_shared` tinyint(1) not null default 0,
    `created` datetime default current_timestamp,
foreign key(`author_id`)
    references `user`(`id`)
    on delete cascade,
unique key(`author_id`, `title`),
primary key(`id`));

CREATE PROCEDURE `create_note` (IN `author_id` INT(8), IN `title` VARCHAR(128))
INSERT INTO `note` (`author_id`, `title`, `body`)
    VALUES (author_id, title, '')
    ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);
