<?php

namespace App\Console\Commands\Repository;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class GenerateEloquent extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:eloquent {name : Define Eloquent Repository Module Name}';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Eloquent Repository';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Eloquent Repository';
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(Str::contains($name, 'Eloquent')){
            $name = Str::before($this->argument('name'), 'Eloquent');
        }
        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace(['{{ arg_name }}'], $name, $stub);
        return str_replace(['{{ arg_name_before_elq }}'], $name, $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/../stubs/Repository/eloquent.stub';
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
        if(Str::contains($name, 'RepositoryEloquent')){
            $name = Str::before($this->argument('name'), 'RepositoryEloquent');
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Repository';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the RepositoryEloquent Module Files'],
        ];
    }
}
