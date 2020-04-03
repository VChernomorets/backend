<?php
ini_set('display_errors', 1);
include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';

$db = DB::getInstance();
$sqlFolder = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'migration'. DIRECTORY_SEPARATOR;


$files = getMigrationFiles($db, $sqlFolder);
if (empty($files)) {
    echo 'Your database is up to date.';
} else {
    echo 'Start the migration...<br><br>';

    foreach ($files as $file) {
        migrate($db, $file);
        echo basename($file) . '<br>';
    }
    echo '<br>Migration completed.';
}


function migrate($db, $file){
    $db->query(file_get_contents($file));
    $db->query('INSERT INTO `library`.`versions` (`name`) VALUES ("' . basename($file) .'")');
}

function getMigrationFiles($db, $sqlFolder){
    $allFiles = glob( $sqlFolder. '*.sql');
    $result = $db->query('SHOW TABLES LIKE "versions"');
    $result = $result->fetchAll();
    if(count($result) === 0){
        return $allFiles;
    }

    $versionsFiles = $db->query('SELECT `name` FROM `versions` ORDER BY `id` DESC');
    $versionsFiles = array_map(function ($row) use ($sqlFolder){
        return $sqlFolder . $row[0];
    }, $versionsFiles->fetchAll(PDO::FETCH_NUM));
    return array_diff($allFiles, $versionsFiles);
}
