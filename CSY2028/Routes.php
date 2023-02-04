<?php
namespace CSY2028;
class Routes {
    protected $databaseTables;
    protected $controllers;
    protected $loginControllers;

    public function __construct() {
        $this->databaseTables = [];
        $this->controllers = [];
        $this->loginControllers = [];
    }

    public function getController($controllerName, $functionName) {
        
        $this->checkLogin($controllerName);

        if (array_key_exists($controllerName, $this->controllers)) {
            if (\method_exists($this->controllers[$controllerName], $functionName)) {
                return $this->controllers[$controllerName];
            }
            else {
                return null;
            }
        }
        else {
            return null;
        }

    }

    public function getDefaultRoute() {
       return 'controller/home';
    }

    public function checkLogin($name) {
        $requiresLogin = $this->loginControllers[$name] ?? false;

        if ($requiresLogin && !isset($_SESSION['loggedin'])) {
            header('location: /user/login');
            exit();
        }

    }

    public function notFound() {
        return ['template' => 'response.html.php',
                'title' => '404 Not Found',
                'vars' => ['response' => '404 Page Not Found']
    ];
    }
}
?>