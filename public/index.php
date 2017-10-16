<?php
session_start();

use btcbe\mvc\controller\Controller as Controller;

require '../global_config.php';

// Start controller
$controller = new Controller();

// Invoke Controller
$controller->invoke();

/**
 * TODO
 * 
 * - Add business 
 */