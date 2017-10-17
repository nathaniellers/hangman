<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


define('BASE_URL', 'https://hangman.islandshore.net/');
define('ROOT_URL', $_SERVER['DOCUMENT_ROOT'].'/../');
define('WWW', BASE_URL);

define("MYSQL_HOST","localhost");
define("MYSQL_USER","hangmanuser");
define("MYSQL_PASS","hangmanuser12345");
define("MYSQL_DB","hangman");

define('SITE_TITLE', 'Hangman');

//router
define('BASE_ROUTE', 'public/');

// GAME VARS
define('MAX_GUESSES', 10);

// Requires
require_once 'src/modules/DBC.php';

require_once 'vendor/autoload.php';
require_once 'src/modules/freestrouter/Router.php';

require_once 'src/mvc/controller/Controller.php';
require_once 'src/mvc/controller/GameController.php';

require_once 'src/mvc/model/GameModel.php';

require_once 'src/modules/Game.php';
require_once 'src/modules/Guess.php';
require_once 'src/modules/Word.php';