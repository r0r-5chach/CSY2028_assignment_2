<?php
namespace jobs\controllers;
class Home {
    private $jobTable;

    public function __construct(\CSY2028\DatabaseTable $jobTable) {
        $this->jobTable = $jobTable;
    }

    public function home() {
        return ['template' => 'home.html.php',
                'title' => 'Jo\'s Jobs- Home',
                'vars' => []
            ];
    }
}
?>