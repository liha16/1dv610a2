<?php

namespace Controller;

//INCLUDE THE FILES NEEDED...
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/UploadController.php');
require_once('view/UploadImageView.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/ImageListView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RouterView.php');
require_once('model/UserStorage.php');
require_once('model/SessionStorage.php');

class App {

    
    private $session;
    private $userStorage;
    private $formLayout;
    private $uploadImageView;
    private $viewImages;
     

	public function __construct() {
    $this->session = new \Model\SessionStorage();
    $this->userStorage = new \Model\UserStorage();
    $this->routerView = new \View\RouterView();
    $this->viewImages = new \Model\ImageList();
    $this->UploadImageView = new \View\UploadImageView();
    $this->UploadController = new \Controller\UploadController($this->session, $this->UploadImageView, $this->viewImages);

    }

    public function run() {
        $this->route();
        $this->loadLayouts();
        $this->session->unsetMessage(); //Unsets all flash messages
    }

    private function route() {

        // Load default
        new \Controller\LoginController($this->userStorage, $this->session);
        $this->formLayout = new \View\LoginView($this->userStorage, $this->session->getMessage());


        if ($this->session->isLoggedIn()) { // LOGGED IN ONLY
            if ($this->routerView->doesUserWantsUploadImage()) { // upload image
                //new \Controller\UploadController($this->session);
                $this->UploadImageView->setMessage($this->session->getMessage());
                $this->formLayout = $this->UploadImageView;
            } 
            if ($this->routerView->doesUserWantsToViewImages()) { // view images
                $this->formLayout = new \View\ImageListView($this->viewImages->getImages());
            } 
        }

        if ($this->routerView->doesUserWantsToRegister()) { // register new user
            new \Controller\RegisterController($this->userStorage, $this->session);
            $this->formLayout = new \View\RegisterView($this->userStorage, $this->session->getMessage());
        }

        
    }

    private function loadLayouts() {
        $dtv = new \View\DateTimeView();
        $layoutView = new \View\LayoutView();
        $layoutView->render($this->session->isLoggedIn(), $this->formLayout, $dtv); 
    }


}

?>