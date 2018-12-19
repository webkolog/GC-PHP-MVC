<?php

/*
 * GC Pagination
 * Version 1.0.4 (2015-05-25)
 *
 * Copyright (c) 2015 Ali Mantar (http://webkolog.net)
 *
 * Licensed under the MIT license (http://mit-license.org/)
 *
 */

class Pagination {

    public $baseURL = "?page=";
    public $totalRows = 0;
    public $perPage = 10;
    public $page = 1;
    public $numbers = 5;
    public $linksFL = true;
    public $linksPN = true;
    public $start = 0;
    public $txtPrev = "Önceki";
    public $txtNext = "Sonraki";
    public $txtFirst = "İlk Sayfa";
    public $txtLast = "Son Sayfa";
    public $showLflAsNum = false;
    public $links = array();
    private $totalPages = 0;
    private $linkStatus = false;

    public function createLinks() {
        if ($this->linkStatus)
            return;
        if (!ctype_digit($this->page)) {
            if ($sayfa == "son") {
                $this->page = $this->totalPages;
                $this->start = ($this->totalPages * $this->perPage) - $this->perPage;
            } else {
                $this->page = 1;
                $this->start = ($this->page * $this->perPage) - $this->perPage;
            }
        } else {
            $this->page = $this->page ? $this->page : 1;
            $this->start = ($this->page * $this->perPage) - $this->perPage;
        }
        $this->totalPages = ceil($this->totalRows / $this->perPage);
        $i = $this->page - $this->numbers;
        $limit = $this->page + $this->numbers;
        if ($limit > $this->totalPages) {
            $limit = $this->totalPages;
        }
        if ($i < 1) {
            $i = 1;
        }
        if ($this->page > $this->numbers) {
            if ($this->linksPN) {
                $link = array("url" => $this->baseURL . ($this->page - 1), "text" => $this->txtPrev);
                array_push($this->links, $link);
            }
            if ($this->linksFL) {
                $text = ($this->showLflAsNum ? 1 : $this->txtFirst);
                $link = array("url" => $this->baseURL . "1", "text" => $text);
                array_push($this->links, $link);
            }
        }
        for ($i; $i <= ($limit - 1); $i++) {
            if ($this->page == $i) {
                $link = array("url" => "#", "text" => $i);
                array_push($this->links, $link);
            } else {
                $link = array("url" => $this->baseURL . $i, "text" => $i);
                array_push($this->links, $link);
            }
        }
        if ($limit < $this->totalPages) {
            if ($this->linksFL) {
                $text = ($this->showLflAsNum ? $this->totalPages : $this->txtLast);
                $link = array("url" => $this->baseURL . $this->totalPages, "text" => $text);
                array_push($this->links, $link);
            }
            if ($this->linksPN) {
                $link = array("url" => $this->baseURL . ($this->page + 1), "text" => $this->txtNext);
                array_push($this->links, $link);
            }
        } else {
            if ($this->page == $i) {
                $link = array("url" => "#", "text" => $i);
                array_push($this->links, $link);
            } else {
                $link = array("url" => $this->baseURL . $i, "text" => $i);
                array_push($this->links, $link);
            }
        }
        $this->linkStatus = true;
    }

}
