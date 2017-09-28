create table if not exists `user` (
    `id` int not null auto_increment,
    `username` varchar(64) not null,
    `password_hash` char(64) not null, -- hashed with sha256
    `password_salt` char(32) not null, -- combined with raw password to generate hash
unique key(`username`),
primary key(`id`));
