<?php
function autoload($name) {
    require '../'. str_replace('\\', '/', $name) .'.php';
}
spl_autoload_register('autoload');
?>