<?php

//namespace Model;

class SessionHandle {

    
	public function __construct() {
		
    }

    public function setLoginCookie($CookieNameUser, $CookieValueUser, $CookieNamePassword, $CookieValuePassword ) {
        $cookieDuration = 60 * 60 * 24 * 30; // 30 days  
        setcookie($CookieNameUser , $CookieValueUser, time() + $cookieDuration);  
        setcookie($CookieNamePassword , $CookieValuePassword, time() + $cookieDuration);
    }

    public function unsetLoginCookie($CookieNameUser, $CookieNamePassword) {
        unset($_COOKIE[$CookieNameUser]); 
        unset($_COOKIE[$CookieNamePassword]);
        setcookie($CookieNameUser, "", time()-3600); // add an expired cookie to make sure its unset
        setcookie($CookieNamePassword, "", time()-3600);
    }

    public function getMessageCookie() {
        $message = "";

        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
        }
        return $message;
    }

    public function unsetMessageCookie() {
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }
    }

    public function issetMessageCookie() {
        if (isset($_SESSION["message"])) {
            return true;
        } else {
            return false;
        }
    }

    public function setMessageCookie($message) {
        $_SESSION["message"] = $message;
    }

    public function setUserSession($name) {
        $_SESSION["user"] = $name;
    }

}


?>