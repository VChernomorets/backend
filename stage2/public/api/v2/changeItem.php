<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = $data['text'] ?? '';
$id = $data['id'] ?? '';
$checked = $data['checked'] ?? '';

checkParameters($id, $text, $checked);

$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Todo.php';
include $app .  'Accounts.php';
$accounts = new Accounts();
$accounts->checkAuth();
$todo = new Todo();
$todo->change($id, $text, $checked);
echo json_encode(['ok' => true]);

// Checking the correctness of the parameters
function checkParameters($id, $text, $checked){
    if($id === '' || !is_numeric($id)){
        showError('Id must contain an integer character');
    }
    if($text === ''){
        showError('$text - should not be empty');
    }
    settype($checked, 'bool');
    if($checked === ''){
        showError('$checked must contain true or false');
    }
}

// We display an error message to the user
function showError($message){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => $message]);
    return;
}