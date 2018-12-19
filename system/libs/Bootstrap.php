<?php

class Bootstrap {

    private $url = null;
    private $cname = null;
    private $mname = null;
    private $pname = null;

    public function __construct() {
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = rtrim($url, "/");
        //explode URL
        @$url_array = explode("/", $url);
        //if url exists
        if (is_array($url_array)) {
            //declare Controller and Method
            list($this->cname, $this->mname) = $url_array;
            $pnames = array_splice($url_array, 2);
            if (!empty($pnames)) {
                $this->pname = join(",", $pnames);
            }
        } else if (is_string($url_array)) {
            if (!empty($url_array)) {
                $this->cname = $url_array;
            }
        }
        //controller transaction
        $this->controllerTran();
    }

    private function pageNotFound() {
        include_once './app/controllers/index.php';
        $c = new index();
        $c->pageNotFound();
    }

    private function defaultPage() {
        include './app/controllers/index.php';
        $c = new index();
        $c->homepage();
    }

    private function controllerTran() {
        //control name is not null
        if ($this->cname != null) {
            //if controller file exists
            if (file_exists('./app/controllers/' . $this->cname . '.php')) {
                //include control file
                include './app/controllers/' . $this->cname . '.php';
                //if class exists
                if (class_exists($this->cname)) {
                    $c = new $this->cname();
                    //method transaction
                    $this->methodTran($c);
                } else {
                    //if class doesn't exist
                    $this->pageNotFound();
                }
            } else {
                //if controller file doesn't exist
                $this->pageNotFound();
            }
        } else {
            //control name is null
            $this->defaultPage();
        }
    }

    private function methodTran($c) {
        //method name is not null
        if ($this->mname != null) {
            //if method exists
            if (method_exists($c, $this->mname)) {
                $mname = $this->mname;
                //parameter name is not null
                if ($this->pname != null) {
                    //method has parameter(s)
                    $c->$mname($this->pname);
                } else {
                    //method without any parameter
                    $c->$mname();
                }
            } else {
                //if method doesn't exist
                $this->pageNotFound();
            }
        } else {
            //if method name is null
            //main method exists
            if (method_exists($c, "main")) {
                $c->main();
            } else {
                //main method doesn't exist
                $this->pageNotFound();
            }
        }
    }

}
