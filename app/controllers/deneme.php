<?php

class deneme extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function main() {
        $this->load->cls("RandomName");
		$this->load->view('deneme');
        $index_model = $this->load->model('index');
		$db = $index_model->getDB();
        $this->mw = true;
    }

}
