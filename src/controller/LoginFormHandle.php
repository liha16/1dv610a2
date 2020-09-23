<?php

//namespace Controller;

class LoginFormHandle {

    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private $user;
    private $session;
    

    public function __construct(User $user, SessionHandle $session) {
        $this->user = $user;
        $this->session = $session;
    }

    /**
	 * Sets session message and route login/outs
	 *
	 * Checks if form is submitted and if user is logged in, then generates a message
     * @return void, BUT writes to cookies and session!
	 */
    public function setMessage() { // TODO THIS FUNCTION IS DOING TOO MUCH! RENAME

        if ($this->isRemembered()) { // is cookie with credentials stored previosly?
            $this->useRemembered();
        }
        if (isset($_POST[self::$logout])) { // LOG OUT
            if ($this->user->isLoggedIn()) {
                $this->doLogout();
            } 
        }
        if (isset($_POST[self::$login]) && !$this->user->isLoggedIn()) { // LOGIN FORM SUBMITTED
            if (strlen($_POST[self::$name]) < 1) { // NO USERNAME
                $message = "Username is missing";
            } 
            else if (strlen($_POST[self::$password]) < 1) { // NO PASSWORD
                $message = "Password is missing";
            } 
            else if ($this->user->authenticateUser($_POST[self::$name], $_POST[self::$password])) { // LOG IN
                $this->doLogin();
            } 
            else if ($this->user->isUser($_POST[self::$name])) { // WRONG PASSWORD BUT USER EXSIST
                $message = "Wrong name or password";
            } 
            else  { // WRONG PASSWORD OR USERNAME
                $message = "Wrong name or password";
            } 
            $this->setMessageCookie($message);
        } 
        
    }


    /**
	 * Sets session message and user if credentials are in cookies
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function useRemembered() {
        if (!$this->session->issetMessageCookie()) { // Only sets new message if there is not message set already
            $message = "Welcome back with cookie";
            $this->setMessageCookie($message);
        }
        $this->session->setUserSession($_COOKIE[self::$cookieName]);
        // TODO : AUTHENTICATE
    }

    /**
	 * Logs out user and unsets session
     * Redirects to index.php
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function doLogout() {
        $this->user->logoutUser();
        $message = "Bye bye!";
        $this->setMessageCookie($message);
        $this->unsetLoginCookie();
        $this->headerLocation("index.php");
    }
    
     /**
	 * Logs in user and sets session
     * Redirects to index.php
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
        $this->setMessageCookie($message);
        $this->headerLocation("index.php");
    }
    
    private function headerLocation($file) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$file");
        exit();
    }
    
    private function isRemembered() {
        return $this->user->isRemembered(self::$cookieName);
    }

    private function hashPassword($password) : string {
        return $this->user->hashPassword($password);
    }

    private function verifyHashedPassword($hash, $password) : bool {
        return $this->user->verifyHashedPassword($hash, $password);
    }

    public function getMessageCookie() { // TODO : IS USED?
        return $this->session->getMessageCookie();
    }

    public function unsetMessageCookie() {
        $this->session->unsetMessageCookie();
    }

    private function setMessageCookie($message) {
        $this->session->setMessageCookie($message);		
    }

    private function setLoginCookie() {
        $this->session->setLoginCookie(self::$cookieName, $_POST[self::$name], self::$cookiePassword, $this->hashPassword($_POST[self::$password]));
      }

    private function unsetLoginCookie() {
        $this->session->unsetLoginCookie(self::$cookieName, self::$cookiePassword);
    }
}

?>