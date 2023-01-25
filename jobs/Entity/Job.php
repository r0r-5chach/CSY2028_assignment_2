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

    public function __construct(\jobs\JobDatabaseTable $catsTable) {
        $this->catsTable = $catsTable;
    }

    public function getCat() {
        return $this->catsTable->find('id', $this->categoryId)[0];
    }
}
?>