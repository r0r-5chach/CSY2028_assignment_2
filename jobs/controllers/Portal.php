<?php
namespace jobs\controllers;
class Portal {
    private $catsTable;
    private $jobsTable;
    private $appsTable;
    private $usersTable;
    private $enquiryTable;
    private $vars;

    public function __construct(\jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $jobsTable, \jobs\JobDatabaseTable $appsTable, \jobs\JobDatabaseTable $usersTable, \jobs\JobDatabaseTable $enquiryTable) {
        $this->catsTable = $catsTable;
        $this->jobsTable = $jobsTable;
        $this->appsTable = $appsTable;
        $this->usersTable = $usersTable;
        $this->enquiryTable = $enquiryTable;
        $this->vars['cats'] = $this->catsTable->findAll();
        $this->vars['table'] = 'job_table.html.php';
    }

    public function home() {
        $this->vars['table'] = 'job_table.html.php';
        if (isset($_GET['filter'])) {
            if ($_SESSION['userType'] == 'client') {
                $this->vars['jobs'] = $this->jobsTable->find(['clientId', 'categoryId'], ['value0' => $_SESSION['loggedin'],'value1' => $_GET['filter']]);
            }
            else {
                $this->vars['jobs'] = $this->jobsTable->find(["categoryId"], ['value0' => $_GET['filter']]);
            }
        } 
        else {
            if ($_SESSION['userType'] == 'client') {
                $this->vars['jobs'] = $this->jobsTable->find(['clientId'], ['value0' => $_SESSION['loggedin']]);
            }
            else {
                $this->vars['jobs'] = $this->jobsTable->findAll();
            }
        }
        return ['template' => 'portal.html.php',
                'title' => 'Jo\'s Jobs- Jobs',
                'vars' => $this->vars];
    }

    public function homeSubmit() {
        if ($_POST['submit'] == "List") {
            $this->vars['job'] = $this->jobsTable->find(['id'], ['value0' => $_POST['job_id']])[0]; 
            $this->vars['archive'] = true;
            $this->vars['update'] = true;
            return ['template' => 'job_add.html.php',
                    'title' => 'Jo\'s Jobs- Update Job',
                    'vars' => $this->vars];
        }
        else {
            if (isset($_POST['job_id'])) {
                $record = [
                    'id' => $_POST['job_id'],
                    'archived' => 'y'
                ];
                $this->jobsTable->save($record);
                return $this->home();
            }
            if (isset($_POST['cat_id'])) {
                $this->catsTable->delete("id", $_POST['cat_id']);
                $jobs = $this->jobsTable->find(['categoryId'], ['value0' => $_POST['cat_id']]);
                foreach ($jobs as $job) {
                    $this->jobsTable->delete("id", $job->id);
                }
                return $this->categories();
            }
            if (isset($_POST['user_id'])) {
                if($_POST['user_type'] == 'client') {
                    $this->usersTable->delete('id', $_POST['user_id']);
                    $jobs = $this->jobsTable->find(['clientId'], ['value0' => $_POST['user_id']]);
                    foreach ($jobs as $job) {
                        $this->jobsTable->delete('id', $job->id);
                    }
                    return $this->users();
                }
            }
        }
    }

    public function categories() {
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'category_table.html.php';
            $this->vars['cats'] = $this->catsTable->findAll();
            return ['template' => 'portal.html.php',
                'title' => 'Jo\'s Jobs- Categories',
                'vars' => $this->vars];
        }
    }

    public function applicants() {
        $job = $this->jobsTable->find(['id'], ['value0' => $_GET['job_id']])[0];
        $this->vars['table'] = 'applicant_table.html.php';
        $this->vars['apps'] = $job->getApps();
        $this->vars['job'] = $job->title;
        return ['template' => 'portal.html.php',
                'title' => 'Jo\'s Jobs- Applicants',
                'vars' => $this->vars];
    }

    public function users() {
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'user_table.html.php';
            $this->vars['users'] = $this->usersTable->findAll();
            return ['template' => 'portal.html.php',
                    'title' => 'Jo\'s Jobs- Users',
                    'vars' => $this->vars
            ];
        }
    }

    public function enquiries() {
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'enquiry_table.html.php';
            $this->vars['enqs'] = $this->enquiryTable->findAll();
            return ['template' => 'portal.html.php',
                    'title' => 'Jo\'s Jobs- Enquiries',
                    'vars' => $this->vars
            ];
        }
    }

    public function enquiriesSubmit() {
        $record = [
            'id' => $_POST['enq_id'],
            'completed' => 'y',
            'admin_id' => $_SESSION['loggedin']
        ];
        $this->enquiryTable->save($record);
        $this->enquiries();
    }

    public function addUser() {
        if ($_SESSION['userType'] == 'admin') {
            if (isset($_GET['user_id'])) {
                $this->vars['user'] = $this->usersTable->find(['id'], ['value0' => $_GET['user_id']])[0];
                $this->vars['update'] = true;
            }
            else {
                $this->vars['update'] = false;
            }
            return ['template' => 'user_add.html.php',
                    'title' => 'Jo\'s Jobs- Edit user',
                    'vars' => $this->vars
            ];
        }
    }

    public function addUserSubmit() {
        if ($_SESSION['userType'] == 'admin') {
            $record = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'userType' => $_POST['type']
            ];
            if ($_POST['submit'] == 'Update') {
                $record['id'] = $_POST['user_id'];
                $this->vars['response'] = 'User Updated Successfully';
            }
            else {
                $this->vars['response'] = 'User Created Successfully';
            }
            $this->usersTable->save($record);
            return [
                'template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Edit user',
                'vars' => $this->vars
            ];
        }
    }

    public function addJob() {
        if (isset($_GET['job_id'])) {
            $this->vars['job'] = $this->jobsTable->find(["id"], ['value0' => $_GET['job_id']])[0];
            $this->vars['archive'] = false;
            $this->vars['update'] = true;
        }
        else {
            $this->vars['archive'] = false;
            $this->vars['update'] = false;
        }
        return ['template' => 'job_add.html.php',
                'title' => 'Jo\'s Jobs- Edit Job',
                'vars' => $this->vars
        ];
    }

    public function addJobSubmit() {
        if ($this->catsTable->find(['name'], ['value0' => $_POST['categoryName']]) != 0) {
            $record = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'salary' => $_POST['salary'],
                'closingDate' => $_POST['closingDate'],
                'categoryId' => $this->catsTable->find(['name'], ['value0' => $_POST['categoryName']])[0]->id,
                'location' => $_POST['location'],
                'clientId' => $_POST['client_id'],
                'archived' => $_POST['archived']
            ];

            if ($_POST['submit'] == 'Create' && count($this->jobsTable->find(['title', 'clientId'], ['value0' => $_POST['title'], 'value1' => $_POST['client_id']])) == 0) {    
                $this->jobsTable->save($record);
                $this->vars['response'] = 'Job made successfully';
            }
            else if ($_POST['submit'] == 'Update') {
                $record['id'] = $_POST['jobId'];
                $this->jobsTable->save($record);
                $this->vars['response'] = 'Job updated successfully';
            }
        }
        else {
            $this->vars['response'] = 'Some data was incorrect';
        }

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Edit Job',
                'vars' => $this->vars
        ];
    }

    public function addCategory() {
        if ($_SESSION['userType'] == 'admin') {
            if (isset($_GET['cat_id'])) {
                $this->vars['cat'] = $this->catsTable->find(["id"], ['value0' => $_GET['cat_id']])[0];
                $this->vars['update'] = true;
            }
            else {
                $this->vars['update'] = false;
            }
            return ['template' => 'category_add.html.php',
                    'title' => 'Jo\'s Jobs- Edit Category',
                    'vars' => $this->vars
            ];
        }
    }

    public function addCategorySubmit() {
        if ($_SESSION['userType'] == 'admin') {
            if ($_POST['submit'] == 'Create') {
                if (count($this->catsTable->find(['name'], ['value0' => $_POST['name']])) > 0) {
                    $this->vars['response'] = 'This category already exists';
                }
                else {
                    $record = [
                        'name' => $_POST['name']
                    ];
                    $this->catsTable->save($record);
                    $this->vars['response'] = 'Category Created';
                }
            }
            else {
                $record = [
                    'id' => $_POST['id'],
                    'name' => $_POST['name']
                ];
                $this->catsTable->save($record);
                $this->vars['response'] = 'Category Updated';
            }
            return ['template' => 'response.html.php',
                    'title' => 'Jo\'s Jobs- Edit Category',
                    'vars' => $this->vars
            ];
        }
    }
}
?>