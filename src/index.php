<?php


session_start();
//INCLUDE THE FILES NEEDED...
require_once('controller/FormHandle.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/UserStorage.php');
require_once('model/User.php');


//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS

$userStorage = new UserStorage(); //Felmeddelanden?


$user = new User($userStorage); //Is logged in or not?

$formHandle = new FormHandle($user);
$formLayout = new LoginView($user, $formHandle->getMessage());
$dtv = new DateTimeView();
$layoutView = new LayoutView();


$layoutView->render($user->isLoggedIn(), $formLayout, $dtv); 


//$userStorage->isUser("Admin");


