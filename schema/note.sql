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
