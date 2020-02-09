<?php

$uri = $_SERVER['REQUEST_URI'];

// If uri is "/" - return the main page of the site.
if ($uri === '/') {
    include 'views/index.html';
    return;
}

// We pass the link that the user clicked on.
// In response, we get the number of visits to this page.
include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Linker.php';
$linker = new Linker();
echo 'Number of visits: ' . $linker->getCount($uri);