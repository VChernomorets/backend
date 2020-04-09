<?php


class Controller_Book extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Book();
        $this->view = new View();
    }

    function action($actions){
        $action = 'action_' . $actions[0];
        if(method_exists($this, $action)){
            $this->$action();
        } else {
            $bookId = $actions[0];
            if(!is_numeric($bookId)){
                $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                header('HTTP/1.1 404 Not Found');
                header('Status: 404 Not Found');
                header('Location:' . $host . '404');
                exit();
            }
            $db = DB::getInstance();
            $stmt = $db->prepare('UPDATE books SET click = click +1 WHERE id = :id');
            $stmt->execute(['id' => $bookId]);
            $data = $this->model->get_data(['id'=>$bookId]);
            $this->view->generate('book_view.php', 'template_view.php', $data);
        }
    }
}