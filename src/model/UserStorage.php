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
  public function isUser(string $username) {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($username == $value["username"]) { // TODO Strängberoende
        $result = true;
      }
    }
    return $result;
  }

  /**
	 *  
	 * Gets data from user and saves in storage
   * @return 
	 */
  public function saveNewUser(\Model\User $user) {
    $newMember = (object)array(); // new public user 
    $newMember->username = $user->getUsername(); // TODO : Make method that checks rules for name
    $newMember->password = $this->hashPassword($user->getPassword()); // TODO : Make method that checks rules for personal NR
    $this->saveMemberToFile($newMember);
  }

  /**
  * Saves user as last position in db file
  */
  public function saveMemberToFile($user) {
    $this->users[count($this->users)] = $user;
    $usersJSON = json_encode($this->users);
    file_put_contents(self::$storageFile, $usersJSON);
}


   /**
	 * Converts to HTML entieties and erases blank spaces
	 *
   * @return bool
	 */
  public function filterInput(string $input) {
    return trim(preg_replace('/[^a-zA-Z0-9\s]/', '',$input));	
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
  public function authenticateUser(string $userName, string $password) // MOVE TO AUTHENITACE.php??
  {
    $result = false;
    foreach ($this->users as $user => $value) {      // TODO strängberoenden
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
  public function verifyHashedPassword(string $hash, string $password) {
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
  public function hashPassword($password) {
      return password_hash($password, PASSWORD_DEFAULT);
  }


}


?>