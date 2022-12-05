<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class GenerateResponder extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:responder {name : Define Api Responder Name}';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Api Responder Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ResponderModule';
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
        return $stub;
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/../stubs/Api/responder.stub';
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
        $getInput = $this->getArgAction();
        if(Str::contains($name, $getInput)){
            $name = Str::before($this->argument('name'), $getInput);
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Api\\'.$getInput;
    }
    /**
     * Get the action input.
     *
     * @return string
     */
    protected function getArgAction(){
        $name = $this->argument('name');
        $val = '';
        if(Str::contains($name, 'Create')){
            $val = 'Create';
        }elseif(Str::contains($name, 'Delete')){
            $val = 'Delete';
        }elseif(Str::contains($name, 'Edit')){
            $val = 'Edit';
        }elseif(Str::contains($name, 'Fetch')){
            $val = 'Fetch';
        }else{
            $val = 'Index';
        }
        return $val;
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Api Responder Module Files'],
        ];
    }
}
