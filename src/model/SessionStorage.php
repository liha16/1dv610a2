<?php

namespace Model;

class SessionStorage {

    // TODO: make only login session here

    private static $cookieDuration = 60 * 60 * 24 * 30; // 30 days  
    private static $sessionMessage = "message";
    private static $sessionUser = "user";

    /**
    * Sets username and password cookie
    *
    * @param $CookieNameUser, name of cookie
    * @param $CookieValueUser, value of $CookieNameUser
    * @param $CookieNamePassword, name of cookie
    * @param $CookieValuePassword, value of $CookieValuePassword
	* @return void, but sets cookies
	*/
    public function setLoginCookie(string $CookieNameUser, 
                                    string $CookieValueUser, 
                                    string $CookieNamePassword, 
                                    string $CookieValuePassword ) {
        setcookie($CookieNameUser , $CookieValueUser, time() + self::$cookieDuration);  
        setcookie($CookieNamePassword , $CookieValuePassword, time() + self::$cookieDuration);
    }
    // TODO: TOO MANY ARGUMENTS

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
    public function getMessage() : string {
        $message = "";
        if (isset($_SESSION[self::$sessionMessage])) {
            $message = $_SESSION[self::$sessionMessage];
        }
        return $message;
    }

    /**
    * Unset the (flash) message saved in session
    *
	* @return void, but changes session 
	*/
    public function unsetMessage() {
        if (isset($_SESSION[self::$sessionMessage])) {
            unset($_SESSION[self::$sessionMessage]);
        }
    }

    /**
    * Checks if (flash) message is set
    *
	* @return bool
	*/
    public function issetMessage() : bool {
        if (isset($_SESSION[self::$sessionMessage])) {
            return true;
        } else {
            return false;
        }
    }

    /**
	 * Checks if there is a cookie saved with credentials
	 *
     * @return bool 
	 */
    public function isRemembered(string $cookieName) : bool {
        //Future: COMPARE CREDENTIALS!
        if (isset($_COOKIE[$cookieName])) {
            return true;
        }
        else {
            return false;
        }
    }
     
    /**
	 * Checks if user is logged in
	 *
     * @return bool
	 */
    public function isLoggedIn() : bool {
        if (isset($_SESSION[self::$sessionUser])) {
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
    public function setMessage(string $message) {
        $_SESSION[self::$sessionMessage] = $message;
    }

    /**
    * Set the loged in user session
    * @param $nem, name to save as user
	* @return void, but changes session 
	*/
    public function setUserSession(string $name) {
        $_SESSION[self::$sessionUser] = $name;
    }

    /**
    * Unsets user session (log out)
	* @return void, but changes session 
	*/
    public function destroyUserSession()
    {
        unset($_SESSION[self::$sessionUser]);
        $_SESSION[self::$sessionUser] = null;
  
    }

}

?>