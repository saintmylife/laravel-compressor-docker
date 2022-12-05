<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api {name : Define Service Name}
                            {--a|all=default : All Api Resources}
                            {--c|create : Api Create Resources}
                            {--d|delete : Api Delete Resources}
                            {--e|edit : Api Edit Resources}
                            {--f|fetch : Api Fetch Resources}
                            {--i|index : Api Index Resources}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Api Resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Generate Api';

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
            $this->input->setOption('index', true);
        }

        if($this->option('create')){
            $this->apiCreate();
        }
        if($this->option('delete')){
            $this->apiDelete();
        }
        if($this->option('edit')){
            $this->apiEdit();
        }
        if($this->option('fetch')){
            $this->apiFetch();
        }
        if($this->option('index')){
            $this->apiIndex();
        }
        $this->info('Done.');
        $this->line('Api Resources Created Successfully !!!');
        $this->line('');
    }

    /**
     * Generate a Create Module Api.
     *
     * @return void
     */
    protected function apiCreate()
    {
        $create = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('api:create', [
            'name' => "{$create}CreateAction",
        ]);

        $this->callSilent('api:responder', [
            'name' => "{$create}CreateResponder",
        ]);
    }
    /**
     * Generate a Delete Module Api.
     *
     * @return void
     */
    protected function apiDelete()
    {
        $delete = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('api:delete', [
            'name' => "{$delete}DeleteAction",
        ]);

        $this->callSilent('api:responder', [
            'name' => "{$delete}DeleteResponder",
        ]);
    }
    /**
     * Generate a Edit Module Api.
     *
     * @return void
     */
    protected function apiEdit()
    {
        $edit = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('api:edit', [
            'name' => "{$edit}EditAction",
        ]);

        $this->callSilent('api:responder', [
            'name' => "{$edit}EditResponder",
        ]);
    }
    /**
     * Generate a Fetch Module Api.
     *
     * @return void
     */
    protected function apiFetch()
    {
        $fetch = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('api:fetch', [
            'name' => "{$fetch}FetchAction",
        ]);

        $this->callSilent('api:responder', [
            'name' => "{$fetch}FetchResponder",
        ]);
    }
    /**
     * Generate a Fetch Module Service.
     *
     * @return void
     */
    protected function apiIndex()
    {
        $index = Str::studly(class_basename($this->argument('name')));

        $this->callSilent('api:index', [
            'name' => "{$index}IndexAction",
        ]);

        $this->callSilent('api:responder', [
            'name' => "{$index}IndexResponder",
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
            ['name', InputArgument::REQUIRED, 'The name of the Api Module Files'],
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
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a All Api Modules'],
            ['create', 'c', InputOption::VALUE_NONE, 'Generate a Create Api Module'],
            ['delete', 'd', InputOption::VALUE_NONE, 'Generate a Delete Api Module'],
            ['edit', 'e', InputOption::VALUE_NONE, 'Generate a Edit Api Module'],
            ['fetch', 'f', InputOption::VALUE_NONE, 'Generate a Fetch Api Module'],
            ['index', 'i', InputOption::VALUE_NONE, 'Generate a Index Api Module'],
        ];
    }

}
