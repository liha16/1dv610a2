<?php

namespace Model;

class UserSession {

    private static $cookieDuration = 60 * 60 * 24 * 30; // 30 days  
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
    public function destroyUserSession() {
        unset($_SESSION[self::$sessionUser]);
        $_SESSION[self::$sessionUser] = null;
    }

}

?>