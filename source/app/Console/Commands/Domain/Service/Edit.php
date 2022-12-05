<?php

namespace App\Console\Commands\Domain\Service;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class Edit extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:edit {name : Define Edit Module Name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Edit Service Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Edit Service';
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(Str::contains($name, 'Edit')){
            $name = Str::before($this->argument('name'), 'Edit');
        }
        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace(['{{ arg_name }}'], $name, $stub);
        return str_replace(['{{ strtolower(arg_name) }}'], Str::camel($name), $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/../../stubs/Domain/Service/edit.stub';
        return __DIR__.$relativePath;
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $name = $this->argument('name');
        if(Str::contains($name, 'Edit')){
            $name = Str::before($this->argument('name'), 'Edit');
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Domain\Service';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Edit Service Files'],
        ];
    }
}
