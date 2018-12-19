<?php

/*
 * GC Uploader
 * 
 * Version 1.0.1 (2015-07-07)
 * 
 * Copyright (c) 2015 Ali Mantar (http://webkolog.net)
 * 
 * Licensed under the MIT license (http://mit-license.org/)
 * 
 */

include("Uploader.php");

class ImageUploader extends Uploader {

    public $maxWidth = 1024;
    public $maxHeight = 768;
    public $minWidth = 0;
    public $minHeight = 0;
    public $fileWidth = null;
    public $fileHeight = null;

    function __construct() {
        parent:: __construct();
    }

    private function checkFile() {
        $checkFileResult = parent::checkFile();
        if ($checkFileResult) {
            $types = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/x-icon");
            if (!in_array($this->fileType, $types)) {
                array_push($this->$errorMessages, "Resim dosyası seçmediniz!");
            } else {
                list($this->fileWidth, $this->fileHeight) = getimagesize($this->file["tmp_name"]);
                if ($this->fileWidth > $this->maxWidth) {
                    array_push($this->$errorMessages, "Dosya genişliği çok uzun!");
                } else if ($this->fileWidth < $this->minWidth) {
                    array_push($this->$errorMessages, "Dosya genişliği çok kısa!");
                }
                if ($this->fileHeight > $this->maxHeight) {
                    array_push($this->$errorMessages, "Dosya boyu çok uzun!");
                } else if ($this->fileHeight < $this->minHeight) {
                    array_push($this->$errorMessages, "Dosya boyu çok kısa!");
                }
            }
            if ($this->$errorMessages) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

}
