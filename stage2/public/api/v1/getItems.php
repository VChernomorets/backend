<?php
$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Todo.php';
$todo = new Todo();
echo json_encode($todo->getItems());