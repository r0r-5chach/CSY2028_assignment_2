<?php
namespace jobs\Entity;
class Enquiry {
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

    public function getAdmin() {
        if ($completed == 'y') {
            return $this->usersTable->find(['id'], ['value0' => $this->admin_id])[0];
        }
        else {
            return 'N/A';
        }

    }
}
?>