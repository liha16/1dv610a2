<?php

namespace Controller;

//INCLUDE THE FILES NEEDED...
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/UploadController.php');
require_once('view/UploadImageView.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/UserStorage.php');
require_once('model/SessionStorage.php');

class App {

    private static $register = 'register';
    private static $uploadImage = 'upload';
    private $session;
    private $userStorage;
    private $formLayout;
    private $uploadImageView;
     

	public function __construct() {
    // Init model classes needed
    $this->session = new \Model\SessionStorage();
    $this->userStorage = new \Model\UserStorage();
    $this->uploadImageView = new \View\UploadImageView();
    }

    public function run() {
        $this->route();
        $this->loadLayouts();
        $this->session->unsetMessage(); //Unsets all flash messages
    }

    private function route() {
        // Route with paramenters
        if (isset($_GET[self::$register])) { // TODO Make sepatare functions for each route
            new \Controller\RegisterController($this->userStorage, $this->session); // register members
            $this->formLayout = new \View\RegisterView($this->userStorage, $this->session->getMessage());
        } elseif (isset($_GET[self::$uploadImage]) && $this->session->isLoggedIn()) { // upload image
            new \Controller\UploadController($this->userStorage, $this->session);
            $this->formLayout = new \View\LoginView($this->userStorage, $this->session->getMessage(), $this->uploadImageView);
        } else { // default page
            new \Controller\LoginController($this->userStorage, $this->session);
            $this->formLayout = new \View\LoginView($this->userStorage, $this->session->getMessage(), $this->uploadImageView);
        }
    }

    private function loadLayouts() {
        $dtv = new \View\DateTimeView();
        $layoutView = new \View\LayoutView();
        $layoutView->render($this->session->isLoggedIn(), $this->formLayout, $dtv); 
    }


}

?>