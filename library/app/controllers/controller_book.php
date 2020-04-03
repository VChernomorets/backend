<?php


class Controller_Book extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Book();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('book_view.php', 'template_view.php', $data);
    }
}