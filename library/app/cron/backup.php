<?php
$backup_folder = '/var/www/library.vchernomorets.tk/backup/db';
$backup_name = 'my_site_backup_' . date("Y-m-d-g");

$db_host = 'localhost';
$db_user = 'backend';
$db_password = 'password';
$db_name = 'library';

$fullFileName = $backup_folder . '/' . $backup_name . '.sql';
$command = 'mysqldump --user=' . $db_user . ' --password=' . $db_password . ' --host=' . $db_host . ' ' . $db_name . ' > ' . $fullFileName;
shell_exec($command);

