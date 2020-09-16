<?php

//INCLUDE THE FILES NEEDED...
require_once('controller/Authenticate.php');
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

$form = new LoginView($user);
$dtv = new DateTimeView();
$layoutView = new LayoutView();




$layoutView->render(false, $form, $dtv); // Is logged in or not?


//$userStorage->isUser("Admin");


