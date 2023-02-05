<?php
namespace jobs\controllers;
class User {
    private $usersTable;
    private $catsTable;
    private $vars;

    public function __construct(\jobs\JobDatabaseTable $usersTable, \jobs\JobDatabaseTable $catsTable) {
        $this->usersTable = $usersTable;
        $this->catsTable = $catsTable;
        $this->vars['cats'] = $this->catsTable->findAll();
        $this->vars['response'] = '';
    }
    //Login page
    public function login() { //Route: jobs.v.je/user/login
        return ['template' => 'login.html.php',
                'title' => 'Jo\'s Jobs- Login',
                'vars' => $this->vars];
    }
    //Login page POST
    public function loginSubmit() { //Route: jobs.v.je/user/login
        if ($_POST['username'] != '' && $_POST['password'] != '') {
            $user = $this->usersTable->find(["username"], ['value0' => $_POST['username']]);
            if (password_verify($_POST['password'], $user[0]->password)) {
                $user = $user[0];
                $_SESSION['loggedin'] = $user->id;
                $_SESSION['userType'] = $user->userType;
                $this->vars['response'] = 'You are now logged in';
            }
            else {
                unset($_SESSION['loggedin']);
                unset($_SESSION['userType']);
                $this->vars['response'] = 'Login Unsuccessful';

            }
        }
        else {
            if ($_POST['username'] == '') {
                $this->vars['response'] .= "No Username was entered \n";
            }
            if ($_POST['password'] == '') {
                $this->vars['response'] .= "No Password was entered \n";
            }
            $this->vars['response'] .= 'Login Unsuccessful';
        }

        return ['template' => 'response.html.php',
                    'title' => 'Jo\'s Jobs- Login',
                    'vars' => $this->vars
        ];
    }
    //Logout page
    public function logout() { //Route: jobs.v.je/user/logout
        unset($_SESSION['loggedin']);
        unset($_SESSION['userType']);
        $this->vars['response'] = 'Logged Out Successfully';

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Logged Out',
                'vars' => $this->vars];
    }
}
?>