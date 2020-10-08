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


    }

