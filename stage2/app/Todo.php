<?php
include 'DB.php';


/**
 * Class Todo
 * A class can create, delete, edit, return records.
 * And also stores them.
 */
class Todo
{
    private $config;
    private $db;

    public function __construct()
    {
        $this->config = include 'config.php';
        $this->db = new DB();
    }

    /**
     * Returns a list of all records.
     * @return array List of entries.
     */
    public function getItems(){
        return $this->db->select('SELECT * FROM `todo`', []);
    }

    /**
     * Modifies an existing entry by its id.
     * If the entry is not found, displays an error.
     * @param $id int identifier
     * @param $text string Post text
     * @param $checked bool status
     */
    public function change($id, $text, $checked){
        $this->existId($id);
        $this->db->update('UPDATE `todo` SET `text` = :text, `checked` = :checked WHERE `id` = :id', ['id' => $id, 'text' => $text, 'checked' => (int) $checked]);
    }

    /**
     * Deletes an item by its identifier.
     * @param $id int Identifier
     */
    public function delete($id){
        $this->existId($id);
        $this->db->delete('DELETE FROM `todo` WHERE `id` = :id', ['id' => $id]);
    }

    /**
     * Reads all items. Recognizes the identifier of the last item and creates a new item.
     * @param $text string New Entry Text
     */
    public function add($text){
        $this->db->insert('INSERT INTO `todo` (`id`, `text`, `checked`) VALUES (NULL, :text, \'0\');', ['text' => $text]);
    }

    /**
     * Writes all entries to a file.
     * @param null $date
     */
    private function write($date = null){
        $file = fopen($this->config['data']['todo'], 'w');
        if($date != null){
            fwrite($file, json_encode($date));
        }
        fclose($file);
    }

    private function existId($id){
        $result = $this->db->select('SELECT EXISTS(SELECT `id` FROM `todo` WHERE `id` = :id)', ['id' => $id]);
        if(array_shift($result[0]) === '0'){
            $this->showError('Record with such id not found');
        }
    }

    /**
     * It displays an error message and terminates the script.
     * @param $message string error message
     */
    private function showError($message){
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(['error' => $message]);
        exit();
    }
}