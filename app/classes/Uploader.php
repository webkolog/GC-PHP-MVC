<?php

/*
 * GC Uploader
 * 
 * Version 1.1.1 (2015-07-07)
 * 
 * Copyright (c) 2015 Ali Mantar (http://webkolog.net)
 * 
 * Licensed under the MIT license (http://mit-license.org/)
 * 
 */

class Uploader {

    public $file = null;
    public $newFileName = null;
    public $allowFileTypes = array();
    public $allowFileExtensions = array();
    public $maxSize = 50000;
    public $minSize = 0;
    public $dir = null;
    public $errorMessages = Array();
    private $fileName = null;
    private $fileSize = null;
    private $fileExtension = null;
    private $fileType = null;
    private $fullName = null;
    private $tmpName = null;
    private $fileChecked = false;

    function __construct() {
        $get_file = func_get_args();
        if (count($get_file) > 0)
            $this->file = $get_file[0];
    }

    public function checkError() {
        $count_errors = count($this->$errorMessages);
        $situation = false;
        if ($count_errors > 0) {
            $situation = true;
        }
        return $situation;
    }

    public function countErrors() {
        return count($errorMessages);
    }

    private function checkFile() {
        if (@is_uploaded_file($this->file["tmp_name"])) {
            $this->fullName = $this->file["name"];
            $parts = explode('.', $this->fullName);
            $parts_count = count($parts);
            if ($parts_count > 1) {
                //$this->fileExtension = $parts[$parts_count - 1];
                $this->fileExtension = end($parts);
            } else {
                $this->fileExtension = null;
            }
            $extension_len = strlen($this->fileExtension) + 1;
            $this->fileName = substr($this->fullName, 0, -$extension_len);
            $this->fileSize = $this->file["size"];
            $this->fileType = $this->file["type"];
            $this->tmpName = $this->file["tmp_name"];
            if (!in_array($this->fileExtension, $this->allowFileExtensions)) {
                array_push($this->$errorMessages, "İzin verilmeyen dosya uzantısı!");
            }
            if (!in_array($this->fileType, $this->allowFileTypes)) {
                array_push($this->$errorMessages, "İzin verilmeyen dosya türü!");
            }
            if ($this->fileSize < $this->minSize) {
                array_push($this->$errorMessages, "Dosya boyutu çok küçük!");
            }
            if ($this->fileSize > $this->maxSize) {
                array_push($this->$errorMessages, "Dosya boyutu çok büyük!");
            }
            if ($this->$errorMessages) {
                return false;
            } else {
                return true;
            }
        } else {
            array_push($this->$errorMessages, "Dosya seçmediniz!");
            return false;
        }
    }

    private function permission() {
        $permission = false;
        if ($this->$errorMessages) {
            $permission = false;
        } else {
            if ($this->fileChecked) {
                $permission = true;
            } else {
                if ($this->checkFile()) {
                    $permission = true;
                }
                $this->fileChecked = true;
            }
        }
        return $permission;
    }

    public function upload() {
        if ($this->permission()) {
            if ($this->newFileName != null) {
                $fileName = $this->newFileName . "." . $this->fileExtension;
            } else {
                $fileName = $this->fullName;
            }
            $tmpName = (substr($this->dir, -1) == "/" ? $this->dir : $this->dir . "/") . $fileName;
            if (file_exists($tmpName)) {
                array_push($this->$errorMessages, "Aynı isimde bir dosya daha önce eklenmiş!");
                return false;
            }
            $status = move_uploaded_file($this->file["tmp_name"], $tmpName);
            if ($status) {
                $this->tmpName = $tmpName;
                return true;
            } else {
                array_push($this->$errorMessages, "Dosya yüklenemedi!");
                return false;
            }
        } else {
            return false;
        }
    }

}
