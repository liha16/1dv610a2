<?php


//namespace Model;

class User {

	private $view;
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

}


?>