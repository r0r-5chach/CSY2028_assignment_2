<?php
namespace jobs;
class Routes implements \CSY2028\Routes {
    public function getController($name) {
        //TODO: Add Database Tables
        //Remember entities
        $jobsTable = new \CSY2028\DatabaseTable('jobs', 'id');

        $controllers = [];
        //TODO: Add Controllers
        $controllers['home'] = new \jobs\controllers\Home($jobsTable);

        return $controllers[$name];
    }

    public function getDefaultRoute() {
       return 'home/home';
    }

    public function checkLogin($route) {
        \session_start();
        $loginRoutes = [];
        //TODO: Add login routes
        //$loginRoutes['job/edit'] = true;
        $requiresLogin = $loginRoutes[$route] ?? false;

        if ($requiresLogin && !\isset($_SESSION['loggedin'])) {
            \header('location: /user/login');
            exit();
        }

    }
}