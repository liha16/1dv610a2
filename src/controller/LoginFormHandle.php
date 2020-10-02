<?php

namespace Controller;

class LoginFormHandle {

    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
    private $user;
    private $session;
    

    public function __construct(\Model\User $user, \Model\SessionStorage $session) {
        $this->user = $user;
        $this->session = $session;
        $this->setLogin();
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
        if (isset($_POST[self::$logout])) { // log out 
            if ($this->session->isLoggedIn()) {
                $this->doLogout();
            } 
        }
        if (isset($_POST[self::$login]) && !$this->session->isLoggedIn()) { // try to log in
            $this->handleFormInput();
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
        } else if ($this->user->authenticateUser($_POST[self::$name], $_POST[self::$password])) { // Log in
            $this->doLogin();
        } else if ($this->user->isUser($_POST[self::$name])) { // wrong password but user exsist
            $message = "Wrong name or password";
        } else  { // Wrong password or username
            $message = "Wrong name or password";
        } 
        $this->setMessageCookie($message);
    }


    /**
	 * Sets session message and user if credentials are in cookies
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function useRemembered() {
        if (!$this->session->issetMessageCookie()) {
            $message = "Welcome back with cookie";
            $this->setMessageCookie($message);
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
        $this->setMessageCookie($message);
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
        $this->setMessageCookie($message);
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
    
    private function setMessageCookie(string $message) {
        $this->session->setMessageCookie($message);		
    }

    private function setLoginCookie() {
        $this->session->setLoginCookie(self::$cookieName, $_POST[self::$name], self::$cookiePassword, $this->user->hashPassword($_POST[self::$password]));
      }

    private function unsetLoginCookie() {
        $this->session->unsetLoginCookie(self::$cookieName, self::$cookiePassword);
    }
}

?>