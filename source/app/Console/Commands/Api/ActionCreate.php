<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ActionCreate extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create {name : Define Create Api Action Name}';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Create Api Action Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Create Api Action Module';
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        if(Str::contains($name, 'CreateAction')){
            $name = Str::before($this->argument('name'), 'CreateAction');
        }
        return str_replace(['{{ arg_name }}'], $name, $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/../stubs/Api/create.stub';
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
        if(Str::contains($name, 'CreateAction')){
            $name = Str::before($this->argument('name'), 'CreateAction');
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Api\Create';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Create Api Action Module Files'],
        ];
    }
}
