<?php
namespace jobs\Entity;
class Job {
    public $id;
    public $title;
    public $description;
    public $salary;
    public $closingDate;
    public $location;
    public $categoryId;
    public $clientId;
    private $catsTable;
    private $appsTable;

    public function __construct(\jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $appsTable) {
        $this->catsTable = $catsTable;
        $this->appsTable = $appsTable;
    }

    public function getCat() {
        return $this->catsTable->find(['id'], ['value0' => $this->categoryId])[0];
    }

    public function getApps() {
        return $this->appsTable->find(['jobId'], ['value0' => $this->id]);
    }
}
?>