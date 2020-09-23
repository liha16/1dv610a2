<?php

namespace Model;

class SessionStorage {

    /**
    * Sets username and password cookie
    *
    * @param $CookieNameUser, name of cookie
    * @param $CookieValueUser, value of $CookieNameUser
    * @param $CookieNamePassword, name of cookie
    * @param $CookieValuePassword, value of $CookieValuePassword
	* @return void, but sets cookies
	*/
    public function setLoginCookie(string $CookieNameUser, string $CookieValueUser, string $CookieNamePassword, string $CookieValuePassword ) {
        $cookieDuration = 60 * 60 * 24 * 30; // 30 days  
        setcookie($CookieNameUser , $CookieValueUser, time() + $cookieDuration);  
        setcookie($CookieNamePassword , $CookieValuePassword, time() + $cookieDuration);
    }

    /**
    * Unsets user cookies for log in
    *
    * @param $CookieNameUser, name of cookie to unset
    * @param $CookieNamePassword, name of cookie to unset
	* @return void, but changes cookies
	*/
    public function unsetLoginCookie(string $CookieNameUser, string $CookieNamePassword) {
        unset($_COOKIE[$CookieNameUser]); 
        unset($_COOKIE[$CookieNamePassword]);
        setcookie($CookieNameUser, "", time()-3600); // add an expired cookie to make sure its unset
        setcookie($CookieNamePassword, "", time()-3600);
    }

    /**
    * Get the (flash) message saved i session
    *
	* @return string, message saved in session
	*/
    public function getMessageCookie() : string{
        $message = "";
        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
        }
        return $message;
    }

    /**
    * Unset the (flash) message saved in session
    *
	* @return void, but changes session 
	*/
    public function unsetMessageCookie() {
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }
    }

    /**
    * Checks if (flash) message is set
    *
	* @return bool
	*/
    public function issetMessageCookie() : bool {
        if (isset($_SESSION["message"])) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Set the (flash) message in session
    * @param $message, message to save
	* @return void, but changes session 
	*/
    public function setMessageCookie(string $message) {
        $_SESSION["message"] = $message;
    }

    /**
    * Set the loged in user session
    * @param $nem, name to save as user
	* @return void, but changes session 
	*/
    public function setUserSession(string $name) {
        $_SESSION["user"] = $name;
    }

    /**
    * Unsets user session (log out)
	* @return void, but changes session 
	*/
    public function destroyUserSession()
    {
      unset($_SESSION["user"]);
      $_SESSION["user"] = null;
  
    }

}


?>