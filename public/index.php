<?php
session_start(); //make sure session is started
require '../autoload.php'; //include autoload
$routes = new \jobs\Routes(); //get routes
$entryPoint = new \CSY2028\EntryPoint($routes); //get entrypoint
$entryPoint->run(); //start entrypoint
?>
