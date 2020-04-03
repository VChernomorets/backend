create table if not exists `booksAuthors` (
    `id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY,
    `author_id` int(10) unsigned not null,
    `book_id` int(10) unsigned not null,
    `created` timestamp default current_timestamp,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE ,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;