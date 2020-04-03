<?php


class Model_Admin extends Model
{
    function get_data()
    {
        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->query('
            SELECT books.*,
            GROUP_CONCAT(authors.name ORDER BY authors.name DESC SEPARATOR \', \')
            AS author
            FROM books
            INNER JOIN booksAuthors ON books.id = booksAuthors.book_id
            INNER JOIN authors ON booksAuthors.author_id = authors.id
            GROUP BY books.name');



        return ['books' => $stmt->fetchAll()];
    }
}