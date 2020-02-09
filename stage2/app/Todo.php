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
                $item['text'] = $text;
                $item['checked'] = $checked;
                $this->write($data);
                return;
            }
        }
        // обработать ошибку
    }

    public function delete($id){
        $data = $this->getItems();
        foreach ($data as $item) {
            if($item['id'] == $id){
                unset($data[$item]);
                sort($data);
                $this->write($data);
                return;
            }
        }
        // обработать ошибку
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

}