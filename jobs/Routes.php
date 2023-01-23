<?php
namespace jobs;
class Routes implements \CSY2028\Routes {
    public function getController($name) {
        $catsTable = new \CSY2028\DatabaseTable('category', 'id', '\jobs\Entity\Category');
        $jobsTable = new \CSY2028\DatabaseTable('job', 'id', '\jobs\Entity\Job', [$catsTable]);
        $appsTable = new \CSY2028\DatabaseTable('applicants', 'id', '\jobs\Entity\Applicant', [$jobsTable]);

        $controllers = [];
        //TODO: Add Controllers
        $controllers['jobs'] = new \jobs\controllers\Jobs($jobsTable, $catsTable, $appsTable);

        if (array_key_exists($name, $controllers)) {
            return $controllers[$name];
        }
        else {
            return null;
        }

    }

    public function getDefaultRoute() {
       return 'jobs/home';
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