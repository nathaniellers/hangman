<?php
namespace freest\router;

ini_set('error_reporting', E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'STDOUT');


// so we can request the url?
define('BASE_ROUTE','router');

require 'Router.php';

$router = new Router();

// suggest routes and a return value
$router->route('',          0);
$router->route('index.php', 0);
$router->route('articles',  1);

switch($router->get()) {
    case '0':
        // front
        echo 0;
        break;
    case '1':
        // articles
        echo 1;
        break;
    default:
        require '404.html';
}