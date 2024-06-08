<?php

namespace framework;

class Util
{
    public static function listFolderFiles(string $directory, array &$results): void
    {
        $ffs = scandir($directory);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;

        foreach($ffs as $ff){
            $path = $directory . '/' . $ff;
            if(is_dir($path))
                Util::listFolderFiles($path, $results);
            else
                $results[] = $path;
        }
    }

    public static function strStartsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        return substr($haystack, 0, $length) === $needle;
    }

    public static function strEndsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if (!$length)
            return true;

        return substr($haystack, -$length) === $needle;
    }

    public static function strToPascalCase($string): string
    {
        // Remove any non-alphanumeric characters and replace them with a space
        $string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);

        // Convert the string to an array of words
        $words = explode(' ', $string);

        // Capitalize the first letter of each word and concatenate them
        $pascalCaseString = '';
        foreach ($words as $word)
        {
            if (!empty($word))
            {
                $pascalCaseString .= ucfirst(strtolower($word));
            }
        }

        return $pascalCaseString;
    }

    public static function strToCamelCase($string): string
    {
        // Remove any non-alphanumeric characters and replace them with a space
        $string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);

        // Convert the string to an array of words
        $words = explode(' ', $string);

        // Initialize the camelCase string
        $camelCaseString = '';

        // Loop through the words
        foreach ($words as $index => $word)
        {
            if (!empty($word))
            {
                if ($index == 0)
                {
                    // The first word should be lowercase
                    $camelCaseString .= strtolower($word);
                }
                else
                {
                    // Capitalize the first letter of subsequent words
                    $camelCaseString .= ucfirst(strtolower($word));
                }
            }
        }

        return $camelCaseString;
    }

    public static function baseUrl($next = ''): string
    {
        return Application::getInstance()->getRootUrl() . $next;
    }

    public static function envRead(string $key): string
    {
        $env = file_get_contents('.env');
        $env = explode("\n", $env);
        foreach ($env as $line)
        {
            $line = explode('=', $line);

            if (count($line) == 2)
            {
                $envKey = trim($line[0]);
                $envValue = $line[1] === null ? '' : trim($line[1]);
                if ($envKey === $key)
                    return $envValue;
            }
        }
        return '';
    }
}