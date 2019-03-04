<?php
function autoloadModel($class) {
    $filename = "models/" . $class . ".php";
    if (file_exists($filename)) {
        require_once $filename;
    }
}

spl_autoload_register(autoloadModel);