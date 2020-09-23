<?php

//namespace Model;

// SAVES USERS IN JSON FILE, GETS USER AND SETS TO SESSION

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
  public function isUser($username) : bool {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($username == $value["username"]) {
        $result = true;
      }
    }
    return $result;
  }

  public function addUser()
  {
    # code...
  }

  public function deleteUser()
  {
    # code...
  }

  /**
	 * Checks if the user is exsist and if the password is correct
	 *
   * @return bool
	 */
  public function authenticateUser($userName,$password) : bool // MOVE TO AUTHENITACE.php??
  {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($userName == $value["username"] && $password == $value["password"]) {
        $this->saveUserSession($userName); // MOVE THIS PART TO SESSIONHANDLE:PHP AND USE IN FORMHANLDE
        $result = true;
      }
    }
    return $result;
  }

  private function saveUserSession($userName)  // MOVE THIS PART TO SESSIONHANDLE:PHP 
  {
    $_SESSION["user"] = $userName;
  }

  public function destroyUserSession()  // MOVE THIS PART TO SESSIONHANDLE:PHP 
  {
    unset($_SESSION["user"]);
    $_SESSION["user"] = null;

  }


}


?>