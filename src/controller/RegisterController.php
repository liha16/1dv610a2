<?php

namespace Controller;

require_once('model/User.php');


class RegisterController {

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
    private function setRegister() { // TODO THIS FUNCTION IS DOING TOO MUCH!
        $message = "";
        if (isset($_POST[self::$register])) {
            if ($this->inputHasInvalidLength()) { // TOO SHORT FIELDS
                $message = "Username has too few characters, at least 3 characters. 
                Password has too few characters, at least 6 characters.";
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
            }
            else if ($this->hasNotValidChars($_POST[self::$name])) { // Invalid characters
                $message = "Username contains invalid characters.";
            } else { // Register
                $this->registerUser(); 
            }
            $this->setMessage($message);
        } 
    }

    /**
	 * Checks if string has invalid characters
     * 
     * * @return bool, true if not valid
	 */
    private function hasNotValidChars($string) {
        return preg_match('/[^A-Za-z0-9.#\\-$]/', $string);
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

    /**
	 * Creates new user object and saves to Storage
	 *
     * @return void, but saved so storage
	 */
    private function registerUser() {
        $newUser = new \Model\User;
        $newUser->setName($_POST[self::$name]);
        $newUser->setPassword($_POST[self::$password]);
        $this->userStorage->saveNewUser($newUser); // TODO exceptionn!!s
        $message = "Registered new user.";
        $this->session->destroyUserSession(); // logs out if user wants to register
        $this->setMessage($message);
        $this->headerLocation("index.php");
    }

    /**
	 * Compares lenght of inputs
	 *
     * @return bool, true if short
	 */
    private function inputHasInvalidLength() {
        return strlen($_POST[self::$name]) < self::$userNameMin && strlen($_POST[self::$password]) < self::$passwordMin;	
    }

    
    private function setMessage(string $message) {
        $this->session->setMessage($message);		
    }

}

?>