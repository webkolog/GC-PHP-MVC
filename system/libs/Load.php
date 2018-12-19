<?php

class Load {

    public function __construct() {
        
    }

    public function view($filename, $data = null) {
        if ($data) {
            extract($data);
        }
        include 'app/views/' . $filename . '_view.php';
    }

    public function model($filename) {
        $filename = $filename . '_model';
        include 'app/models/' . $filename . '.php';
        return new $filename();
    }

    public function cls($filename) {
        include 'app/classes/' . $filename . '.php';
    }

    public function func($filename) {
        include 'app/functions/' . $filename . '.php';
    }

    public function lang($filename) {
        include 'app/languages/'.$filename.'.php';
    }

}
