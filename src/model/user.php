<?php

namespace Model;

class User {

    private $userStorage;
    

	public function __construct(UserStorage $userStorage) {
		$this->userStorage = $userStorage;
    }

    public function isUser(string $userName) : bool {
        return $this->userStorage->isUser($userName);
    }

    public function authenticateUser(string $userName, string $password) : bool {
        return $this->userStorage->authenticateUser($userName, $password);
    }

    /**
	 * Converts to HTML entieties and erases blank spaces
	 *
     * @return bool
	 */
    public function filterInput(string $input) : string {
        return trim(htmlentities($input));	
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


    /**
	 * Checks if there is a cookie saved with credentials
	 *
     * @return bool
	 */
    public function isRemembered(string $cookieName) : bool {
        //Future: COMPARE CREDENTIALS!
        if (isset($_COOKIE[$cookieName])) {
            return true;
        }
        else {
            return false;
        }
    }

    public function hashPassword(string $password) : string {
        return $this->userStorage->hashPassword($password);
    }

    public function verifyHashedPassword(string $hash, string $password) : bool {
        return $this->userStorage->verifyHashedPassword($hash, $password);
    }


}


?>