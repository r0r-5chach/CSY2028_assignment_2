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

    public function __construct(\jobs\JobDatabaseTable $jobsTable) {
        $this->jobsTable = $jobsTable;
    }

    public function getJob() {
        return $this->jobsTable->find(['id'], ['value0' => $this->jobId])[0];
    }
}
?>