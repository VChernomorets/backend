<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = $data['text'] ?? '';

if($text === ''){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => '$text - should not be empty']);
    return;
}
$text = htmlspecialchars($text);

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->add($text);
echo json_encode(['ok' => true]);