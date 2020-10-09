<?php

namespace Controller;

require_once('model/User.php');


class RegisterController {

    private $userList;
    private $userSession;
    private $registerView;
    private $msgSession;

	
    public function __construct(\Model\UserList $userList, \Model\UserSession $userSession, \View\RegisterView $registerView, \View\MessageSession $msgSession) {
        $this->userList = $userList;
        $this->userSession = $userSession;
        $this->registerView = $registerView;
        $this->msgSession = $msgSession;
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
                $this->isUsernameAvailable();
                $this->registerUser(); 
            } catch (\Exception $e) {
                $this->msgSession->setMessage($e->getMessage());
            }
        }
        $this->registerView->updateMessage($this->msgSession->getMessage());
    }

    private function isUsernameAvailable() {
        if ($this->userList->isUser($this->registerView->getName())) {
            throw new \Exception("User exists, pick another username.");
        }
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
        $this->userList->saveNewUser($newUser);
        $message = "Registered new user."; // TODO exceptions
        $this->userSession->destroyUserSession(); // logs out if user wants to register
        $this->msgSession->setMessage($message);
        $this->headerLocation("index.php");
    }


}

?>