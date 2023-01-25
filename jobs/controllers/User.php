<?php
namespace jobs\controllers;
class User {
    private $usersTable;
    private $catsTable;
    private $vars;

    public function __construct(\CSY2028\DatabaseTable $usersTable, \CSY2028\DatabaseTable $catsTable) {
        $this->usersTable = $usersTable;
        $this->catsTable = $catsTable;
        $this->vars['cats'] = $this->catsTable->findAll();
        $this->vars['response'] = '';
    }

    public function login() {
        return ['template' => 'login.html.php',
                'title' => 'Jo\'s Jobs- Login',
                'vars' => $this->vars];
    }

    public function loginSubmit() {
        if ($_POST['username'] != '' && $_POST['password'] != '') {
            $user = $this->usersTable->find("username", $_POST['username']);

            if (count($user) > 0 && $_POST['submit'] == 'Register') {
                $this->vars['response'] = "Account already exists";
            }
            else if ($_POST['submit'] == "Register" && count($user) == 0) {
                $record = ['username' => $_POST['username'],
                            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                            'userType' => 'client'];
                $this->usersTable->save($record);
                $this->vars['response'] = 'You have now been registered';
            }
            else if ($_POST['submit'] == "Log In" && password_verify($_POST['password'], $user[0]->password)) {
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
                $this->vars['response'] .= "No Username was entered \n";
            }
            $this->vars['response'] .= 'Login Unsuccessful';
        }

        return ['template' => 'response.html.php',
                    'title' => 'Jo\'s Jobs- Login',
                    'vars' => $this->vars
        ];
    }

    public function logout() {
        unset($_SESSION['loggedin']);
        unset($_SESSION['userType']);
        $this->vars['response'] = 'Logged Out Successfully';

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Logged Out',
                'vars' => $this->vars];
    }
}
?>