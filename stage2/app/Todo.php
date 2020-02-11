<?php

/**
 * Class Todo
 * A class can create, delete, edit, return records.
 * And also stores them.
 */
class Todo
{
    private $config;

    public function __construct()
    {
        $this->config = include 'config.php';
    }

    /**
     * Returns a list of all records.
     * @return array List of entries.
     */
    public function getItems(){
        if(!file_exists($this->config['data']['todo'])){
            $this->write();
            return [];
        }
        if($data = file_get_contents($this->config['data']['todo'])){
            return json_decode($data, true);
        }
        return [];
    }

    /**
     * Modifies an existing entry by its id.
     * If the entry is not found, displays an error.
     * @param $id int identifier
     * @param $text string Post text
     * @param $checked bool status
     */
    public function change($id, $text, $checked){
        $data = $this->getItems();
        foreach ($data as $item) {
            if($item['id'] === $id){
                $i = array_search($item, $data);
                $data[$i]['text'] = $text;
                $data[$i]['checked'] = $checked;
                $this->write($data);
                return;
            }
        }
        $this->showError('Record with such id not found');
    }

    /**
     * Deletes an item by its identifier.
     * @param $id int Identifier
     */
    public function delete($id){
        $data = $this->getItems();
        foreach ($data as $item) {
            if($item['id'] == $id){
                unset($data[array_search($item, $data)]);
                sort($data);
                $this->write($data);
                return;
            }
        }
        $this->showError('Record with such id not found');
    }

    /**
     * Reads all items. Recognizes the identifier of the last item and creates a new item.
     * @param $text string New Entry Text
     */
    public function add($text){
        $data = $this->getItems();
        $id = 0;
        if(count($data) !== 0){
            $id = ($data[count($data) -1 ]['id']) + 1;
        }
        array_push($data, [
            'id' => $id,
            'text' => $text,
            'checked' => false
            ]);
        $this->write($data);
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

    /**
     * It displays an error message and terminates the script.
     * @param $message string error message
     */
    private function showError($message){
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(['error' => $message]);
        return;
    }
}