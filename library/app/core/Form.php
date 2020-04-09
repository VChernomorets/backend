<?php


class Form
{
    public $db;

    public function __construct()
    {
        include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'DB' . DIRECTORY_SEPARATOR . 'DB.php';
        $this->db = DB::getInstance();
    }

    function handle(){

    }

    function showError($message){
        header('HTTP/1.1 400 Bad Request');
        header('Status: 400 Bad Request');
        exit(json_encode(['error' => $message]));
    }

    function redirectToReferer(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}