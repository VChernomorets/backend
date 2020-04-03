<?php


class Controller_Admin extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
    }

    function action($action){
        if(method_exists($this, $action)){
            $this->$action();
        } else {
            echo 'Not action!';
        }
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'admin/template_view.php', $data);
    }

}