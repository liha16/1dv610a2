<?php

namespace Model;

class UserStorage {

  private static $storageFile = "model/users.json";
  private $users = array();

  /**
	 * Constructor opens data storage
	 *
   * @return bool
	 */
  public function __construct() {
    $jsonContents = file_get_contents(self::$storageFile);
    $this->users = json_decode($jsonContents, true);
  }

  /**
	 * Checks if user is registered
	 *
   * @return bool
	 */
  public function isUser(string $username) : bool {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($username == $value["username"]) {
        $result = true;
      }
    }
    return $result;
  }

   /**
	 * Converts to HTML entieties and erases blank spaces
	 *
   * @return bool
	 */
  public function filterInput(string $input) : string {
    return trim(htmlentities($input));	
}

  public function addUser()
  {
    # Future functions...
  }

  public function deleteUser()
  {
    # Future functions...
  }

  /**
	 * Checks if the user is exsist and if the password is correct
	 *
   * @return bool
	 */
  public function authenticateUser(string $userName, string $password) : bool // MOVE TO AUTHENITACE.php??
  {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($userName == $value["username"] && $this->verifyHashedPassword($value["password"], $password)) {
        $result = true;
      }
    }
    return $result;
  }

  /**
	 * Checks if the password and hash matches
	 *
   * @return bool
	 */
  public function verifyHashedPassword(string $hash, string $password) : bool {
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

   /**
	 * Hashes a password, returns a hashed version of it
	 *
   * @return string
	 */
  public function hashPassword($password) : string {
      return password_hash($password, PASSWORD_DEFAULT);
  }


}


?>