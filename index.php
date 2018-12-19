<?php

/*
 * GC MVC (PHP Framework)
 * Version 1.0.0
 *
 * Copyright (c) 2015 Ali Mantar (http://webkolog.net)
 *
 * Licensed under the MIT license (http://mit-license.org/)
 *
 * Developed by Ali Mantar
 * 
 */

//sample URL: http://localhost/ControllerName/MethodName/Parameter1/Parameter2/Para...

function __autoload($filename) {
    include_once './system/libs/' . $filename . '.php';
}

include_once './app/config/config.php';
include_once './app/config/database.php';

new Bootstrap();



/*
 * #Yapılacak geliştirmeler
 * Tema motoru
 * Form validator
 * Pagination
 * Uploader
 * Cookies and session işlemleri
 * Yönlendirmeler
 * Vase URL, Path takibi yapacak benzeri configiration sabitleri
 * XSS güvenliği
*/
