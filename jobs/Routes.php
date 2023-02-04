<?php
namespace jobs;
class Routes extends \CSY2028\Routes {

    

    public function __construct() {
        $this->setDbTables();    
        $this->controllers = [
            "jobs" => new \jobs\controllers\Jobs($this->databaseTables["jobs"], $this->databaseTables["categories"], $this->databaseTables["applicants"]),
            "portal" => new \jobs\controllers\Portal($this->databaseTables["categories"], $this->databaseTables["jobs"], $this->databaseTables["applicants"]),
            "user" => new \jobs\controllers\User($this->databaseTables["users"], $this->databaseTables["categories"])
        ];
        $this->loginControllers = [
            "portal" => true
        ];
    }

    public function getDefaultRoute() {
       return 'jobs/home';
    }

    private function setDbTables() {
        $this->databaseTables = [];
        $this->databaseTables["categories"] = new \jobs\JobDatabaseTable('category', 'id', '\jobs\Entity\Category');
        $this->databaseTables["jobs"] = new \jobs\JobDatabaseTable('job', 'id', '\jobs\Entity\Job', [$this->databaseTables["categories"]]);
        $this->databaseTables["applicants"] = new \jobs\JobDatabaseTable('applicants', 'id', '\jobs\Entity\Applicant', [$this->databaseTables["jobs"]]);
        $this->databaseTables["users"] = new \jobs\JobDatabaseTable('users', 'id', '\jobs\Entity\User');
    }
}
?>