<?php
namespace jobs\Entity;
class Job { //Represents Job Entity from jobs table
    public $id;
    public $title;
    public $description;
    public $salary;
    public $closingDate;
    public $location;
    public $categoryId;
    public $clientId;
    public $archived;
    private $catsTable;
    private $appsTable;

    public function __construct(\jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $appsTable) {
        $this->catsTable = $catsTable;
        $this->appsTable = $appsTable;
    }

    public function getCat() { //Get category job is in
        return $this->catsTable->find(['id'], ['value0' => $this->categoryId])[0];
    }

    public function getApps() { //Get applicants for job
        return $this->appsTable->find(['jobId'], ['value0' => $this->id]);
    }
}
?>