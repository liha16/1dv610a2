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

    /**
	 * Checks if there is a cookie saved with credentials
	 *
     * @return bool
	 */
    public function isRemembered($cookieName) {
        //TODO: COMPARE CREDENTIALS!!!
        if (isset($_COOKIE[$cookieName])) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
	 * Checks if the password and hash matches
	 *
     * @return bool
	 */
    public function verifyHashedPassword($hash, $password) : bool {
        if (password_verify($password, $hash)) {
            echo 'Password is valid!';
            return true;
        } else {
            return false;
        }
    }

    public function hashPassword($password) : string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}


?>