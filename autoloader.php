<?php

spl_autoload_register(function($class){
    $name = str_replace('\\', '/', $class);
    require_once($name.'.php');
});