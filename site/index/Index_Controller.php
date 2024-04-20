<?php

namespace site\index;

use framework\Controller;
use framework\View;

class Index_Controller extends Controller
{
    #[\Override] public function index(): void
    {
        $name = $_GET['name'] ?? 'World';

        $greetings = "Hello, $name! This is my Cakrawala :)";

        $view = new View('templates/index_template.php');

        $view->setData([
            'greetings' => $greetings
        ]);

        $view->render();
    }
}