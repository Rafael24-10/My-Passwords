<?php
spl_autoload_register('pullclasses');

function pullclasses($className)
{
    $path = "classes/";
    $extension = ".class.php";
    $fullpath = $path . $className . $extension;

    if (!file_exists($fullpath)) {
        return false;
    } else {
        null;
    }

    include_once $fullpath;
};
