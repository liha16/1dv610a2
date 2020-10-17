<?php

namespace Model;

class UserList {

  private static $storageFile = "model/users.json";
  private static $usernameVal = "username";
  private static $passwordVal = "password";
  private $users = array();

  /**
	 * Constructor opens data storage
	 */
  public function __construct() {
    if (file_exists(self::$storageFile)) {
      $jsonContents = file_get_contents(self::$storageFile);
      $this->users = json_decode($jsonContents, true);
    } else {
        throw new \Exception("No file " . self::$storageFile . " found on server");
        // Never catched but will cause and error
    }
  }

  /**
	 * Checks if user is registered
	 *
	 */
  public function isUser(string $username) : bool {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($username == $value[self::$usernameVal]) {
        $result = true;
      }
    }
    return $result;
  }

  /**
	 *  
	 * Gets data from user and saves in storage
   * @return void
	 */
  public function saveNewUser(\Model\User $user) {
    $newMember = (object)array();
    $newMember->username = $user->getUsername();
    $newMember->password = $this->hashPassword($user->getPassword());
    $this->saveMemberToFile($newMember);
  }

  /**
  * Saves user as last position in db file
  */
  private function saveMemberToFile($user) {
    $this->users[count($this->users)] = $user;
    $usersJSON = json_encode($this->users);
    if (file_put_contents(self::$storageFile, $usersJSON) == false) {
      throw new \Exception("Could not save user");
      
    }
}

   /**
	 * Converts to HTML entieties and erases blank spaces
	 */
  public function filterInput(string $input) : string {
    return trim(preg_replace('/[^a-zA-Z0-9\s]/', '',$input));	
  }


  /**
	 * Checks if the user is exsist and if the password is correct
	 *
   * @return bool
	 */
  public function authenticateUser(string $userName, string $password) : bool {
    $result = false;
    foreach ($this->users as $user => $value) {
      if ($userName == $value[self::$usernameVal] && $this->verifyHashedPassword($value[self::$passwordVal], $password)) {
        $result = true;
      }
    }
    return $result;
  }

  /**
	 * Checks if the password and hash matches
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
	 */
  public function hashPassword(string $password) : string {
      return password_hash($password, PASSWORD_DEFAULT);
  }
}
?>