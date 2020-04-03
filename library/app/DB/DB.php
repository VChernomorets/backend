<?php

class DB {

    protected static $instance;

    protected function __construct() {}

    public static function getInstance() {

        if(empty(self::$instance)) {

            $config = include dirname(__DIR__) . '/config/db/config.php';
            try {
                self::$instance = new PDO("mysql:host=" . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['pass']);
            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }
        return self::$instance;
    }
}