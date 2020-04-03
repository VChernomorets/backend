<?php


class Controller_Logout
{
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