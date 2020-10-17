<?php

namespace View;

class ImageListView {

    private $images;
    private $folder = "uploads/";

	public function __construct(\Model\ImageList $imageList) {
        $this->images = $imageList->getImages();
	}


	/**
	* Generate HTML code on the output buffer for the upload form
	* @param $message, String output message
	* @return string, html form
	*/
	public function response() : string {
        $html = '<h2>List images</h2>';
        
        foreach ($this->images as $image) {
            $html .= '<a href="' . $this->folder .  $image . '">';
            $html .= '<img src="' . $this->folder . $image . '" alt="bild" width="200" height="auto">';
            $html .= '</a> ';
            
        }
        return $html;
	}
}