<?php

session_start();

require_once('controller/App.php');

//FOR DEVELOPMENT, UNCOMMENT:
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$app = new \Controller\App();
$app->run();





