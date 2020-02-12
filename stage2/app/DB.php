<?php


class DB
{
    private $config;
    private $db;

    public function __construct()
    {
        $this->config = include 'config.php';
        $this->db = new PDO("mysql:dbname={$this->config['db']['dbname']};host={$this->config['db']['host']}", $this->config['db']['user'], $this->config['db']['password']);
    }

    public function insert($sql, $param){
        $query = $this->db->prepare($sql);
        $query->execute($param);
    }

    public function update($sql, $param){
        $query = $this->db->prepare($sql);
        $query->execute($param);
    }

    public function select($sql, $param){
        $query = $this->db->prepare($sql);
        $query->execute($param);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($sql, $param){
        $query = $this->db->prepare($sql);
        $query->execute($param);
    }

    /**
     * creates a table with users,
     * and a table with entries
     */
    public function install()
    {
        $this->db->query('
            CREATE TABLE IF NOT EXISTS `todo` (
            `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `text` text NOT NULL,
            `checked` BOOLEAN NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `user` (
            `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `name` varchar(65) NOT NULL,
            `pass` varchar(65) NOT NULL,
            `hash` varchar(65) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ');
        echo json_encode(['ok' => 'true']);
    }
}