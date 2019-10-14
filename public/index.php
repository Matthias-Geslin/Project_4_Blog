<?php require('../src/View/template.php');

use App\Router;

/* Call Required of the Composer Autoload to load Classes */
require_once '../vendor/autoload.php';

/* Start Sessions Feature */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Create the Router */
$router = new Router();

/* Run Application */
$router->run();