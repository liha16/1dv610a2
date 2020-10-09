<?php

namespace Controller;

require_once('model/ImageList.php');


class UploadController {

    private $uploadImageView;
    private $imageListModel;
    
    public function __construct(\View\UploadImageView $UploadImageView,  \Model\ImageList $imageModel) {
        $this->uploadImageView = $UploadImageView;
        $this->imageListModel = $imageModel;
    }

    /**
	 * Sets session messages for image upload
	 *
     * @return void
	 */
    public function handleUpload() {
        if ($this->uploadImageView->isUploadFormPosted()) {
            try {
                $fileToUpload = $this->uploadImageView->getFileToUpload();
                $message = $this->imageListModel->uploadImage($fileToUpload);
                //$this->session->setMessage($message);
                $this->uploadImageView->setMessage($message);
            } catch (\Exception $e) {
               // $this->session->setMessage($e->getMessage());
                $this->uploadImageView->setMessage($e->getMessage());
            }
            
        }
    }

}

?>