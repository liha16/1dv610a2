<?php

namespace Controller;

require_once('model/ImageList.php');


class UploadController {

    private static $upload = 'UploadView::Upload';
    private $file = 'UploadView::FileToUpload';
    private $target_dir = "uploads/";
    private $session;
    private $maxSize = 500000;
    private $allowedFileTypes = ["jpg", "png", "jpeg", "gif"];
	
    public function __construct(\Model\SessionStorage $session) {
        $this->session = $session;
        $this->handleUpload();
        
    }

    /**
	 * Sets session messages for register form 
     * 
     * Code inspired from https://www.w3schools.com/php/php_file_upload.asp
	 *
     * @return void, BUT writes to cookies and session!
	 */
    private function handleUpload() {

        if (isset($_POST[self::$upload])) {
            if (empty($_FILES[$this->file]["tmp_name"])) { // No image selected
                $message = "You must select an image to upload.";
            } else {
                $targetFileName = basename($_FILES[$this->file]["name"]);
                $targetFile = $this->target_dir . $targetFileName;
                $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

                if (!getimagesize($_FILES[$this->file]["tmp_name"])) { // Is it an image
                    $message =  "File is not an image.";
                } else if (file_exists($targetFile)) { // Check if file already exists
                    $message = "A file with that name already exists"; 
                } else if ($_FILES["$this->file"]["size"] > $this->maxSize) { // Check file size
                    $message = "The image is too large, max allowed " . $this->maxSize;
                } else if (!in_array($imageFileType, $this->allowedFileTypes)) { // Allow certain file formats
                    $message = "Filetype " . $imageFileType . " is not allowed.";
                } else {
                    if (move_uploaded_file($_FILES[$this->file]["tmp_name"], $targetFile)) { // Try to upload
                        $message = "The file ". $this->getImageLink(htmlspecialchars($targetFileName)) . " has been uploaded.";
                    } else {
                        $message = "Sorry, there was an error uploading your file.";
                    }
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