<?php

namespace Core;

class AutoLoad
{
    public function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public function autoload($class)
    {
        $parts = preg_split('#\\\#', $class);

        $className = array_pop($parts);

        $path = implode(DIRECTORY_SEPARATOR, $parts);
        $file = $className.'.php';

        require ROOT.strtolower($path).DIRECTORY_SEPARATOR.$file;
    }
}