<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = trim($data['text']) ?? '';

if($text === ''){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => '$text - should not be empty']);
    return;
}
$text = htmlspecialchars($text);

$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Todo.php';
include $app .  'Accounts.php';
$accounts = new Accounts();
$accounts->checkAuth();
$todo = new Todo();
$todo->add($text);
echo json_encode(['ok' => true]);