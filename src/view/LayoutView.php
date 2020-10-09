<?php

namespace View;

class LayoutView {
  
  public function render(bool $isLoggedIn, $v, \View\DateTimeView $dtv, \View\RouterView $router) {
    echo '<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
          <link rel="stylesheet" href="public/style.css">
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $router->getRegisterLink() . '
          ' . $router->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $v->response($isLoggedIn) . '
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

}
