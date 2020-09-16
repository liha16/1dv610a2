<?php


//namespace Model;

class User {

	private $view;
    private $userStorage;
    private $isLoggedIn = false;

	public function __construct(UserStorage $userStorage) {
		$this->userStorage = $userStorage;
       // $this->getPostStatus();
    }

    public function getPostStatus() {
        if (isset($_POST[self::$login])) {
            if (strlen($_POST[self::$password]) < 1) { // NO PASSWORD
                $message = "Password is missing";
            } 
            if (strlen($_POST[self::$name]) < 1) { // NO USERNAME
                $message = "Username is missing";
            } 
            if (isUser(strlen($_POST[self::$name]))) { // NO USERNAME
                $message = "Is in database";
                echo "In user Is in database ";
            } 
        }
        return $message;
    }

    

    public function isUser($userName) : bool {
        return $this->userStorage->isUser($userName);
    }

}


?>