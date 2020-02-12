<?php

$app = dirname(__DIR__,3). DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
include $app .  'Accounts.php';

$accounts = new Accounts();
$accounts->logout();
echo json_encode(['ok' => true]);