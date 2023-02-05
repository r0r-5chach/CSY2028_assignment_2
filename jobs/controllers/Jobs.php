<?php
namespace jobs\controllers;
class Jobs {
    private $jobsTable;
    private $catsTable;
    private $appsTable;
    private $enquiryTable;
    private $vars = [];

    public function __construct(\jobs\JobDatabaseTable $jobsTable, \jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $appsTable, \jobs\JobDatabaseTable $enquiryTable) {
        $this->jobsTable = $jobsTable;
        $this->catsTable = $catsTable;
        $this->appsTable = $appsTable;
        $this->enquiryTable = $enquiryTable;
        $this->vars['cats'] = $this->catsTable->findAll();
    }
    //Homepage
    public function home() { //Route: jobs.v.je/jobs/home
        $this->vars['jobs'] = $this->jobsTable->find(["closingDate", 'archived'], ['value0' => date('y-m-d'), 'value1' => 'n'], ['>', '='], "DESC", "closingDate");
        return ['template' => 'home.html.php',
                'title' => 'Jo\'s Jobs- Home',
                'vars' => $this->vars
            ];
    }
    //Category pages
    public function category() { //Route: jobs.v.je/jobs/category
        $cat = $this->catsTable->find(['name'], ['value0' => $_GET['page']]);
        if ($cat == null) {
            return $this->notFound();
        }
        else {
            if (isset($_GET['filter'])) { //location filter for jobs
                $columns = ['categoryId', "location", 'closingDate', 'archived'];
                $values = ['value0' => $cat[0]->id, 
                            'value1' => $_GET['filter'],
                            'value2' => date('y-m-d'),
                            'value3' => 'n'
                ];
                $comparators = ["=","=",">",'='];
                $this->vars['jobs'] = $this->jobsTable->find($columns, $values, $comparators);
            }
            else {
                $this->vars['jobs'] = $this->jobsTable->find(['categoryId', 'closingDate', 'archived'], ["value0" => $cat[0]->id, "value1" => date("y-m-d"), 'value2' => 'n'], ["=", ">", '=']);

            }
            $this->vars['heading'] = $cat[0]->name;
            return ['template' => 'category.html.php',
                    'title' => 'Jo\'s Jobs- '. $_GET['page'],
                    'vars' => $this->vars
        ];
        }
    }
    //About page
    public function about() { //Route: jobs.v.je/jobs/about
        return ['template' => 'about.html.php',
                'title' => 'Jo\'s Jobs- About us',
                'vars' => $this->vars
    ];
    }
    //Contact page
    public function contact() { //Route: jobs.v.je/jobs/contact
        return ['template' => 'contact.html.php',
                'title' => 'Jo\'s Jobs- Contact',
                'vars' => $this->vars
        ];
    }
    //Contact page POST
    public function contactSubmit() { //Route: jobs.v.je/jobs/contact
        $record = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'telephone' => $_POST['number'],
            'enquiry' => $_POST['enquiry']
        ];
        $this->enquiryTable->save($record);
        $this->vars['response'] = 'Enquiry Sent';
        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Enquiry Sent',
                'vars' => $this->vars];
    }
    //404 page
    public function notFound() { //Route: jobs.v.je/jobs/notFound
        $this->vars['response'] = 'The page you have requested has not been found';
        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => $this->vars
    ];
    }
    //Job Application page
    public function apply() { //Route: jobs.v.je/jobs/apply
        $this->vars['job'] = $this->jobsTable->find(['id'], ["value0" => $_GET['id']])[0];
        return ['template' => 'apply.html.php',
                'title' => 'Jo\'s Jobs- Apply',
                'vars' => $this->vars];

    }
    //Job Application page POST
    public function applySubmit() { //Route: jobs.v.je/jobs/apply
        if ($_FILES['cv']['error'] == 0) {
            $parts = explode('.', $_FILES['cv']['name']);
            $extension = end($parts);
            $fileName = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES['cv']['tmp_name'], 'cvs/' . $fileName);
            $record = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'details' => $_POST['details'],
                'jobId' => $_POST['jobId'],
                'cv' => $fileName
            ];
            if (count($this->appsTable->find(['email', 'jobId'], ['value0' => $_POST['email'], 'value1' => $_POST['jobId']])) > 0) {
                $this->vars['response'] = 'You have already applied for this job';
            }
            else {
                $this->appsTable->save($record);
                $this->vars['response'] = 'Your application is complete. We will contact you after the closing date.';
            }
        }
        else {
            $this->vars['response'] = 'There was an error uploading your CV';
        }

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Apply',
                'vars' => $this->vars];

    }
    //FAQ Page
    public function faq() { //Route: jobs.v.je/jobs/faq
        return ['template' => 'construction.html.php',
                'title' => 'Jo\'s Jobs- FAQ',
                'vars' => $this->vars];
    }
}
?>