<?php
namespace jobs\controllers;
class Admin {
    private $jobsTable;
    private $catsTable;
    private $appsTable;
    private $usersTable;
    private $vars = [];

    public function __construct(\CSY2028\DatabaseTable $jobsTable, \CSY2028\DatabaseTable $catsTable, \CSY2028\DatabaseTable $appsTable, \CSY2028\DatabaseTable $usersTable) {
        $this->jobsTable = $jobsTable;
        $this->catsTable = $catsTable;
        $this->appsTable = $appsTable;
        $this->usersTable = $usersTable;
        $this->vars['cats'] = $this->catsTable->findAll();
        $this->vars['response'] = '';
    }

    public function home() {
        return ['template' => 'admin.html.php',
                'title' => 'Jo\'s Jobs- Login',
                'vars' => $this->vars];
    }

    public function homeSubmit() {
        if ($_POST['username'] == '' && $_POST['password'] = '') {
            $user = $this->usersTable->find("username", $_POST['username']);
            if (password_verify($_POST['password'], $user->password)) {
                $_SESSION['loggedin'] = true;
                $this->vars['response'] = 'You are now logged in';
            }
            else {
                unset($_SESSION['loggedin']);
                $this->vars['response'] = 'Login Unsuccessful';

            }
        }
        else {
            if ($_POST['username'] == '') {
                $this->vars['response'] .= "No Username was entered \n";
            }
            if ($_POST['password'] == '') {
                $this->vars['response'] .= "No Username was entered \n";
            }
            $this->vars['response'] .= 'Login Unsuccessful';
        }

        return ['template' => 'admin.html.php',
                    'title' => 'Jo\'s Jobs- Login',
                    'vars' => $this->vars
        ];
    }
}