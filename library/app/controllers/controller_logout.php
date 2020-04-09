<?php


class Controller_Logout
{
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
        ?>
        <script>
            let XHR = new XMLHttpRequest();
            XHR.open("GET", "/admin/", true, "no user", "no password");
            XHR.send();
            document.write('You are out! Redirecting ...');
            setTimeout(function () {
                window.location.href = "/";
            }, 3000);
        </script>
        <?php
    }
}