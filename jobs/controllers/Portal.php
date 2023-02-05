<?php
namespace jobs\controllers;
class Portal {
    private $catsTable;
    private $jobsTable;
    private $appsTable;
    private $vars;

    public function __construct(\jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $jobsTable, \jobs\JobDatabaseTable $appsTable) {
        $this->catsTable = $catsTable;
        $this->jobsTable = $jobsTable;
        $this->appsTable = $appsTable;
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
            //TODO: Direct to edit job date
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
                return $this->categories();
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

    public function edit() { //TODO: finish this function
        if (isset($_GET['job_id'])) {
            $this->vars['job'] = $this->jobsTable->find(["id"], ['value0' => $_GET['jod_id']]);
        }
        if (isset($_GET['cat_id'])) {
            $this->vars['cat'] = $this->catsTable->find(["id"], ['value0' => $_GET['cat_id']]);
        }
    }

    public function addJob() {
        return ['template' => 'job_add.html.php',
                'title' => 'Jo\'s Jobs- Add Job',
                'vars' => $this->vars
        ];
    }

    public function addJobSubmit() {
        if (count($this->jobsTable->find(['title', 'clientId'], ['value0' => $_POST['title'], 'value1' => $_POST['client_id']])) == 0 && $this->catsTable->find(['name'], ['value0' => $_POST['categoryName']]) != 0) {
            $record = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'salary' => $_POST['salary'],
                'closingDate' => $_POST['closingDate'],
                'categoryId' => $this->catsTable->find(['name'], ['value0' => $_POST['categoryName']])[0]->id,
                'location' => $_POST['location'],
                'clientId' => $_POST['client_id']
            ];
            $this->jobsTable->save($record);
            $this->vars['response'] = 'Job made successfully';
        }
        else {
            $this->vars['response'] = 'Some data was incorrect';
        }

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Add Job',
                'vars' => $this->vars
        ];
    }

    public function addCategory() {
        if ($_SESSION['userType'] == 'admin') {
            return ['template' => 'category_add.html.php',
                    'title' => 'Jo\'s Jobs- Add Category',
                    'vars' => $this->vars
            ];
        }
    }

    public function addCategorySubmit() {
        if ($_SESSION['userType'] == 'admin') {
            
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
            return ['template' => 'response.html.php',
                    'title' => 'Jo\'s Jobs- Add Category',
                    'vars' => $this->vars
            ];
        }
    }
}
?>