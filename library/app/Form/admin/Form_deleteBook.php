<?php


class Form_DeleteBook extends Form
{
    public function handle()
    {
        if(!is_numeric($_GET['id'] ?? '')){
            $this->showError('Incorrect id');
        }
        $stmt = $this->db->prepare('UPDATE books SET deleted = 1 WHERE id = :id');
        $stmt->execute([
            ':id' => htmlspecialchars($_GET['id'])
        ]);
    }
}