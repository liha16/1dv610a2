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
    
    /**
	 * Checks if user is logged in
	 *
     * @return bool
	 */
    public function isLoggedIn() : bool {
        if (isset($_SESSION["user"])) {
            return true;
        } else {
            return false;
        }
    }

    public function logoutUser() {
        $this->userStorage->destroyUserSession();
    }

    /**
	 * Checks if there is a cookie saved with credentials
	 *
     * @return bool
	 */
    public function isRemembered($cookieName) {
        //TODO: COMPARE CREDENTIALS!
        if (isset($_COOKIE[$cookieName])) {
            return true;
        }
        else {
            return false;
        }
    }


}


?>