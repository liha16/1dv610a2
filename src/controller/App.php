<?php

namespace Controller;

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

class App {

    private static $register = 'register'; // route
    private $user;
    private $sessionStorage;
    private $userStorage;
    private $formLayout;

	public function __construct() {
    // Init model classes needed
    $this->sessionStorage = new \Model\SessionStorage();
    $this->userStorage = new \Model\UserStorage();
    $this->user = new \Model\User($this->userStorage);
    }

    public function run() {
        $this->route();
        $this->loadLayouts();
        $this->sessionStorage->unsetMessageCookie(); //Unsets all flash messages
    }

    public function route() {
        // Route
        if (isset($_GET[self::$register])) {
            new \Controller\RegisterFormHandle($this->user, $this->sessionStorage); // get and manage data from form
            $this->formLayout = new \View\RegisterView($this->user, $this->sessionStorage->getMessageCookie()); // generate form output
        } else { // default page
            new \Controller\LoginFormHandle($this->user, $this->sessionStorage);// get and manage data from form
            $this->formLayout = new \View\LoginView($this->user, $this->sessionStorage->getMessageCookie()); // generate form output
        }
    }

    public function loadLayouts() {
        $dtv = new \View\DateTimeView();
        $layoutView = new \View\LayoutView();
        $layoutView->render($this->sessionStorage->isLoggedIn(), $this->formLayout, $dtv); 
    }


}

?>