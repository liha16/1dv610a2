<?php

namespace Controller;

class LoginController {

    private $userStorage;
    private $session;
    private $loginView;
    

    public function __construct(\Model\UserStorage $userStorage, \Model\SessionStorage $session, \View\LoginView $loginView) {
        $this->userStorage = $userStorage;
        $this->session = $session;
        $this->loginView = $loginView;
        //$this->setLogin();
    }

    /**
	 * Sets session message and route login/outs
	 *
	 * Checks if form is submitted and if user is logged in, then generates a message
     * @return void, BUT writes to cookies and session!
	 */
    public function setLogin() {
        if ($this->loginView->isRememberedCookie()) {
            $this->useRemembered();
        }
        if ($this->loginView->doesUserWantsToLogOut()) { // try to log out 
            if ($this->session->isLoggedIn()) {
                $this->doLogout();
            } 
        }
        if ($this->loginView->doesUserWantsToLogIn()) { // try to log in
            if (!$this->session->isLoggedIn()) {
                $message = $this->loginView->handleFormInput();
                $this->session->setMessage($message);
            } 
        } 
    }

    /**
	 * Sets session message and user if credentials are in cookies
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function useRemembered() {
        if (!$this->session->issetMessage()) {
            $message = "Welcome back with cookie";
            $this->session->setMessage($message);
        }
        $this->loginView->setUserSession();
        // Future: authenticate with cookies
    }

    /**
	 * Logs out user and unsets session
     * Redirects to index.php
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function doLogout() {
        $this->session->destroyUserSession();
        $message = "Bye bye!";
        $this->session->setMessage($message);
        $this->loginView->unsetLoginCookie();
        $this->headerLocation("index.php");
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
    
}
