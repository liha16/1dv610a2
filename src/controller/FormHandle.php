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
	public function getMessage() { // THIS FUNCTION IS DOING TOO MUCH!

        $message = "";

        if (isset($_POST[self::$logout])) { // LOG OUT
            $this->user->logoutUser();
            $message = "Bye bye!";
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
            } 
            else if ($this->user->isUser($_POST[self::$name])) { // WRONG PASSWORD BUT USER EXSIST
                $message = "Wrong name or password";
            } 
            else  { // WRONG PASSWORD OR USERNAME
                $message = "Wrong name or password";
            } 
        }

        return $message;

    }

}

?>