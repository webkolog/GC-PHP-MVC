<?php

class index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function main() {
        $this->homepage();
    }

    public function homepage() {
        $this->load->view('homepage');
        $index_model = $this->load->model('index');
        $this->mw = true;
    }

    public function pageNotFound() {
        $this->load->view("404");
    }

}
