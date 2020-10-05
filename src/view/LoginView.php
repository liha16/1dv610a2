<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $userStorage;
	private $message;
	private $nameWasTooShort = false;

	public function __construct(\Model\UserStorage $userStorage, string $message) {
		$this->userStorage = $userStorage;
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
			$response = $this->generateLogoutButtonHTML($this->message);
		}
		else {
			$response = $this->generateLoginFormHTML($this->message);
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return string, html form
	*/
	private function generateLogoutButtonHTML(string $message) : string{
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the login form
	* @param $message, String output message
	* @return string, html form
	*/
	private function generateLoginFormHTML(string $message) : string {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
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
			$usernameField = $this->userStorage->filterInput($_POST[self::$name]);
		}
		return $usernameField;
	}
	
}