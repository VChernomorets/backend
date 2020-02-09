<?php
$id = $_POST['id'] ?? $_GET['id'] ?? '';

if($id === '' || !is_numeric($id)){
    // вывести ошибку
}

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->delete($id);
echo json_encode(['ok' => true]);