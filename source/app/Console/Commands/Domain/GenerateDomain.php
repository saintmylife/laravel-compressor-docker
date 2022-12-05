<?php

namespace App\Console\Commands\Domain;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateDomain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:domain {name : Define Domain Name}
                            {--a|all=default : All Domain Resources}
                            {--c|create : Service Create Resource}
                            {--d|delete : Service Delete Resource}
                            {--e|edit : Service Edit Resource}
                            {--f|fetch : Service Fetch Resource}
                            {--l|list : Service List Resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Domain Resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Generate Domain';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->input->setOption('create', true);
            $this->input->setOption('delete', true);
            $this->input->setOption('edit', true);
            $this->input->setOption('fetch', true);
            $this->input->setOption('list', true);
        }

        if($this->option('create')){
            $this->serviceCreate();
        }
        if($this->option('delete')){
            $this->serviceDelete();
        }
        if($this->option('edit')){
            $this->serviceEdit();
        }
        if($this->option('fetch')){
            $this->serviceFetch();
        }
        if($this->option('list')){
            $this->serviceList();
        }

        $this->createFilter();

        $this->info('Done.');
        $this->line('Domain Resources Created Successfully !!!');
        $this->line('');
    }

    /**
     * Generate a Create Module Service.
     *
     * @return void
     */
    protected function serviceCreate()
    {
        $create = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('service:create', [
            'name' => "{$create}Create",
        ]);
    }
    /**
     * Generate a Delete Module Service.
     *
     * @return void
     */
    protected function serviceDelete()
    {
        $delete = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('service:delete', [
            'name' => "{$delete}Delete",
        ]);
    }
    /**
     * Generate a Edit Module Service.
     *
     * @return void
     */
    protected function serviceEdit()
    {
        $edit = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('service:edit', [
            'name' => "{$edit}Edit",
        ]);
    }
    /**
     * Generate a Fetch Module Service.
     *
     * @return void
     */
    protected function serviceFetch()
    {
        $fetch = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('service:fetch', [
            'name' => "{$fetch}Fetch",
        ]);
    }
    /**
     * Generate a Fetch Module Service.
     *
     * @return void
     */
    protected function serviceList()
    {
        $list = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('service:list', [
            'name' => "{$list}List",
        ]);
    }
    /**
     * Generate a Fetch Module Service.
     *
     * @return void
     */
    protected function createFilter()
    {
        $list = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('generate:filter', [
            'name' => "{$list}Filter",
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
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a All Module Services'],
            ['create', 'c', InputOption::VALUE_NONE, 'Generate a Create Module Service'],
            ['delete', 'd', InputOption::VALUE_NONE, 'Generate a Delete Module Service'],
            ['edit', 'e', InputOption::VALUE_NONE, 'Generate a Edit Module Service'],
            ['fetch', 'f', InputOption::VALUE_NONE, 'Generate a Fetch Module Service'],
            ['list', 'la', InputOption::VALUE_NONE, 'Generate a List Module Service'],
        ];
    }

}
