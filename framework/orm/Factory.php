<?php

namespace framework\orm;

use framework\Application;
use framework\Config;
use framework\Model;
use framework\Util;

class Factory
{
    public static function generateEntityClass($tableName): void
    {
        $config = new Config();
        $config->readEnvironment();

        $connection = Model::createDbConnection($config);

        $sql = "DESCRIBE $tableName";

        $statement = $connection->prepare($sql);

        $statement->execute();

        $fields = $statement->fetchAll();

        $className = Util::strToPascalCase($tableName);

        $entityClass = "<?php\n\nnamespace lib\\entity;\n\nuse framework\\orm\\Entity;\n\nclass $className extends Entity\n{\n";

        // Properties
        foreach ($fields as $field)
        {
            $prop = Util::strToCamelCase($field['Field']);
            $entityClass .= "    public \${$prop};\n";
        }

        $entityClass .= "    public function __construct()\n    {\n        parent::__construct('$tableName');\n    }\n";
        $entityClass .= "}\n";

        $entityFile = $config->getOrmEntityDir() . "/$className.php";

        echo "--> Writing the class file to `$entityFile`.\n";
        file_put_contents($entityFile, $entityClass);

        echo "--> Done.\n";
    }

    public static function autoloadEntities(): void
    {
        $config = Application::getInstance()->getConfig();
        $ormDir = $config->getOrmEntityDir();

        if (empty($ormDir)) return;

        foreach (glob($ormDir . '/*.php') as $filename)
        {
            require_once $filename;
        }
    }
}

// The script is executed directly from the command line
if (php_sapi_name() === 'cli' && realpath($argv[0]) === __FILE__)
{
    require_once 'framework/cakrawala.php';

    echo "--> This script is run from the command line.\n";

    // Get -t option value from CLI
    $options = getopt('t:');
    if (isset($options['t']))
    {
        $tableName = $options['t'];
        echo "--> Generating entity class for table `$tableName`.\n";
        Factory::generateEntityClass($tableName);
    }
}