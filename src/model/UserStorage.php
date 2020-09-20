<?php

//namespace Model;

// SAVES USERS IN JSON FILE, GETS USER AND SETS TO SESSION

class UserStorage {

  private static $storageFile = "model/users.json";
  private $users = array();

  // Get the contents of the JSON file 
  public function __construct() {
    $jsonContents = file_get_contents(self::$storageFile);
    $this->users = json_decode($jsonContents, true);
  }

  // checks if user is registered, returns bool
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

  public function authenticateUser($userName,$password) : bool // MOVE TO AUTHENITACE.php??
  {
    $result = false;
    foreach ($this->users as $user => $value) {      
      if ($userName == $value["username"] && $password == $value["password"]) {
        $this->saveUserSession($userName);
        $result = true;
      }
    }
    return $result;
  }

  private function saveUserSession($userName)
  {
    $_SESSION["user"] = $userName;
  }

  public function destroyUserSession()
  {
    unset($_SESSION["user"]);
  }


}


?>