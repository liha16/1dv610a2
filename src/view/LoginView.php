<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName'; // For future implementation
 	private static $cookiePassword = 'LoginView::CookiePassword'; // For future implementation
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $userList;
	private $userSession;
	private $msgSession;
	private $message;

	public function __construct(\Model\UserList $userList, \Model\UserSession $userSession, \View\MessageSession $msgSession) 
	  {
		$this->userList = $userList;
		$this->userSession = $userSession;
		$this->msgSession = $msgSession;
		$this->message = $msgSession->getMessage();
	  }


	  public function setMessage(string $message) {
		$this->message = $message;	  
	}

	/**
	 * Create Form or butto
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  string HTML Form or button
	 */
	public function response(bool $isLoggedIn) : string {

		if ($isLoggedIn) {
			$response = $this->generateLoggedInHTML();
		}
		else {
			$response = $this->generateLoginFormHTML();
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return string, html form
	*/
	private function generateLoggedInHTML() : string {
		return '
			<form method="post" action="?" >
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form><br>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the login form
	* @param $message, String output message
	* @return string, html form
	*/
	private function generateLoginFormHTML() : string {
		return '
			<form method="post" action="?" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	/**
    * Returns content in specific input field
    *
    * @return string, input in form
    */
	private function getRequestUserName() : string {
		$usernameField = "";
		if (isset($_POST[self::$name])) {
			$usernameField = $this->userList->filterInput($_POST[self::$name]);
		}
		return $usernameField;
	}

	public function doesUserWantsToLogOut() : bool {
		return isset($_POST[self::$logout]);
	}

	public function doesUserWantsToLogIn() : bool {
		return isset($_POST[self::$login]);
	}

	public function validateLogin() {
		if (strlen($_POST[self::$name]) < 1) { // no username
			throw new \Exception('Username is missing');
        } else if (strlen($_POST[self::$password]) < 1) { // no password
			throw new \Exception('Password is missing');
        } else if ($this->userList->authenticateUser($_POST[self::$name], $_POST[self::$password])) { // Log in
            $this->doLogin();
        } else if ($this->userList->isUser($_POST[self::$name])) { // wrong password but user exsist
			throw new \Exception('Wrong name or password');
        } else  { // Wrong password or username
			throw new \Exception('Wrong name or password');
		} 
	}

	public function doLogout() {
		$this->userSession->destroyUserSession();
        $message = "Bye bye!";
		$this->msgSession->setMessage($message); // MessageSession
        $this->userSession->unsetLoginCookie(self::$cookieName, self::$cookiePassword);
        $this->headerLocation("index.php");
		
	}

	/**
	 * Logs in user and sets session
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function doLogin() {
        if (isset($_POST[self::$keep])) { // Keep me logged in
            $message = "Welcome and you will be remembered";     
            $this->setLoginCookie();
        } else {
            $message = "Welcome";                   
        }
		$this->userSession->setUserSession($_POST[self::$name]);
        $this->msgSession->setMessage($message); // MessageSession
        $this->headerLocation("index.php");
	}
	
	private function setLoginCookie() { // Not finished yet
        $hashPass = $this->userList->hashPassword($_POST[self::$password]);
        $this->userSession->setLoginCookie(self::$cookieName, $_POST[self::$name], self::$cookiePassword, $hashPass);
	}
	
	public function isRememberedCookie() : bool {
		return $this->userSession->isRemembered(self::$cookieName);
	}
	
	public function setUserSession() {
		$this->userSession->setUserSession($_COOKIE[self::$cookieName]);
	}
	
	/**
	 * Redirects to a valid path on server
	 */
    private function headerLocation(string $file) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$file");
        exit();
    }


	
	
}