<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = $data['text'] ?? '';

if($text === ''){
    // вывести ошибку
}
$text = htmlspecialchars($text);

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->add($text);
echo json_encode(['ok' => true]);