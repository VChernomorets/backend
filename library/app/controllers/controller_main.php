<?php


class Controller_Main extends Controller
{
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Main();
    }

    function action($actions){
        $action = 'action_' . $actions[0];
        if(method_exists($this, $action)){
            $this->$action();
        } else {
            echo 'Not action!';
        }
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}