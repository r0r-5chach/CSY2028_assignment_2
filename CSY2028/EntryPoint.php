<?php
namespace CSY2028;
class EntryPoint {
    private $routes;

    public function __construct(\CSY2028\Routes $routes) {
        $this->routes = $routes;
    }

    public function loadTemplate($fileName, $templateData) {
        \extract($templateData);
        \ob_start();
        require $fileName;
        return \ob_get_clean();  
    }

    public function run() {
        $route = \ltrim(\explode('?', $_SERVER['REQUEST_URI'])[0], '/');
        if ($route == '') {
            $route = $this->routes->getDefaultRoute();
        }

        list($controllerName, $functionName) = \explode('/', $route);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $functionName = $functionName . 'Submit';
        }

        $page = $this->routes->getController($controllerName)->$functionName();
        $content = $this->loadTemplate('../templates/' . $page['template'], $page['vars']);
        $title = $page['title'];
        require '../templates/layout.html.php';
    }
}