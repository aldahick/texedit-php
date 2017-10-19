create table if not exists `user` (
    `id` int not null auto_increment,
    `username` varchar(64) not null,
    `password_hash` char(64) not null, -- hashed with sha256
    `password_salt` char(32) not null, -- combined with raw password to generate hash
unique key(`username`),
primary key(`id`));

create table if not exists `note` (
    `id` int not null auto_increment,
    `author_id` int not null,
    `title` varchar(128) not null,
    `body` text not null,
    `created` datetime default current_timestamp,
foreign key(`author_id`)
    references `user`(`id`)
    on delete cascade,
unique key(`author_id`, `title`),
primary key(`id`));