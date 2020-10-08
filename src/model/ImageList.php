<?php

namespace Model;

class ImageList { // TODO seperate image and imageList?

  private $maxSize = 500000;
  private $allowedFileTypes = ["jpg", "png", "jpeg", "gif"];
  private $target_dir = "uploads/";
  private $images = array();

  public function __construct() {
      $this->images = array_slice(scandir($this->target_dir), 3); // 3 is to delete . and .. files
  }

   /**
	 * Tries to upload an image and returns status message
   * Code inspired by https://www.w3schools.com/php/php_file_upload.asp
   * 
   * @return string, message
	 */
  public function uploadImage($fileToUpload) : string {
      if (empty($fileToUpload["tmp_name"])) { // No image selected
          $message = "You must select an image to upload.";
      } else {
          $targetFileName = basename($fileToUpload["name"]);
          $targetFile = $this->target_dir . $targetFileName;
          $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

          if (!getimagesize($fileToUpload["tmp_name"])) { // Is it an image
              $message =  "File is not an image.";
          } else if (file_exists($targetFile)) { // Check if file already exists
              $message = "A file with that name already exists"; 
          } else if ($fileToUpload["size"] > $this->maxSize) { // Check file size
              $message = "The image is too large, max allowed " . $this->maxSize;
          } else if (!in_array($imageFileType, $this->allowedFileTypes)) { // Allow certain file formats
              $message = "Filetype " . $imageFileType . " is not allowed.";
          } else { 
              if (move_uploaded_file($fileToUpload["tmp_name"], $targetFile)) { // Try to upload
                  $message = "The file ". $this->getImageLink(htmlspecialchars($targetFileName)) . " has been uploaded.";
              } else {
                  $message = "Sorry, there was an error uploading your file.";
              }
          } 
      } 
      return $message;
  }

  /**
	 * Get absolute url of file
	 *
   * @return string, url
	 */
  private function getImageLink(string $file) : string {
      $host = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      return "<a href='http://$host$uri/$this->target_dir/$file'>$file</a>";
  }


  /**
	 * Returns all images 
	 *
   * @return array, images list
	 */
  public function getImages() : array {
      return $this->images;
    }

}




?>