<?php

namespace framework;

use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    private Application $_application;
    public function __construct(Application $application)
    {
        $this->_application = $application;
    }

    public abstract function index();

    protected function getApplication(): Application
    {
        return $this->_application;
    }

    #[NoReturn] protected function renderErrorAndExit(string $errorMessage, string|null $errorTemplate = null, int $exitCode = 1): void
    {
        if($errorTemplate === null)
            error($errorMessage, true, $exitCode);

        $view = new View($errorTemplate);
        $view->modifyData('error_message', $errorMessage);
        $view->render();
        exit($exitCode);
    }
}
