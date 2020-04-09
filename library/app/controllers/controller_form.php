<?php


class Controller_Form extends Controller
{

    public function action_index()
    {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . '/404');
    }

    function action($actions)
    {
        $formName = 'Form_' . $actions[0];
        $formPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Form' . DIRECTORY_SEPARATOR . $formName . '.php';

        //echo $formPath;
        if (file_exists($formPath)) {
            include_once $formPath;
            $form = new $formName;
            $form->handle();
        } else {
            echo 'No';
        }
    }

}