<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('controller/LoginFormHandle.php');
require_once('controller/RegisterFormHandle.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/UserStorage.php');
require_once('model/User.php');
require_once('model/SessionStorage.php');


//FOR DEVELOPMENT, UNCOMMENT:
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');


// Init model classes needed
$sessionStorage = new \Model\SessionStorage();
$userStorage = new \Model\UserStorage();
$user = new \Model\User($userStorage);


// Route
if (isset($_GET['register'])) { // When url has ?register
    $registerFormHandle = new RegisterFormHandle($user, $sessionStorage); // get and manage data from form
    $formLayout = new RegisterView($user, $sessionStorage->getMessageCookie()); // generate form output
} else { // default page
    $loginFormHandle = new LoginFormHandle($user, $sessionStorage);// get and manage data from form
    $formLayout = new LoginView($user, $sessionStorage->getMessageCookie()); // generate form output

}

// Load layouts
$dtv = new DateTimeView();
$layoutView = new LayoutView();
$layoutView->render($user->isLoggedIn(), $formLayout, $dtv); 

 //Unsets all flash messages
$sessionStorage->unsetMessageCookie();


