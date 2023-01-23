<?php
namespace jobs\Entity;
class Applicant {
    public $id;
    public $name;
    public $email;
    public $details;
    public $cv;
    public $jobId;
    private $jobsTable;

    public function __construct(\CSY2028\DatabaseTable $jobsTable) {
        $this->jobsTable = $jobsTable;
    }

    public function getJob() {
        return $this->jobsTable->find('id', $this->jobId)[0];
    }
}
?>