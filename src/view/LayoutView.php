<?php

namespace View;

class LayoutView {
  
  public function render(bool $isLoggedIn, $v, \View\DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <htmllang="en">
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
          <link rel="stylesheet" href="public/style.css">
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $this->renderRegisterLink() . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $v->response($isLoggedIn) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn(bool $isLoggedIn) {
    if ($isLoggedIn) {
      return '
      <a href="?upload">Upload image</a>
      <a href="?viewimages">View images</a>
      <h2>Logged in</h2>
      ';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegisterLink() : string {
    if (isset($_GET['register'])) {
      return '<a href="?">Back to login</a>';
    }
    else {
      return '<a href="?register">Register a new user</a>';
    }
  }
}
