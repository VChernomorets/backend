<?php


class Model_Admin extends Model
{
    function get_data($param = null)
    {
        $offset = (($_GET['page'] ?? 1) - 1) * 20;


        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->prepare('
            SELECT books.*,
            GROUP_CONCAT(authors.name ORDER BY authors.name DESC SEPARATOR \', \')
            AS author
            FROM books
            LEFT JOIN booksAuthors ON books.id = booksAuthors.book_id
            LEFT JOIN authors ON booksAuthors.author_id = authors.id
            GROUP BY books.name
            LIMIT :offset, 20');
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = ['books' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        $stmt = $db->query('SELECT COUNT(*) AS count FROM books');
        $data['numberBooks'] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
        return $data;
    }
}