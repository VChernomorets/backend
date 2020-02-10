<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = $data['text'] ?? '';
$id = $data['id'] ?? '';
$checked = $data['checked'] ?? '';

if($id === '' || !is_numeric($id) || $text === '' || $checked === '' || !is_bool($checked)){
    // error
    echo 'error';
}

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->change($id, $text, $checked);
echo json_encode(['ok' => true]);