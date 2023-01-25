<?php
namespace CSY2028;
interface Routes {
    public function getController($controllerName, $functionName);
    public function getDefaultRoute();
    public function checkLogin($route);
}
?>