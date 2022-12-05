<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class GenerateJob extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:job {name : Define Job Module Name} {name_space : Define Namespace of Job Module} {model : Define Model Bind For Job Module Name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Job Resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $name = $this->argument('name');
        $name_space = $this->argument('name_space');
        $model = $this->argument('model');
        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace(['{{ name_arg }}'], $name_space, $stub);
        $stub = str_replace(['{{ model_arg }}'], $model, $stub);
        return str_replace(['{{ model_arg_l }}'], Str::camel($model), $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/stubs/job.stub';
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
        $name = $this->argument('name_space');
        return $rootNamespace.'\Modules\\'.$name.'\Jobs';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The Name of the Job Module Files'],
            ['name_space', InputArgument::REQUIRED, 'The Namespace of the Job Module Files'],
            ['model', InputArgument::REQUIRED, 'The Model Bind of the Job Module Files'],
        ];
    }
}
