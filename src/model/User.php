<?php

namespace Model;

class User {

    private $username;
    private $password;
    private static $userNameMin = 3;
    private static $passwordMin = 6;


    public function setName(string $username) {
        if(strlen($username) < self::$userNameMin){
            throw new \Exception('$username must ' . self::$userNameMin . ' characters long!');
        }
        $this->username = $this->filterInput($username);
    }

    public function setPassword(string $password) {
        if(strlen($password) < self::$passwordMin){
            throw new \Exception('$password must ' . self::$passwordMin . ' characters long!');
        }
        $this->password = $this->filterInput($password);
    }

    public function getUsername() : string {
        return $this->username;
    }

    public function getPassword() : string {
        return $this->password;
    }

    /**
	* Converts to HTML entieties and erases blank spaces
	*/
    private function filterInput(string $input) : string {
        return trim(preg_replace('/[^a-zA-Z0-9\s]/', '',$input));
    }

}


?>