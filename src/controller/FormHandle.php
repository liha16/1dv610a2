<?php

//namespace Controller;

class FormHandle {

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
    public function setMessage() { // TODO THIS FUNCTION IS DOING TOO MUCH! SEPARATE COOKIES AND MESSAGE
        if ($this->isRemembered()) {
            $this->useRemembered();
            
        }
        if (isset($_POST[self::$logout])) { // LOG OUT
            $this->doLogout();
        } 
        if (isset($_POST[self::$login])) { // IS FORM SUBMITTED

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



    private function useRemembered() {
        $message = "Welcome back with cookie";
        $this->setMessageCookie($message);
        $_SESSION["user"] = $_COOKIE[self::$cookieName]; // TODO : don't set session here
        
    }

    private function doLogout() {
        $this->user->logoutUser();
        $message = "Bye bye!";
        $this->setMessageCookie($message);
        $this->unsetLoginCookie();
        header("Location: index.php");
        exit();
    }
    
    private function doLogin() {
        if (isset($_POST[self::$keep])) {
            $message = "Welcome and you will be remembered";     
            $this->setLoginCookie();
        } else {
            $message = "Welcome";                   
        }
        $this->setMessageCookie($message);
        header("Location: index.php");
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

    public function getMessageCookie() {
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