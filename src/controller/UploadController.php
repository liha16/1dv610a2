<?php

namespace Controller;

require_once('model/User.php');


class UploadController {

    private static $upload = 'UploadView::Upload';
    private $file = 'UploadView::FileToUpload';
    private $target_dir = "uploads/";
    private $userStorage;
    private $session;
    private $maxSize = 500000;
	
    public function __construct(\Model\UserStorage $userStorage, \Model\SessionStorage $session) {
        $this->userStorage = $userStorage;// TODO NEEDED?
        $this->session = $session; // TODO NEEDED?
        $this->handleUpload();
    }

    /**
	 * Sets session messages for register form 
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function handleUpload() { // TODO THIS FUNCTION IS DOING TOO MUCH! IN MODEL?

        // Code inspired from https://www.w3schools.com/php/php_file_upload.asp

        if (isset($_POST[self::$upload])) {

            if ( ! empty($_FILES)) {
                $message = "You must select an image to upload.";
            } else {
                # code...
            }    

            $target_file = $this->target_dir . basename($_FILES[$this->file]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $message = "";
            
            
            $check = getimagesize($_FILES[$this->file]["tmp_name"]);
            if($check == false) {
                $message =  "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $message = "A file with that name already exists"; 
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["$this->file"]["size"] > $this->maxSize) {
                $message = "The image is too large, max allowed " . $this->maxSize;
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES[$this->file]["tmp_name"], $target_file)) {
                    $message = "The file ". $this->getImageLink(htmlspecialchars(basename($_FILES[$this->file]["name"]))) . " has been uploaded."; // TODO too long
                } else {
                // $message = "Sorry, there was an error uploading your file.";
                }
            } 
            $this->setMessage($message);
        }
    }


    /**
	 * Get url
	 *
	 */
    private function getImageLink(string $file) {
        $host = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        return "<a href='http://$host$uri/$this->target_dir/$file'>$file</a>";
    }
    /**
	 * Redirects to a valid path on server
	 *
	 */
    private function headerLocation(string $file) {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$file");
        exit();
    }

    
    private function setMessage(string $message) {
        $this->session->setMessage($message);		
    }

}

?>