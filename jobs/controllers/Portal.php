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
    //Portal homepage
    public function home() { //Route: jobs.v.je/portal/
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
    //Portal homepage POST
    public function homeSubmit() { //Route: jobs.v.je/portal/
        if ($_POST['submit'] == "List") { //Relist archived job
            $this->vars['job'] = $this->jobsTable->find(['id'], ['value0' => $_POST['job_id']])[0]; 
            $this->vars['archive'] = true;
            $this->vars['update'] = true;
            return ['template' => 'job_add.html.php',
                    'title' => 'Jo\'s Jobs- Update Job',
                    'vars' => $this->vars];
        }
        else {
            if (isset($_POST['job_id'])) { //archive job
                $record = [
                    'id' => $_POST['job_id'],
                    'archived' => 'y'
                ];
                $this->jobsTable->save($record);
                return $this->home();
            }
            if (isset($_POST['cat_id'])) { //delete category
                $this->catsTable->delete("id", $_POST['cat_id']);
                $jobs = $this->jobsTable->find(['categoryId'], ['value0' => $_POST['cat_id']]);
                foreach ($jobs as $job) {
                    $this->jobsTable->delete("id", $job->id);
                }
                return $this->categories();
            }
            if (isset($_POST['user_id'])) { //delete user
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
    //Categories Portal page
    public function categories() { //Route: jobs.v.je/portal/categories
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'category_table.html.php';
            $this->vars['cats'] = $this->catsTable->findAll();
            return ['template' => 'portal.html.php',
                'title' => 'Jo\'s Jobs- Categories',
                'vars' => $this->vars];
        }
    }
    //Applicants Portal page
    public function applicants() { //Route: jobs.v.je/portal/applicants
        $job = $this->jobsTable->find(['id'], ['value0' => $_GET['job_id']])[0];
        $this->vars['table'] = 'applicant_table.html.php';
        $this->vars['apps'] = $job->getApps();
        $this->vars['job'] = $job->title;
        return ['template' => 'portal.html.php',
                'title' => 'Jo\'s Jobs- Applicants',
                'vars' => $this->vars];
    }
    //Users Portal page
    public function users() { //Route: jobs.v.je/portal/users
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'user_table.html.php';
            $this->vars['users'] = $this->usersTable->findAll();
            return ['template' => 'portal.html.php',
                    'title' => 'Jo\'s Jobs- Users',
                    'vars' => $this->vars
            ];
        }
    }
    //Enquiries Portal page
    public function enquiries() { //Route: jobs.v.je/portal/enquiries
        if ($_SESSION['userType'] == 'admin') {
            $this->vars['table'] = 'enquiry_table.html.php';
            $this->vars['enqs'] = $this->enquiryTable->findAll();
            return ['template' => 'portal.html.php',
                    'title' => 'Jo\'s Jobs- Enquiries',
                    'vars' => $this->vars
            ];
        }
    }
    //Enquiries Portal page POST
    public function enquiriesSubmit() { //Route: jobs.v.je/portal/enquiries
        $record = [
            'id' => $_POST['enq_id'],
            'completed' => 'y',
            'admin_id' => $_SESSION['loggedin']
        ];
        $this->enquiryTable->save($record);
        $this->enquiries();
    }
    //Edit User Portal page
    public function addUser() { //Route: jobs.v.je/portal/addUser
        if ($_SESSION['userType'] == 'admin') {
            if (isset($_GET['user_id'])) { //Update user
                $this->vars['user'] = $this->usersTable->find(['id'], ['value0' => $_GET['user_id']])[0];
                $this->vars['update'] = true;
            }
            else { //Create user
                $this->vars['update'] = false;
            }
            return ['template' => 'user_add.html.php',
                    'title' => 'Jo\'s Jobs- Edit user',
                    'vars' => $this->vars
            ];
        }
    }
    //Edit User Portal page POST
    public function addUserSubmit() {
        if ($_SESSION['userType'] == 'admin') {
                if($_POST['password'] != "") {
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
    }
    //Edit Job Portal page
    public function addJob() { //Route: jobs.v.je/portal/addJob
        if (isset($_GET['job_id'])) { //Update Job
            $this->vars['job'] = $this->jobsTable->find(["id"], ['value0' => $_GET['job_id']])[0];
            $this->vars['archive'] = false;
            $this->vars['update'] = true;
        }
        else { //Create Job
            $this->vars['archive'] = false;
            $this->vars['update'] = false;
        }
        return ['template' => 'job_add.html.php',
                'title' => 'Jo\'s Jobs- Edit Job',
                'vars' => $this->vars
        ];
    }
    //Edit Job page POST
    public function addJobSubmit() { //Route: jobs.v.je/portal/addJob
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
    //Edit Category page
    public function addCategory() { //Route: jobs.v.je/portal/addCategory
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
    //Edit Category page POST
    public function addCategorySubmit() { //Route: jobs.v.je/portal/addCategory
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