<?php
$dir = dirname(__DIR__);
include $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'DB.php';
$db = new DB();
$db->install();