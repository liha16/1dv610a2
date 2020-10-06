<?php

namespace View;

    class RegisterView {
        private static $messageId = 'RegisterView::Message';
        private static $name = 'RegisterView::UserName';
        private static $password = 'RegisterView::Password';
        private static $passwordR = 'RegisterView::PasswordRepeat';
        private static $register = 'RegisterView::Register';
        private $message;
        private $userStorage;


        public function __construct(\Model\UserStorage $userStorage, string $message) {
            $this->userStorage = $userStorage;
            $this->message = $message;
        }
        /**
         * Create Form to register
         *
         * @return  string HTML Form or button
         */
        public function response(bool $isLoggedIn) {
            return $this->generateRegisterFormHTML($this->message);
        }


        /**
        * Generate HTML code on the output buffer for the register form
        * @param $message, String output message
        * @return void, BUT writes to standard output!
        */
        private function generateRegisterFormHTML(string $message) {
            return '
            <h2>Register new user</h2>
            <form method="post" action="?register" enctype="multipart/form-data"> 
                    <fieldset>
                        <legend>Register a new user - Write username and password</legend>
                        <p id="' . self::$messageId . '">' . $message . '</p>
                        
                        <label for="' . self::$name . '">Username :</label>
                        <input type="text" size="20" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
                        <br/>
                        <label for="' . self::$password . '">Password :</label>
                        <input type="password" size="20" id="' . self::$password . '" name="' . self::$password . '" />
                        <br/>
                        <label for="' . self::$passwordR . '">Repeat password  :</label>
                        <input type="password" size="20" id="' . self::$passwordR . '" name="' . self::$passwordR . '" />
                        <br/>
                        <input type="submit" name="' . self::$register . '" value="Register" />
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
               $usernameField = strip_tags($_POST[self::$name]);
               $usernameField = $this->userStorage->filterInput($usernameField);
            }
            return $usernameField;
        }

        

    }

    ?>