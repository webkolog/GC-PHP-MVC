<?php

class Model {

    protected $db = array();
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;

    public function __construct() {
        $this->engine = DBTYPE;
        $this->host = DBHOST;
        $this->database = DBNAME;
        $this->user = DBUSER;
        $this->pass = DBPASSWORD;
        $dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
        $this->db = new Database($dns, $this->user, $this->pass);
    }

}
