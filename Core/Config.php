<?php
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    define('PATH', '/'.$uri[1]);