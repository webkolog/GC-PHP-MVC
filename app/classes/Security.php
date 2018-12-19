<?php

class Security {

    public function __construct() {
        
    }

    public static function encrypt($data, $salt = null) {
        return md5(sha1(base64_encode(strrev($data) . $salt)));
    }

}
