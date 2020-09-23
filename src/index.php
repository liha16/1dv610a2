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
require_once('model/SessionHandle.php');


//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$sessionHandle = new SessionHandle();
$userStorage = new UserStorage(); //Felmeddelanden?
$user = new User($userStorage); //Is logged in or not?



if (isset($_GET['register'])) {
    $registerFormHandle = new RegisterFormHandle($user, $sessionHandle);
    $registerFormHandle->setMessage();
    $formLayout = new RegisterView($user, $sessionHandle->getMessageCookie()); // DO I HAVE TO CALL MESSAGE COOKE HERE???
} else {
    $loginFormHandle = new LoginFormHandle($user, $sessionHandle);
    $loginFormHandle->setMessage();
    $formLayout = new LoginView($user, $sessionHandle->getMessageCookie()); // DO I HAVE TO CALL MESSAGE COOKE HERE???

}


$dtv = new DateTimeView();
$layoutView = new LayoutView();

$layoutView->render($user->isLoggedIn(), $formLayout, $dtv); 


//$loginFormHandle->unsetMessageCookie();

$sessionHandle->unsetMessageCookie();


