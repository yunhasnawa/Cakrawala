<?php

namespace framework;

abstract class Controller
{
    private Application $_application;
    public function __construct(Application $application)
    {
        $this->_application = $application;
    }

    public abstract function index();

    protected function getApplication()
    {
        return $this->_application;
    }
}
