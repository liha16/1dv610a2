<?php

namespace Model;

class User {

    private $username;
    private $password;

    // public function __construct(string $name, string $password) {
    //     $this->name = $name;
    //     $this->password = $password;
    // }

    public function setName($username) {
        $this->username = $this->filterInput($username);
    }

    public function setPassword($password) {
        $this->password = $this->filterInput($password);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    // private $userStorage;

	// public function __construct(UserStorage $userStorage) {
	// 	$this->userStorage = $userStorage;
    // }

    // public function isUser(string $userName) : bool {
    //     return $this->userStorage->isUser($userName);
    // }

    // public function authenticateUser(string $userName, string $password) : bool {
    //     return $this->userStorage->authenticateUser($userName, $password);
    // }

    /**
	* Converts to HTML entieties and erases blank spaces
	*
    * @return bool
	*/
    public function filterInput(string $input) : string {
        return trim(preg_replace('/[^a-zA-Z0-9\s]/', '',$input));
    }

    /**
	 * Checks if user is logged in // TODO ELIMINATE
	 *
     * @return bool
	 */
   // public function isLoggedIn() : bool {
      //  if (isset($_SESSION[self::$sessionUser])) {
     //       return true;
      //  } else {
        //    return false;
      //  }
    //}


    /**
	 * Checks if there is a cookie saved with credentials TODO: ELIMINATE
	 *
     * @return bool
	 */
    //public function isRemembered(string $cookieName) : bool {
        //Future: COMPARE CREDENTIALS!
      //  if (isset($_COOKIE[$cookieName])) {
     //       return true;
        //}
       // else {
         //   return false;
       // }
   // }

    // public function hashPassword(string $password) : string {
    //     return $this->userStorage->hashPassword($password);
    // }

    // public function verifyHashedPassword(string $hash, string $password) : bool {
    //     return $this->userStorage->verifyHashedPassword($hash, $password);
    // }


}


?>