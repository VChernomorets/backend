<?php

include 'DB.php';

class Accounts
{
    public $config;
    public $db;

    public function __construct()
    {
        $this->config = include 'config.php';
        $this->db = new DB();
        session_start();
    }

    /**
     * looking for a user in the database, comparing the password.
     * If everything matches, create a hash for the user and write it down.
     * @param $user string user login
     * @param $password string string user password
     * @return bool if everything is successful, returns true, otherwise false
     */
    public function login($user, $password){
        $accounts = $this->db->select("SELECT `pass` FROM `user` WHERE `name` = :login", ['login' => $user]);
        if(count($accounts) > 0 &&  $accounts[0]['pass'] === md5($password)){
            $this->db->update("UPDATE `user` SET `hash` = :hash WHERE `name` = :login", ['login' => $user, 'hash' => $this->createHash()]);
            return true;
        }
        return false;
    }

    /**
     * removes hash code in user session
     */
    public function logout(){
        unset($_SESSION['hash']);
    }

    /**
     * Checks for user existence.
     * If a user with this login exists, displays a message about it.
     * If there is no user with this name,
     * creates a new user, and also creates him.
     * @param $user string user login
     * @param $password string user password
     * @return bool if everything is successful, returns true, otherwise false
     */
    public function register($user, $password){
        $result = $this->db->select('SELECT EXISTS(SELECT `name` FROM `user` WHERE `name` = :name)', ['name' => $user]);
        if(array_shift($result[0]) === '1'){
            header('HTTP/1.0 400');
            echo 'A user with the same name already exists.';
            return false;
        }
        $this->db->insert('INSERT INTO `user` (`id`, `name`, `pass`, `hash`) VALUES (NULL, :name, :pass, :hash)', ['name' => $user, 'pass' => md5($password), 'hash' => $this->createHash()]);
        return true;
    }

    /**
     * If the user session has a hash code,
     * it searches for such code in the database.
     * If we find this, we will return true, otherwise false.
     */
    public function checkAuth(){
        $result = $this->db->select('SELECT * FROM `user` WHERE `hash` = :hash', ['hash' => $_SESSION['hash'] ?? '']);
        if(count($result) === 0){
            header('401 Unauthorized');
            echo json_encode(['error' => 'Please log in.']);
            exit();
        }
    }

    /**
     * Creates a random string with 20 characters,
     * and writes the user as hash code
     * @return string hash user code
     */
    private function createHash(){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $hash = '';
        for ($i = 0; $i < 20; $i++) {
            $hash .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        $_SESSION['hash'] = $hash;
        return $hash;
    }
}