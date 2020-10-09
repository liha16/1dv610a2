<?php

namespace View;

    class MessageSession { 

        private static $sessionMessage = "message";

        /**
        * Get the (flash) message saved in session
        *
        * @return string, message
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
        * Set the (flash) message in session
        * @param $message, message to save
        * @return void, but changes session 
        */
        public function setMessage(string $message) {
            $_SESSION[self::$sessionMessage] = $message;
        }




    }