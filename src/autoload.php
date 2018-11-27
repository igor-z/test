<?php
require_once __DIR__.'/immutableFunction.php';

spl_autoload_register(function($class) {
    $class = str_replace('\\', '/', $class);
    $classFile = __DIR__."/$class.php";

    if (file_exists($classFile)) {
        require_once $classFile;
    }
});