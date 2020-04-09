<?php
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
$db = DB::getInstance();
$db->query("DELETE FROM books WHERE deleted = 1");