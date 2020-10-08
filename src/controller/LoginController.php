<?php

namespace Controller;

class LoginController {

    //private static $login = 'LoginView::Login';
	//private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
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
        if ($this->session->isRemembered(self::$cookieName)) {
            $this->useRemembered();
        }
        if ($this->loginView->doesUserWantsToLogOut()) { // try to log out 
            if ($this->session->isLoggedIn()) {
                $this->doLogout();
            } 
        }
        if ($this->loginView->doesUserWantsToLogIn()) { // try to log in
            if (!$this->session->isLoggedIn()) {
                //$this->handleFormInput();
                $message = $this->loginView->handleFormInput();
                $this->setMessage($message);
            } 
        } 
    }

    /**
	 *  Handles input from form 
	 *
     * @return void
	 */
    private function handleFormInput() {
        if (strlen($_POST[self::$name]) < 1) { // no username
            $message = "Username is missing";
        } else if (strlen($_POST[self::$password]) < 1) { // no password
            $message = "Password is missing";
        } else if ($this->userStorage->authenticateUser($_POST[self::$name], $_POST[self::$password])) { // Log in
            $this->doLogin();
        } else if ($this->userStorage->isUser($_POST[self::$name])) { // wrong password but user exsist
            $message = "Wrong name or password";
        } else  { // Wrong password or username
            $message = "Wrong name or password";
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
            $this->setMessage($message);
        }
        $this->session->setUserSession($_COOKIE[self::$cookieName]);
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
        $this->setMessage($message);
        $this->unsetLoginCookie();
        $this->headerLocation("index.php");
    }
    
     /**
	 * Logs in user and sets session
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function doLogin() {
        if (isset($_POST[self::$keep])) { // Keep me logged in
            $message = "Welcome and you will be remembered";     
            $this->setLoginCookie();
        } else {
            $message = "Welcome";                   
        }
        $this->session->setUserSession($_POST[self::$name]);
        $this->setMessage($message);
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
    
    private function setMessage(string $message) {
        $this->session->setMessage($message);		
    }

    private function setLoginCookie() { // Not finished yet
        $hashPass = $this->userStorage->hashPassword($_POST[self::$password]);
        $this->session->setLoginCookie(self::$cookieName, $_POST[self::$name], self::$cookiePassword, $hashPass);
    }

    private function unsetLoginCookie() {
        $this->session->unsetLoginCookie(self::$cookieName, self::$cookiePassword);
    }
}

?>