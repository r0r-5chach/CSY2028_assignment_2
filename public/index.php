<?php
require '../autoload.php';
$routes = new \jobs\Routes();
$entryPoint = new \CSY2028\EntryPoint($routes);
$entryPoint->run();
?>
