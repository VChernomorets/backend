<?php


class Model_Book extends Model
{
    public function get_data()
    {
        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT * FROM books WHERE id = :id');
        $stmt->execute([':id' => 1]);
    }
}