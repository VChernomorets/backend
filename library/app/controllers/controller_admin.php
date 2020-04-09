<?php


class Controller_Admin extends Controller
{
    private $actions;

    public function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
    }

    function action($actions)
    {
        $this->actions = $actions;
        $action = 'action_' . $actions[0];
        if (method_exists($this, $action)) {

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

    function action_form(){
        $formName = 'Form_' . $this->actions[1];
        $formPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Form' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $formName . '.php';
        if (file_exists($formPath)) {
            include_once $formPath;
            $form = new $formName;
            $form->handle();
        } else {
            echo '404';
        }
    }

}

