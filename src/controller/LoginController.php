<?php

namespace Controller;

class LoginController {

    private $userSession;
    private $loginView;
    private $msgSession;
    

    public function __construct(\Model\UserSession $userSession, \View\LoginView $loginView, \View\MessageSession $msgSession) {
        $this->userSession = $userSession;
        $this->loginView = $loginView;
        $this->msgSession = $msgSession;
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
            if ($this->userSession->isLoggedIn()) {
                $this->loginView->doLogout();
            } 
        }
        if ($this->loginView->doesUserWantsToLogIn()) { // try to log in
            if (!$this->userSession->isLoggedIn()) {
                try {
                    $this->loginView->validateLogin();
                } catch (\Exception $e) {
                    $this->loginView->setMessage($e->getMessage());
                }
            } 
        } 
    }

    /**
	 * Sets session message and user if credentials are in cookies
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function useRemembered() {
        if (!$this->msgSession->issetMessage()) {
            $message = "Welcome back with cookie";
            $this->msgSession->setMessage($message);
        }
        $this->loginView->setUserSession();
        // Future: authenticate with cookies
    }

    
}
