<?php

namespace View;

    class RegisterView {
        private static $messageId = 'RegisterView::Message';
        private static $name = 'RegisterView::UserName';
        private static $password = 'RegisterView::Password';
        private static $passwordR = 'RegisterView::PasswordRepeat';
        private static $register = 'RegisterView::Register';
        private static $userNameMin = 3;
        private static $passwordMin = 6;
        private $message;

        /**
         * Create Form to register
         *
         * @return  string HTML Form or button
         */
        public function response(bool $isLoggedIn) : string {
            return $this->generateRegisterFormHTML($this->message);
        }

        /**
         * Updates session message to view     
         * */
        public function updateMessage(string $message) {
            $this->message = $message;
        }


        /**
        * Generate HTML code on the output buffer for the register form
        * @param $message, String output message
        * @return void, BUT writes to standard output!
        */
        private function generateRegisterFormHTML(string $message) : string {
            return '
            <h2>Register new user</h2>
            <form method="post" action="?register" enctype="multipart/form-data"> 
                    <fieldset>
                        <legend>Register a new user - Write username and password</legend>
                        <p id="' . self::$messageId . '">' . $message . '</p>
                        
                        <label for="' . self::$name . '">Username :</label>
                        <input type="text" minlength="' . self::$userNameMin . '" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
                        <br/>
                        <label for="' . self::$password . '">Password :</label>
                        <input type="password" minlength="' . self::$passwordMin . '" id="' . self::$password . '" name="' . self::$password . '" />
                        <br/>
                        <label for="' . self::$passwordR . '">Repeat password  :</label>
                        <input type="password" minlength="' . self::$passwordMin . '" id="' . self::$passwordR . '" name="' . self::$passwordR . '" />
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
               $usernameField = $this->filterInput($usernameField);
            }
            return $usernameField;
        }

        /**
        * Check all input fields in form
        *
        * @return void, but might throw exception
        */
        public function validateRegisterForm() {
            if ($this->inputHasInvalidLength()) { // TOO SHORT FIELDS
                throw new \Exception('Username has too few characters, at least 3 characters. 
                Password has too few characters, at least 6 characters.');
            } 
            else if (strlen($_POST[self::$name]) < self::$userNameMin) { // TOO SHORT NAME FIELD
                throw new \Exception('Username has too few characters, at least 3 characters.');
            } 
            else if (strlen($_POST[self::$password]) < self::$passwordMin) { // TOO SHORT NAME FIELD
                throw new \Exception('Password has too few characters, at least 6 characters.');
            }
            else if ($_POST[self::$password] !== $_POST[self::$passwordR]) { // TOO SHORT NAME FIELD
                throw new \Exception('Passwords do not match.');
            } 
            else if ($this->hasNotValidChars($_POST[self::$name])) { // Invalid characters
                throw new \Exception('Username contains invalid characters.');
            } 
        }

        public function isRegisterFormPosted() : bool {
            return isset($_POST[self::$register]);
        }

        public function getName() : string {
            return $_POST[self::$name];
        }
        public function getPassword() : string {
            return $_POST[self::$password];
        }

        /**
         * Compares lenght of inputs
         *
         * @return bool, true if short
         */
        private function inputHasInvalidLength() : bool {
            return strlen($_POST[self::$name]) < self::$userNameMin && strlen($_POST[self::$password]) < self::$passwordMin;	
        }

        /**
         * Checks if string has invalid characters
         * 
         * * @return bool, true if not valid
         */
        private function hasNotValidChars($string) : bool{
            return preg_match('/[^A-Za-z0-9.#\\-$]/', $string);
        }

        /**
        * Converts to HTML entieties and erases blank spaces
         */
        public function filterInput(string $input) : string {
            return trim(preg_replace('/[^a-zA-Z0-9\s]/', '',$input));	
        }

        

    }

    ?>