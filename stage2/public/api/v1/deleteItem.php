<?php
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';

if($id === '' || !is_numeric($id)){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => 'Id must contain an integer character']);
    return;
}

$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Todo.php';
include $app .  'Accounts.php';
$accounts = new Accounts();
$accounts->checkAuth();
$todo = new Todo();
$todo->delete($id);
echo json_encode(['ok' => true]);