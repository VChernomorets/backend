create table if not exists `authors` (
    `id` int(10) unsigned not null auto_increment,
    `name` varchar(255) not null unique,
    `created` timestamp default current_timestamp,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;