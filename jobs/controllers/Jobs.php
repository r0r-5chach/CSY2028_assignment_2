<?php
namespace jobs\controllers;
class Jobs {
    private $jobsTable;
    private $catsTable;
    private $vars = [];

    public function __construct(\CSY2028\DatabaseTable $jobsTable, \CSY2028\DatabaseTable $catsTable) {
        $this->jobsTable = $jobsTable;
        $this->catsTable = $catsTable;
        $this->vars['cats'] = $this->catsTable->findAll();
    }

    public function home() {
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
            $this->vars['jobs'] = $this->jobsTable->find('categoryId', $cat[0]->id);
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
        return ['template' => 'notFound.html.php',
                'title' => 'Jo\'s Jobs- 404 Not Found',
                'vars' => $this->vars
    ];
    }
}
?>