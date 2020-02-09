<?php
$dir = dirname(__DIR__,3);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Todo.php';
$todo = new Todo();
echo json_encode($todo->getItems());