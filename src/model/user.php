<?php


//namespace Model;

class User {

    private $userStorage;

	public function __construct(UserStorage $userStorage) {
		$this->userStorage = $userStorage;
    }

    public function isUser($userName) : bool {
        return $this->userStorage->isUser($userName);
    }

    public function authenticateUser($userName, $password) : bool {
        return $this->userStorage->authenticateUser($userName, $password);
    }
    public function isLoggedIn() : bool { // CHECK SESSION
        if (isset($_SESSION["user"])) {
            return true;
        } else {
            return false;
        }
    }

    public function logoutUser() {
        $this->userStorage->destroyUserSession();
    }

    public function isRemembered($cookieName) { // is cookie set that rememberes user credentials? 
        //TODO: COMPARE CREDENTIALS!!!
        if (isset($_COOKIE[$cookieName])) {
            return true;
        }
        else {
            return false;
        }
    }

}


?>