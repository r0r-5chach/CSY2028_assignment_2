<?php
namespace jobs\Entity;
class Applicant { //Represents Applicant Entity from applicants table
    public $id;
    public $name;
    public $email;
    public $details;
    public $cv;
    public $jobId;
    private $jobsTable;
}
?>