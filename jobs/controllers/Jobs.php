<?php
namespace jobs\controllers;
class Jobs {
    private $jobsTable;
    private $catsTable;

    public function __construct(\CSY2028\DatabaseTable $jobsTable, \CSY2028\DatabaseTable $catsTable) {
        $this->jobsTable = $jobsTable;
        $this->catsTable = $catsTable;
    }

    public function home() {
        return ['template' => 'home.html.php',
                'title' => 'Jo\'s Jobs- Home',
                'vars' => ['cats' => $this->catsTable->findAll()]
            ];
    }

    public function category() {
        $cat = $this->catsTable->find('name', $_GET['page']);
        if ($cat == null) {
            return $this->notFound();
        }
        else {
            return ['template' => 'category.html.php',
                    'title' => 'Jo\'s Jobs- '. $_GET['page'],
                    'vars' => ['jobs' => $this->jobsTable->find('categoryId', $cat[0]->id),
                    'cats' => $this->catsTable->findAll(),
                    'heading' => $cat[0]->name]
            ];
        }
    }

    public function notFound() {
        return ['template' => 'notFound.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => []
            ];
    }
}
?>