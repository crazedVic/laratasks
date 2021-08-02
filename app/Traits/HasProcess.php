<?php

namespace App\Traits;

trait HasProcess
{
    public static function process()
    {
        //look for processor inside processor folder
        $class = get_called_class();
        $process = 'App\\Processors\\' . substr($class, strrpos($class, '\\')+1) . 'Processor';

        return $process::run();
    }
}