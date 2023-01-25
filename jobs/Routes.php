<?php
namespace jobs;
class Routes implements \CSY2028\Routes {

    public function getController($controllerName, $functionName) {
        $catsTable = new \CSY2028\DatabaseTable('category', 'id', '\jobs\Entity\Category');
        $jobsTable = new \CSY2028\DatabaseTable('job', 'id', '\jobs\Entity\Job', [$catsTable]);
        $appsTable = new \CSY2028\DatabaseTable('applicants', 'id', '\jobs\Entity\Applicant', [$jobsTable]);
        $usersTable = new \CSY2028\DatabaseTable('users', 'id', '\jobs\Entity\User');

        $controllers = [];
        //TODO: Add Controllers
        $controllers['jobs'] = new \jobs\controllers\Jobs($jobsTable, $catsTable, $appsTable);
        $controllers['admin'] = new \jobs\controllers\Admin($jobsTable, $catsTable, $appsTable, $usersTable);
        $controllers['user'] = new \jobs\controllers\User($usersTable, $catsTable);
        
        if (array_key_exists($controllerName, $controllers)) {
            if (\method_exists($controllers[$controllerName], $functionName)) {
                return $controllers[$controllerName];
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
       return 'jobs/home';
    }

    public function checkLogin($route) {
        $loginRoutes = [];
        //TODO: Add login routes
        //$loginRoutes['user'] = true;
        $loginRoutes['/admin/'] = true;
        $requiresLogin = $loginRoutes[$route] ?? false;

        if ($requiresLogin && !isset($_SESSION['loggedin'])) {
            header('location: /user/login');
            exit();
        }

    }

    public function notFound() {
        $cats = new \CSY2028\DatabaseTable('category', 'id', '\jobs\Entity\Category');
        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => ['cats' => $cats->findAll(),
                            'response' => '404 Page Not Found']
    ];
    }

    public function nav() {
        $cats = new \CSY2028\DatabaseTable('category', 'id', '\jobs\Entity\Category');
        return ['template' => 'nav.html.php',
                'vars' => ['cats' => $cats->findAll()]
    ];
    }
}