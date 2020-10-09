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
require_once('view/MessageStorage.php');
require_once('model/UserStorage.php');
require_once('model/SessionStorage.php');

class App {

    
    private $session;
    private $userStorage;
    private $formLayout;
    private $uploadImageView;
    private $viewImages;
    private $loginView;
    private $loginController;
    private $uploadController;
    private $imageListView;
     

	public function __construct() {
    
    $this->session = new \Model\SessionStorage();
    $this->userStorage = new \Model\UserStorage();
    $this->imageModel = new \Model\ImageList();

    $this->messageStorage = new \View\MessageStorage();
    $this->routerView = new \View\RouterView();
    $this->dtv = new \View\DateTimeView();
    $this->imageListView = new \View\ImageListView($this->imageModel);
    $this->uploadImageView = new \View\UploadImageView();
    $this->registerView = new \View\RegisterView($this->userStorage, $this->session);
    $this->loginView = new \View\LoginView($this->userStorage, $this->session);
    $this->layoutView = new \View\LayoutView();
    
    $this->uploadController = new \Controller\UploadController($this->session, $this->uploadImageView, $this->imageModel);
    $this->loginController = new \Controller\LoginController($this->session, $this->loginView);
    $this->registerController = new \Controller\RegisterController($this->userStorage, $this->session, $this->registerView);    
}

    /**
	 * Runs the app
	 *
     * @return void
	 */
    public function run() {
        $this->route();
        $this->layoutView->render($this->session->isLoggedIn(), $this->formLayout, $this->dtv, $this->routerView); 
        $this->session->unsetMessage(); //Unsets all flash messages
    }

    /**
	 * Routes to controllers and sets views
	 *
     * @return void
	 */
    private function route() {
        // Load default
        $this->loginController->setLogin();
        $this->formLayout = new \View\LoginView($this->userStorage, $this->session); // TODO BORT

        if ($this->session->isLoggedIn()) { // LOGGED IN ONLY:
            if ($this->routerView->doesUserWantsUploadImage()) { // upload image
                $this->uploadImageView->setMessage($this->session->getMessage());
                $this->formLayout = $this->uploadImageView;
            } 
            if ($this->routerView->doesUserWantsToViewImages()) { // view images
                $this->formLayout = $this->imageListView;
            } 
        }
        if ($this->routerView->doesUserWantsToRegister()) { // register new user
            $this->registerController->setRegister();
            $this->registerView->updateMessage($this->session->getMessage());
            $this->formLayout = $this->registerView;
        }
    }



}

?>