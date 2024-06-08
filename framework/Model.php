<?php

namespace framework;

use PDO;
use PDOException;

abstract class Model
{
    private PDO $_connection;

    public function __construct()
    {
        $this->_initConnection();
    }

    private function _initConnection(): void
    {
        $this->_connection = self::createDbConnection(Application::getInstance()->getConfig());
    }

    public static function createDbConnection(Config $config): ?PDO
    {
        $dbHost     = $config->getDbHost();
        $dbName     = $config->getDbName();
        $dbUser     = $config->getDbUser();
        $dbPassword = $config->getDbPassword();

        try
        {
            return new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        }
        catch (PDOException $e)
        {
            error($e->getMessage());
            return null;
        }
    }

    protected function getConnection(): PDO
    {
        return $this->_connection;
    }

    protected function executeRead($sql, $params = []): false|array|null
    {
        $statement = $this->_connection->prepare($sql);
        $success = $statement->execute($params);

        if($success)
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        return null;
    }

    protected function executeWrite($sql, $params = []): int
    {
        $statement = $this->_connection->prepare($sql);
        $success = $statement->execute($params);

        if($success)
            return $statement->rowCount();

        return 0;
    }
}