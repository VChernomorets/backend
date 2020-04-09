<?php


class Model_Book extends Model
{
    public function get_data($param = null)
    {
        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->prepare('
            SELECT books.*,
            GROUP_CONCAT(authors.name ORDER BY authors.name DESC SEPARATOR \', \')
            AS author
            FROM books
            LEFT JOIN booksAuthors ON books.id = booksAuthors.book_id
            LEFT JOIN authors ON booksAuthors.author_id = authors.id
            WHERE books.id = :id
            GROUP BY books.name');
        $stmt->execute([':id' => $param['id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }
}