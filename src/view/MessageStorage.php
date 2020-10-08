<?php

namespace View;

    class MessageStorage {


        public function __construct(\Model\UserStorage $userStorage, \Model\SessionStorage $session) {
            $this->userStorage = $userStorage;
            //$this->session = $session;
		    $this->message = $session->getMessage();
        }


    }

    ?>