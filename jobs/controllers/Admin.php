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
        return ['template' => 'login.html.php',
                'title' => 'Jo\'s Jobs- Login',
                'vars' => $this->vars];
    }

    public function homeSubmit() {
        
    }
}