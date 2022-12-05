<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ActionDelete extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:delete {name : Define Delete Api Action Name}';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Delete Api Action Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Delete Api Action Module';
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
        if(Str::contains($name, 'DeleteAction')){
            $name = Str::before($this->argument('name'), 'DeleteAction');
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
        $relativePath = '/../stubs/Api/delete.stub';
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
        if(Str::contains($name, 'DeleteAction')){
            $name = Str::before($this->argument('name'), 'DeleteAction');
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Api\Delete';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Delete Api Action Module Files'],
        ];
    }
}
