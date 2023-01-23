<?php
namespace jobs\Entity;
class Job {
    public $id;
    public $description;
    public $salary;
    public $closingDate;
    public $location;
    public $categoryId;
    private $catsTable;

    public function __construct(\CSY2028\DatabaseTable $catsTable) {
        $this->catsTable = $catsTable;
    }

    public function getCat() {
        return $this->catsTable->find('id', $this->categoryId);
    }
}