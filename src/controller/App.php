<?php

namespace Controller;

//INCLUDE THE FILES NEEDED...
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('controller/UploadImageController.php');
require_once('view/UploadImageView.php');
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/ImageListView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RouterView.php');
require_once('view/MessageSession.php');
require_once('model/UserList.php');
require_once('model/UserSession.php');

class App {

    
    private $userSession;
    private $userList;
    private $pageLayout;
    private $uploadImageView;
    private $viewImages;
    private $loginView;
    private $loginController;
    private $uploadController;
    private $imageListView;
     

	public function __construct() {
    
    $this->userSession = new \Model\UserSession();
    $this->userList = new \Model\UserList();
    $this->imageModel = new \Model\ImageList();

    $this->messageSession = new \View\MessageSession();
    $this->routerView = new \View\RouterView();
    $this->dtv = new \View\DateTimeView();
    $this->imageListView = new \View\ImageListView($this->imageModel);
    $this->uploadImageView = new \View\UploadImageView();
    $this->registerView = new \View\RegisterView();
    $this->loginView = new \View\LoginView($this->userList, $this->userSession, $this->messageSession);
    $this->layoutView = new \View\LayoutView();
    
    $this->uploadController = new \Controller\UploadImageController($this->uploadImageView, $this->imageModel);
    $this->loginController = new \Controller\LoginController($this->userSession, $this->loginView, $this->messageSession);
    $this->registerController = new \Controller\RegisterController($this->userList, $this->userSession, $this->registerView, $this->messageSession);    
}

    /**
	 * Runs the app
	 *
     * @return void
	 */
    public function run() {
        $this->route();
        $this->layoutView->render($this->userSession->isLoggedIn(), $this->pageLayout, $this->dtv, $this->routerView); 
        $this->messageSession->unsetMessage(); //Unsets all flash messages
    }

    /**
	 * Routes to controllers and sets views
	 *
     * @return void
	 */
    private function route() {
        // Load default
        $this->loginController->setLogin();
        //$this->pageLayout = new \View\LoginView($this->userStorage, $this->session); // TODO BORT
        $this->pageLayout = $this->loginView;

        if ($this->userSession->isLoggedIn()) { // LOGGED IN ONLY:
            if ($this->routerView->doesUserWantsUploadImage()) { // upload image
                $this->uploadController->handleUpload();
                //$this->uploadImageView->setMessage($this->session->getMessage());
                $this->pageLayout = $this->uploadImageView;
            } 
            if ($this->routerView->doesUserWantsToViewImages()) { // view images
                $this->pageLayout = $this->imageListView;
            } 
        }
        if ($this->routerView->doesUserWantsToRegister()) { // register new user
            $this->registerController->setRegister();
            //$this->registerView->updateMessage($this->session->getMessage());
            $this->pageLayout = $this->registerView;
        }
    }



}

?>