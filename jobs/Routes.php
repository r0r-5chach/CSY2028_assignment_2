<?php
namespace jobs;
class Routes implements \CSY2028\Routes {

    public function getController($controllerName, $functionName) {
        $catsTable = new \jobs\JobDatabaseTable('category', 'id', '\jobs\Entity\Category');
        $jobsTable = new \jobs\JobDatabaseTable('job', 'id', '\jobs\Entity\Job', [$catsTable]);
        $appsTable = new \jobs\JobDatabaseTable('applicants', 'id', '\jobs\Entity\Applicant', [$jobsTable]);
        $usersTable = new \jobs\JobDatabaseTable('users', 'id', '\jobs\Entity\User');

        $controllers = [];
        $controllers['jobs'] = new \jobs\controllers\Jobs($jobsTable, $catsTable, $appsTable);
        $controllers['portal'] = new \jobs\controllers\Portal($catsTable, $jobsTable, $appsTable);
        $controllers['user'] = new \jobs\controllers\User($usersTable, $catsTable);
        
        $this->checkLogin($controllerName);

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

    public function checkLogin($name) {
        $loginRoutes = [];
        $loginRoutes['portal'] = true;
        $requiresLogin = $loginRoutes[$name] ?? false;

        if ($requiresLogin && !isset($_SESSION['loggedin'])) {
            header('location: /user/login');
            exit();
        }

    }

    public function notFound() {
        $cats = new \jobs\JobDatabaseTable('category', 'id', '\jobs\Entity\Category');
        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => ['cats' => $cats->findAll(),
                            'response' => '404 Page Not Found']
    ];
    }

    public function nav() {
        $cats = new \jobs\JobDatabaseTable('category', 'id', '\jobs\Entity\Category');
        return ['template' => 'nav.html.php',
                'vars' => ['cats' => $cats->findAll()]
    ];
    }
}
?>