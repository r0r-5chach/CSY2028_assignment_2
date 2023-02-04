<?php
namespace jobs\controllers;
class Jobs {
    private $jobsTable;
    private $catsTable;
    private $appsTable;
    private $vars = [];

    public function __construct(\jobs\JobDatabaseTable $jobsTable, \jobs\JobDatabaseTable $catsTable, \jobs\JobDatabaseTable $appsTable) {
        $this->jobsTable = $jobsTable;
        $this->catsTable = $catsTable;
        $this->appsTable = $appsTable;
        $this->vars['cats'] = $this->catsTable->findAll();
    }

    public function home() {
        $this->vars['jobs'] = $this->jobsTable->find("closingDate", date("y-m-d"), "", "", ">", "", "DESC", "closingDate");
        return ['template' => 'home.html.php',
                'title' => 'Jo\'s Jobs- Home',
                'vars' => $this->vars
            ];
    }

    public function category() {
        $cat = $this->catsTable->find('name', $_GET['page']);
        if ($cat == null) {
            return $this->notFound();
        }
        else {
            if (isset($_GET['filter'])) {
                $this->vars['jobs'] = $this->jobsTable->find('categoryId', $cat[0]->id, "location", $_GET['filter']);
            }
            else {
                $this->vars['jobs'] = $this->jobsTable->find('categoryId', $cat[0]->id, "closingDate", date("y-m-d"), "=", ">");

            }
            $this->vars['heading'] = $cat[0]->name;
            return ['template' => 'category.html.php',
                    'title' => 'Jo\'s Jobs- '. $_GET['page'],
                    'vars' => $this->vars
        ];
        }
    }

    public function about() {
        return ['template' => 'about.html.php',
                'title' => 'Jo\'s Jobs- About us',
                'vars' => $this->vars
    ];
    }


    public function notFound() {
        $this->vars['response'] = 'The page you have requested has not been found';
        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => $this->vars
    ];
    }

    public function apply() {
        $this->vars['job'] = $this->jobsTable->find('id', $_GET['id'])[0];
        return ['template' => 'apply.html.php',
                'title' => 'Jo\'s Jobs- Apply',
                'vars' => $this->vars];

    }

    public function applySubmit() {
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
            $this->appsTable->save($record);
            $this->vars['response'] = 'Your application is complete. We will contact you after the closing date.';
        }
        else {
            $this->vars['response'] = 'There was an error uploading your CV';
        }

        return ['template' => 'response.html.php',
                'title' => 'Jo\'s Jobs- Apply',
                'vars' => $this->vars];

    }

    public function faq() {
        return ['template' => 'construction.html.php',
                'title' => 'Jo\'s Jobs- FAQ',
                'vars' => $this->vars];
    }
}
?>