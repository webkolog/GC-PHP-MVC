<?php

class index_model extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getDB() {
        return $this->db;
    }

}
