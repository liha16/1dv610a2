<?php

namespace Controller;

class RegisterFormHandle {

    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordR = 'RegisterView::PasswordRepeat';
    private static $register = 'RegisterView::Register';
    private $userStorage;
    private $session;
    private static $userNameMin = 3;
    private static $passwordMin = 6;
    private static $userNameMax = 20; // For future implementation
    private static $passwordMax = 20; // For future implementation

	
    public function __construct(\Model\UserStorage $userStorage, \Model\SessionStorage $session) {
        $this->userStorage = $userStorage;
        $this->session = $session;
        $this->setRegister();
    }

    /**
	 * Sets session messages for register form 
	 *
     * @return void, BUT writes to cookies and session!
	 */
    public function setRegister() { // TODO THIS FUNCTION IS DOING TOO MUCH!
        $message = "";
        if (isset($_POST[self::$register])) {
            if ($this->inputHasInvalidLength()) { // TOO SHORT FIELDS
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
            else if ($this->userStorage->isUser($_POST[self::$name])) { // User exsist
                $message = "User exists, pick another username.";
            } else { // Register
              //s  $newUser ;
            }
            $this->setMessageCookie($message);
        } 
    }

    /**
	 * Compares lenght of inputs
	 *
     * @return bool, true if short
	 */
    private function inputHasInvalidLength() {
        return strlen($_POST[self::$name]) < self::$userNameMin && strlen($_POST[self::$password]) < self::$passwordMin;	
    }

    
    private function setMessageCookie(string $message) {
        $this->session->setMessageCookie($message);		
    }

}

?>