<?php

namespace Controller;

require_once('model/ImageList.php');


class UploadController {

    private $session;
    private $UploadImageView;
    private $imageListModel;
    
    public function __construct(\Model\SessionStorage $session, \View\UploadImageView $UploadImageView,  \Model\ImageList $imageModel) {
        $this->session = $session;
        $this->UploadImageView = $UploadImageView;
        $this->imageListModel = $imageModel;
        $this->handleUpload();
        
    }

    /**
	 * Sets session messages for image upload
	 *
     * @return void, BUT writes to session!
	 */
    private function handleUpload() {

        if ($this->UploadImageView->isUploadFormPosted()) {

            $fileToUpload = $this->UploadImageView->getFileToUpload();
            $message = $this->imageListModel->uploadImage($fileToUpload);

            $this->session->setMessage($message);
        }
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

}

?>