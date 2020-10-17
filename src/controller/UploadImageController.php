<?php

namespace Controller;

require_once('model/ImageList.php');

class UploadImageController {

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
                $this->uploadImageView->setMessage($message);
            } catch (\Exception $e) {
                $this->uploadImageView->setMessage($e->getMessage());
            }
            
        }
    }

}
?>