<?php
namespace jobs\Entity;
class Enquiry { //Represents enquiry Entity from enquiries table
    public $id;
    public $name;
    public $email;
    public $telephone;
    public $enquiry;
    public $completed;
    public $admin_id;
    private $usersTable;

    public function __construct(\jobs\JobDatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }

    public function getAdmin() { //Get the admin that completed the enquiry
        if ($this->completed == 'y') {
            return $this->usersTable->find(['id'], ['value0' => $this->admin_id])[0];
        }
        else  {
            return 'N/A';
        }

    }
}
?>