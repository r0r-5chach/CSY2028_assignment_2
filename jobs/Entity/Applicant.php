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
}
?>