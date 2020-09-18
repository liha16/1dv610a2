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
    

    public function __construct(User $user) {
        $this->user = $user;
		
    }
    public function setMessage() { // THIS FUNCTION IS DOING TOO MUCH! SEPARATE COOKIES AND MESSAGE
   
        if (isset($_POST[self::$logout])) { // LOG OUT
            $this->user->logoutUser();
            $message = "Bye bye!";
            $this->setMessageCookie($message);
            header("Location: index.php");
            exit();
        } 

        
        if (isset($_POST[self::$login])) { // IS FORM SUBMITTED

            if (strlen($_POST[self::$name]) < 1) { // NO USERNAME
                $message = "Username is missing";
            } 
            else if (strlen($_POST[self::$password]) < 1) { // NO PASSWORD
                $message = "Password is missing";
            } 
            else if ($this->user->authenticateUser($_POST[self::$name], $_POST[self::$password])) { // LOG IN
                $message = "Welcome";
                $this->setMessageCookie($message);
                header("Location: index.php");
                exit();
            } 
            else if ($this->user->isUser($_POST[self::$name])) { // WRONG PASSWORD BUT USER EXSIST
                $message = "Wrong name or password";
            } 
            else  { // WRONG PASSWORD OR USERNAME
                $message = "Wrong name or password";
                
            } 
            $this->setMessageCookie($message);
        } 

        //return $message;

    }

    public function getMessageCookie() {
        $message = "";

        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
        }
        return $message;
    }

    public function unsetMessageCookie() {

        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }
    }

    private function setMessageCookie($message) {
        $_SESSION["message"] = $message;
		
    }

}

?>