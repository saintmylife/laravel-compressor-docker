<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:module {name : Define Module Name}
                            {--a|all=default : Generate All Module Resources} 
                            {--api|api : Generate Api Module Resources} 
                            {--d|domain : Generate Domain Module Resources}
                            {--dto|dto : Generate Dto Module Resource}
                            {--r|repository : Generate Repository Module Resources}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Module Resources';
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->input->setOption('api', true);
            $this->input->setOption('domain', true);
            $this->input->setOption('dto', true);
            $this->input->setOption('repository', true);
        }
        if($this->option('api')){
            $this->createApi();
        }
        if($this->option('domain')){
            $this->createDomain();
        }
        if($this->option('dto')){
            $this->createDto();
        }
        if($this->option('repository')){
            $this->createRepository();
        }
        
        $this->line('All Module Resources Created Successfully !!!');
        $this->line('Enjoy');
        $this->line('');
    }
    /**
     * Call Generator Api Resources.
     *
     * @return void
     */
    protected function createApi()
    {
        $createApi = Str::studly(class_basename($this->argument('name')));

        $this->call('generate:api', [
            'name' => "{$createApi}",
            '-a'
        ]);
    }
    /**
     * Call Generator Domain Resources.
     *
     * @return void
     */
    protected function createDomain()
    {
        $createDomain = Str::studly(class_basename($this->argument('name')));

        $this->call('generate:domain', [
            'name' => "{$createDomain}",
            '-a'
        ]);
    }
    /**
     * Call Generator Dto Resource.
     *
     * @return void
     */
    protected function createDto()
    {
        $createDto = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('generate:dto', [
            'name' => "{$createDto}Dto"
        ]);
    }
    /**
     * Call Generator Domain Resources.
     *
     * @return void
     */
    protected function createRepository()
    {
        $createRepository = Str::studly(class_basename($this->argument('name')));

        $this->call('generate:repository', [
            'name' => "{$createRepository}",
            '-a'
        ]);
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Repository Module Files'],
        ];
    }
        /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate All Module Resources'],
            ['api', 'api', InputOption::VALUE_NONE, 'Generate All Api Module Resources'],
            ['domain', 'd', InputOption::VALUE_NONE, 'Generate All Domain Module Resources'],
            ['dto', 'dto', InputOption::VALUE_NONE, 'Generate a Dto Module Resource'],
            ['repository', 'r', InputOption::VALUE_NONE, 'Generate All Repository Module Resources'],
        ];
    }
}
