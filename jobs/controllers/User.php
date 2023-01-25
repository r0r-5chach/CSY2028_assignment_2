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
}