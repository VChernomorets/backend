<?php


class Route
{
    static function start()
    {
        $controller_name = 'Main';
        $action_name = 'index';

        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (substr($uri, 1, 1) !== '?') {
            $routes = explode('/', $uri);
            if (!empty($routes[1])) {
                $controller_name = $routes[1];
            }
            if (!empty($routes[2])) {
                $action_name = $routes[2];
            }
        }

        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        $model_file = strtolower($model_name) . '.php';
        $model_path = dirname(__DIR__) . '/models/' . $model_file;
        if (file_exists($model_path)) {
            include $model_path;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = dirname(__DIR__) . '/controllers/' . $controller_file;
        //var_dump(file_exists($controller_path));
        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            Route::error('Controller Path: ' . $controller_path);
        }

        $controller = new $controller_name;
        $controller->action($action_name);
        /*if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::error('Method action');
        }*/
    }

    static function error($message)
    {
        var_dump($message);
    }

    static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . '404');
    }
}