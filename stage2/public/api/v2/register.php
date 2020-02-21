<?php

$data = json_decode(file_get_contents('php://input'), true);
if (($data['login'] ?? '') === '' || ($data['pass'] ?? '') === '') {
    header('HTTP/1.0 400 Bad Request');
    echo 'Error in user or pass field';
    return;
}

$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Accounts.php';

$accounts = new Accounts();
if ($accounts->register($data['login'], $data['pass'])) {
    echo json_encode(['ok' => true]);
}