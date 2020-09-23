<?php

//namespace Controller;

class RegisterFormHandle {

    private static $messageId = 'RegisterView::Message';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordR = 'RegisterView::PasswordRepeat';
    private static $register = 'RegisterView::Register';
    private $user;
    private $session;
    private static $userNameMin = 3;
    private static $passwordMin = 6;
    private static $userNameMax = 20;
    private static $passwordMax = 20;

	
    public function __construct(User $user, SessionHandle $session) {
        $this->user = $user;
        $this->session = $session;
    }

    /**
	 * Sets session messages for register form 
	 *
     * @return void, BUT writes to cookies and session!
	 */
    public function setMessage() { // TODO THIS FUNCTION IS DOING TOO MUCH! RENAME
        $message = "";
        if (isset($_POST[self::$register])) {
            if (strlen($_POST[self::$name]) < self::$userNameMin && strlen($_POST[self::$password]) < self::$passwordMin) { // TOO SHORT FIELDS
                $message = "Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.";
            } 
            else if (strlen($_POST[self::$name]) < self::$userNameMin) { // TOO SHORT NAME FIELD
                $message = "Username has too few characters, at least 3 characters.";
            } 
            else if (strlen($_POST[self::$password]) < self::$passwordMin) { // TOO SHORT NAME FIELD
                $message = "Password has too few characters, at least 6 characters.";
            } 
            else if ($_POST[self::$password] !== $_POST[self::$passwordR]) { // TOO SHORT NAME FIELD
                $message = "Passwords do not match.";
            } 
            $this->setMessageCookie($message);
        } 
    }

    private function setMessageCookie($message) {
        $this->session->setMessageCookie($message);		
    }

}

?>