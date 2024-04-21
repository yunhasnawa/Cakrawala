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

    public static function baseUrl($next = ''): string
    {
        return Application::getInstance()->getRootUrl() . $next;
    }
}