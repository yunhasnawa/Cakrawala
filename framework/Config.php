<?php

namespace framework;

class Config
{
    private string $_appFolder;
    private string $_dbHost;
    private string $_dbUser;
    private string $_dbPassword;
    private string $_dbName;
    private string $_ormEntityDir;

    public function __construct()
    {
        $this->_appFolder = '';
        $this->_dbHost = '';
        $this->_dbUser = '';
        $this->_dbPassword = '';
        $this->_dbName = '';
        $this->_ormEntityDir = '';
    }

    public function set($key, $value): void
    {
        if(isset($this->{'_' . $key}))
            $this->{'_' . $key} = $value;
    }

    public function readEnvironment(): void
    {
        $env = file_get_contents('.env');
        $env = explode("\n", $env);
        foreach ($env as $line)
        {
            $line = explode('=', $line);

            if (count($line) == 2)
            {
                $key = trim($line[0]);
                $value = $line[1] === null ? '' : trim($line[1]);
                $this->set($key, $value);
            }
        }
    }

    public function getAppFolder(): string
    {
        return $this->_appFolder;
    }

    public function setAppFolder(string $appFolder): void
    {
        $this->_appFolder = $appFolder;
    }

    public function getDbHost(): string
    {
        return $this->_dbHost;
    }

    public function setDbHost(string $dbHost): void
    {
        $this->_dbHost = $dbHost;
    }

    public function getDbUser(): string
    {
        return $this->_dbUser;
    }

    public function setDbUser(string $dbUser): void
    {
        $this->_dbUser = $dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->_dbPassword;
    }

    public function setDbPassword(string $dbPassword): void
    {
        $this->_dbPassword = $dbPassword;
    }

    public function getDbName(): string
    {
        return $this->_dbName;
    }

    public function setDbName(string $dbName): void
    {
        $this->_dbName = $dbName;
    }

    public function getOrmEntityDir(): string
    {
        return $this->_ormEntityDir;
    }

    public function setOrmEntityDir(string $ormEntityDir): void
    {
        $this->_ormEntityDir = $ormEntityDir;
    }
}