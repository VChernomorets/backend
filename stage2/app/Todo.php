<?php


class Todo
{
    private $config;

    public function __construct()
    {
        $this->config = include 'config.php';
    }

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

    private function write($date = null){
        $file = fopen($this->config['data']['todo'], 'w');
        if($date != null){
            fwrite($file, json_encode($date));
        }
        fclose($file);
    }

    private function showError($message){
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(['error' => $message]);
        return;
    }
}