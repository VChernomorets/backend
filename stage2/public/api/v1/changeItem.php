<?php
$data = json_decode(file_get_contents("php://input"), true);

$text = $data['text'] ?? '';
$id = $data['id'] ?? '';
$checked = $data['checked'] ?? '';

checkParameters($id, $text, $checked);

$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
$todo->change($id, $text, $checked);
echo json_encode(['ok' => true]);

function checkParameters($id, $text, $checked){
    if($id === '' || !is_numeric($id)){
        showError('Id must contain an integer character');
    }
    if($text === ''){
        showError('$text - should not be empty');
    }
    if($checked === '' || !is_bool($checked)){
        showError('$checked must contain true or false');
    }
}

function showError($message){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => $message]);
    return;
}