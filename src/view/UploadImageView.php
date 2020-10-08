<?php

namespace View;

class UploadImageView {
	private static $file = 'UploadView::FileToUpload';
    private static $messageId = 'UploadView::Message';
	private static $upload = 'UploadView::Upload';
	private $message;

	public function setMessage(string $message) {
		$this->message = $message;	  
	}

	/**
	* Generate HTML code on the output buffer for the upload form
	* @param $message, String output message
	* @return string, html form
	*/
	public function response() {
		return '
		<h2>Upload image</h2>
		<form method="post" action="?upload" enctype="multipart/form-data"> 
				<fieldset>
					<legend>Select image to upload</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$file . '">File :</label><br>
					<input type="file" id="' . self::$file . '" name="' . self::$file . '" />
					<br>
					<input type="submit" name="' . self::$upload . '" value="Upload" />
				</fieldset>
			</form>
		';
	}

	public function isUploadFormPosted() : bool {
		return isset($_POST[self::$upload]);
	}

	public function getFileToUpload() : array {
		return $_FILES[self::$file];
	}

	
}