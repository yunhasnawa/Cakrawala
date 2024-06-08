<?php

namespace framework;

class Application
{
    // Instance
    private static ?Application $_instance = null; // Nullable

    // Config
    private Config $_config;

    // Metadata
    private string $_appFolder;
    private string $_host;
    private string $_rootUrl;
    private string $_route;

    private Controller $_controller;
    private string $_controllerMethod;
    private string $_moduleFolder;

    private function __construct()
    {
        $this->_config = new Config();

        $this->_config->readEnvironment();

        $this->_importSiteSourceFiles();

        $this->_retrieveMetadata();
        $this->_resolveController();
    }

    public static function getInstance(): Application
    {
        if(Application::$_instance == null)
            Application::$_instance = new Application();

        return Application::$_instance;
    }

    public function run(): void
    {
        $this->_controller->{$this->_controllerMethod}();
    }

    private function _retrieveMetadata(): void
    {
        $this->_appFolder = $this->_config->getAppFolder();

        $this->_host = $_SERVER['HTTP_HOST'];
        $this->_rootUrl = $this->_requestScheme() . '://' . $this->_host;  // $_SERVER['REQUEST_SCHEME'] is not available in some servers
        // Default `route` is request URI
        $this->_route = $_SERVER['REQUEST_URI'];

        // If the app has app folder, then the root URL and route should be adjusted by considering it
        if($this->_appFolder !== '')
        {
            // Root URL: http://localhost:8080 --> http://localhost:8080/app-folder
            $this->_rootUrl .= "/{$this->_appFolder}";  // <-- Notice it has '/' before $appFolder.
            // Route: /app-folder/student --> /student
            $this->_route = str_replace("/{$this->_appFolder}", '/', $_SERVER['REQUEST_URI']);
        }

        if(str_contains($this->_route, '?'))
            $this->_route = substr($this->_route, 0, strpos($this->_route, '?'));
    }

    private function _requestScheme(): string
    {
        if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') ||
            (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||
            (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {
            $server_request_scheme = 'https';
        } else {
            $server_request_scheme = 'http';
        }

        return $server_request_scheme;
    }

    private function _resolveController(): void
    {
        $split = explode('/', $this->_route);

        $this->_resolveControllerMethod($split);
        $this->_resolveModuleFolder($split);

        $namespace = 'site\\' . $this->_moduleFolder;

        $className = ucfirst($this->_moduleFolder) . '_Controller';

        $controller = $namespace . '\\' . $className;

        $this->_controller = new $controller($this);
    }

    private function _resolveControllerMethod($routeSplit = array()): void
    {
        // If it has app folder: [host/app-folder/route/method], but if not: [host/route/method]
        $minSplit = $this->_appFolder === '' ? 3 : 4;

        if (count($routeSplit) < $minSplit)
            $method = 'index';
        else
        {
            if (empty($routeSplit[($minSplit - 1)]))  // [host/app-folder/route/] -> index();
                $method = 'index';
            else
                $method = $routeSplit[($minSplit - 1)];  // [host/app-folder/route/method] -> method();
        }

        $this->_controllerMethod = $method;
    }

    private function _resolveModuleFolder($routeSplit = array()): void
    {
        // If it has app folder: [host/app-folder/route], but if not: [host/route]
        $minSplit = $this->_appFolder === '' ? 1 : 2;

        $this->_moduleFolder = count($routeSplit) > $minSplit ? $routeSplit[$minSplit] : '';

        if(empty($this->_moduleFolder))
            $this->_moduleFolder = 'index';
    }

    public function getConfig(): Config
    {
        return $this->_config;
    }

    public function getHost(): string
    {
        return $this->_host;
    }

    public function getRootUrl(): string
    {
        return $this->_rootUrl;
    }

    public function getRoute(): string
    {
        return $this->_route;
    }

    private function _importSiteSourceFiles(): void
    {
        $files = [];

        Util::listFolderFiles('site', $files);

        foreach ($files as $file)
        {
            if(Util::strEndsWith($file, '.php'))
                require_once $file;
        }
    }
}