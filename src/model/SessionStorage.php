<?php

namespace Model;

class SessionStorage {


    public function setLoginCookie(string $CookieNameUser, string $CookieValueUser, string $CookieNamePassword, string $CookieValuePassword ) {
        $cookieDuration = 60 * 60 * 24 * 30; // 30 days  
        setcookie($CookieNameUser , $CookieValueUser, time() + $cookieDuration);  
        setcookie($CookieNamePassword , $CookieValuePassword, time() + $cookieDuration);
    }

    public function unsetLoginCookie(string $CookieNameUser, string $CookieNamePassword) {
        unset($_COOKIE[$CookieNameUser]); 
        unset($_COOKIE[$CookieNamePassword]);
        setcookie($CookieNameUser, "", time()-3600); // add an expired cookie to make sure its unset
        setcookie($CookieNamePassword, "", time()-3600);
    }

    public function getMessageCookie() : string{
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

    public function issetMessageCookie() : bool {
        if (isset($_SESSION["message"])) {
            return true;
        } else {
            return false;
        }
    }

    public function setMessageCookie(string $message) {
        $_SESSION["message"] = $message;
    }

    public function setUserSession(string $name) {
        $_SESSION["user"] = $name;
    }

    public function destroyUserSession()
    {
      unset($_SESSION["user"]);
      $_SESSION["user"] = null;
  
    }

}


?>