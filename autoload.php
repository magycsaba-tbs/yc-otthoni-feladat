<?php

const DS = DIRECTORY_SEPARATOR;
const APP_ROOT = __DIR__ . DS . '/src/';
spl_autoload_register('TestAutoload');

function TestAutoload($className)
{
    $segments = explode("\\", $className);
    if (file_exists(APP_ROOT . implode(DS, $segments) . ".php")) {
        include_once(APP_ROOT . implode(DS, $segments) . ".php");
    }
}
