<?php

namespace Controller;

class LoginController {

    private $session;
    private $loginView;
    

    public function __construct(\Model\SessionStorage $session, \View\LoginView $loginView) {
        $this->session = $session;
        $this->loginView = $loginView;
        //$this->setLogin();
    }

    /**
	 * Route login/outs
	 *
     * @return void
	 */
    public function setLogin() {
        if ($this->loginView->isRememberedCookie()) {
            $this->useRemembered();
        }
        if ($this->loginView->doesUserWantsToLogOut()) { // try to log out 
            if ($this->session->isLoggedIn()) {
                $this->loginView->doLogout();
            } 
        }
        if ($this->loginView->doesUserWantsToLogIn()) { // try to log in
            if (!$this->session->isLoggedIn()) {
                $message = $this->loginView->tryLogin();
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

    
}
