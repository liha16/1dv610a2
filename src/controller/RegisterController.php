<?php

namespace Controller;

require_once('model/User.php');


class RegisterController {

    private $userStorage;
    private $session;
    private $registerView;

	
    public function __construct(\Model\UserStorage $userStorage, \Model\SessionStorage $session, \View\RegisterView $registerView) {
        $this->userStorage = $userStorage;
        $this->session = $session;
        $this->registerView = $registerView;
    }

    /**
	 * Handles register form 
	 *
     * @return void
	 */
    public function setRegister() {
        if ($this->registerView->isRegisterFormPosted()) {
            try {
                $this->registerView->validateRegisterForm();
                $this->registerUser(); 
            } catch (\Exception $e) {
                $this->session->setMessage($e->getMessage());
            }
        }
        $this->registerView->updateMessage($this->session->getMessage());
    }

    /**
	 * Redirects to a valid path on server
	 *
	 */
    private function headerLocation(string $file) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$file");
        exit();
    }

    /**
	 * Creates new user object and saves to Storage
	 *
     * @return void, but saves so storage
	 */
    private function registerUser() {
        $newUser = new \Model\User;
        $newUser->setName($this->registerView->getName());
        $newUser->setPassword($this->registerView->getPassword());
        $this->userStorage->saveNewUser($newUser);
        $message = "Registered new user."; // TODO exceptions
        $this->session->destroyUserSession(); // logs out if user wants to register
        $this->session->setMessage($message);
        $this->headerLocation("index.php");
    }


}

?>