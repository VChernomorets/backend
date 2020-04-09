<?php


class Form_WantRead extends Form
{
    public function handle()
    {
        if(!is_numeric($_POST['id'] ?? '')){
            $this->showError('Incorrect id');
        }
        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE books SET wantRead = wantRead + 1 WHERE id = :id');
        $stmt->execute([
            ':id' => htmlspecialchars($_POST['id'])
        ]);
    }
}