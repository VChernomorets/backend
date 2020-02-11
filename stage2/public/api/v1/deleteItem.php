<?php
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';

if($id === '' || !is_numeric($id)){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => 'Id must contain an integer character']);
    return;
}

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->delete($id);
echo json_encode(['ok' => true]);