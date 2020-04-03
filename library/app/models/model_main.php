<?php


class Model_Main extends Model
{
    public function get_data()
    {
        $offset = $_GET['offset'] ?? 20;
        $search = $_GET['search'] ?? '%';
        $author = $_GET['author'] ?? '%';
        $year = $_GET['year'] ?? '%';


        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->query('
            SELECT books.*,
            GROUP_CONCAT(authors.name ORDER BY authors.name DESC SEPARATOR \', \')
            AS author
            FROM books
            INNER JOIN booksAuthors ON books.id = booksAuthors.book_id
            INNER JOIN authors ON booksAuthors.author_id = authors.id
            WHERE books.name LIKE "%'.$search.'%"
            AND authors.name LIKE "'.$author.'"
            AND books.year LIKE "'.$year.'"
            GROUP BY books.name
            LIMIT '.$offset);
        return ['books' => $stmt->fetchAll()];
    }
}