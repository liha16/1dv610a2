<?php

namespace View;


    class RouterView {

        private static $register = 'register';
        private static $uploadImage = 'upload';
        private static $viewImages = 'viewimages';

        public function doesUserWantsToRegister() : bool {
            return isset($_GET[self::$register]);
        }

        public function doesUserWantsUploadImage() : bool {
            return isset($_GET[self::$uploadImage]);
        }

        public function doesUserWantsToViewImages() : bool {
            return isset($_GET[self::$viewImages]);
        }

        public function getRegisterLink() : string {
            if (isset($_GET[self::$register])) {
              return '<a href="?">Back to login</a>';
            }
            else {
              return '<a href="?register">Register a new user</a>';
            }
        }

        public function renderIsLoggedIn(bool $isLoggedIn) : string {
          if ($isLoggedIn) {
            return '
            <a href="?">Home</a>
            <a href="?upload">Upload image</a>
            <a href="?viewimages">View images</a>
            <h2>Logged in</h2>
            ';
          }
          else {
            return '<h2>Not logged in</h2>';
          }
        }


    }

