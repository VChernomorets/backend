<?php
$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Todo.php';
include $app .  'Accounts.php';
$accounts = new Accounts();
$accounts->checkAuth();
$todo = new Todo();
echo json_encode($todo->getItems());