<?php

namespace Model;

class ImageList {

  private $folder = "./uploads";
  private $images = array();

  public function __construct() {
      //$this->images = scandir($this->folder);
      $this->images = array_slice(scandir($this->folder), 3);
    
  }

  public function getImages() {
    //  var_dump($this->images);
      return $this->images;
    }

}




?>