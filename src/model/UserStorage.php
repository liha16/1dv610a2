<?php

//namespace Model;

// SAVES USERS IN JSON FILE, GETS USER AND SETS TO SESSION

class UserStorage {

  private static $storageFile = "model/users.json";
  private $users = array();

  // Get the contents of the JSON file 
  public function readStorageFile() {
    $jsonContents = file_get_contents(self::$storageFile);
    $this->users = json_decode($jsonContents, true);

    //var_dump($this->users); 
    $this->isUser("Admin");
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

  public function authenticateUser()
  {
    # code... IN ANOTHER CLASS?
  }


}


?>