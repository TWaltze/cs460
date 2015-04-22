<?php
class Uploader {
	private $baseDir;
	private $filename;
	private $ext;
	private $tmpPath;

	public function __construct($file, $baseDir = "uploads") {
		$subfolder = date("Y/m/d/H");
		$this->baseDir = "$baseDir/$subfolder";

		// Create subfolder if it doesn't already exist
		if(!self::dirExists($this->baseDir)) {
			mkdir($this->baseDir, 0777, true);
		}

        $this->fileData($file);

		$this->filename = $this->generateFilename();

        return $this;
	}

	private static function dirExists($dir) {
		return file_exists($dir) && is_dir($dir);
	}

	private function fileData($data) {
		$this->tmpPath = $data['tmp_name'];
		$this->ext = $this->getExt($data['name']);	// Get the file extension
	}

	public function __destruct() {
		// Delete file from tmp folder when finished
		if(isset($this->tmpPath) && file_exists($this->tmpPath)) {
			unlink($this->tmpPath);
		}
	}

	public function upload() {
		$filename = "{$this->filename}.{$this->ext}";

		// Path to the soon-to-be uploaded file
		$fileDestination = "{$this->baseDir}/$filename";

		// Upload file
		$upload = move_uploaded_file($this->tmpPath, $fileDestination);

		if($upload) {	// Successful upload
            return $fileDestination;
		} else {		// Unsuccessfull upload
            throw new Exception("Unknown error uploading photo.");
		}
	}

	private function cleanFileName($string) {
		$cln_filename_find = array("/\.[^\.]+$/", "/[^\d\w\s-]/", "/\s\s+/", "/[-]+/", "/[_]+/");
		$cln_filename_repl = array("", ""," ", "-", "_");
		$string = preg_replace($cln_filename_find, $cln_filename_repl, $string);
		return trim($string);
	}

	private function getExt($file) {
		/*$key = strtolower(substr(strrchr($key, "."), 1));
		$key = str_replace("jpeg", "jpg", $key);
		return $key;*/

		$info = pathinfo($file);
		return $info['extension'];
	}

	private function generateFilename($length = 15, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
		$str = '';
		$count = strlen($charset);

		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}

		return md5($str . time());
	}

	private static function mimeToExt($mime) {
		$types = array(
			'image/jpeg'	=> 'jpg',
			'image/png'		=> 'png',
			'image/gif'		=> 'gif'
		);

		return array_key_exists($mime, $types) ? $types[$mime] : null;
	}

	private static function extToMime($ext) {
		$types = array(
			'jpg'	=> 'image/jpeg',
			'png'	=> 'image/png',
			'gif'	=> 'image/gif'
		);

		return array_key_exists($ext, $types) ? $types[$ext] : null;
	}
}
?>
