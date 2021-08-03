<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MakeProcessor extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:processor {name}';

    protected $type = 'Processor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a processor to run in the list.';


    //location of your custom stub
    protected function getStub()
    {
        return  app_path().'/Console/Stubs/processor.stub';
    }

    //The root location the file should be written to
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Processors';
    }
}
